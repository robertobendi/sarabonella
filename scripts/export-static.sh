#!/usr/bin/env bash
# scripts/export-static.sh — produce a static snapshot of this PebbleStack site
# under ./docs so GitHub Pages can serve it. Idempotent: rerun any time.

set -euo pipefail

cd "$(dirname "$0")/.."
ROOT="$(pwd)"

PORT="${PORT:-8765}"
HOST="127.0.0.1"
BASE="http://${HOST}:${PORT}"
DOCS="${ROOT}/docs"

SITE_NAME="${SITE_NAME:-$(basename "$ROOT")}"
ADMIN_EMAIL="${ADMIN_EMAIL:-admin@example.com}"
ADMIN_PASSWORD="${ADMIN_PASSWORD:-pebble-$(openssl rand -hex 8)}"
ADMIN_NAME="${ADMIN_NAME:-Admin}"

require() {
  command -v "$1" >/dev/null 2>&1 || { echo "missing required tool: $1"; exit 1; }
}
require php
require curl
require wget

mkdir -p "${ROOT}/data" "${ROOT}/uploads"

php -S "${HOST}:${PORT}" -t "${ROOT}" >/tmp/pebblestack-export.log 2>&1 &
PHP_PID=$!
cleanup() {
  kill "${PHP_PID}" >/dev/null 2>&1 || true
  wait "${PHP_PID}" 2>/dev/null || true
}
trap cleanup EXIT INT TERM

for _ in $(seq 1 40); do
  if curl -sf -o /dev/null "${BASE}/install" || curl -sf -o /dev/null "${BASE}/"; then
    break
  fi
  sleep 0.25
done

curl -sS -o /dev/null -w "install: HTTP %{http_code}\n" \
  -X POST "${BASE}/install" \
  --data-urlencode "email=${ADMIN_EMAIL}" \
  --data-urlencode "password=${ADMIN_PASSWORD}" \
  --data-urlencode "password_confirm=${ADMIN_PASSWORD}" \
  --data-urlencode "name=${ADMIN_NAME}" \
  --data-urlencode "site_name=${SITE_NAME}" || true

rm -rf "${DOCS}"
mkdir -p "${DOCS}"

echo "Mirroring ${BASE} into ${DOCS} ..."
set +e
wget \
  --recursive --level=8 \
  --convert-links --adjust-extension --page-requisites \
  --no-host-directories \
  --no-verbose \
  --directory-prefix="${DOCS}" \
  --domains="${HOST}" \
  --reject-regex='(/admin|/install|/forms/|/logout|/login)' \
  --tries=2 --timeout=15 \
  "${BASE}/" "${BASE}/sitemap.xml" "${BASE}/robots.txt"
WGET_RC=$?
set -e
if [ "${WGET_RC}" -ne 0 ] && [ "${WGET_RC}" -ne 8 ]; then
  echo "wget failed with exit code ${WGET_RC}"
  exit "${WGET_RC}"
fi

if [ ! -f "${DOCS}/index.html" ]; then
  echo "no index.html exported — check /tmp/pebblestack-export.log"
  exit 1
fi

touch "${DOCS}/.nojekyll"

# GitHub Pages serves this repository under /<repo>/, so every root-relative URL
# the app emits has to be rebased, and the canonical/og tags have to be absolute.
# Doing it here is what makes docs/ reproducible from this script alone: it used
# to be a separate manual pass, which is how the two drifted apart.
BASE_PATH="${BASE_PATH-/sarabonella}"
SITE_URL="${SITE_URL:-https://robertobendi.github.io${BASE_PATH}}"

echo "Rebasing onto ${BASE_PATH} and adding canonical/social tags ..."
php -r '
$docs = $argv[1];
$base = $argv[2] === "" ? "" : "/" . trim($argv[2], "/");
$site = rtrim($argv[3], "/");
// Detail pages live in subdirectories, so the walk has to be recursive.
$walk = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($docs, FilesystemIterator::SKIP_DOTS));
foreach ($walk as $entry) {
    $file = str_replace(DIRECTORY_SEPARATOR, "/", (string) $entry);
    if (substr($file, -5) !== ".html") { continue; }
    $html = file_get_contents($file);

    // Root-relative attributes, but never protocol-relative or absolute ones.
    // wget --convert-links already handles href and src, because it fetched
    // those; it cannot see a path that only ever appears in a data attribute,
    // and the particle field asset is exactly that. Rewriting every attribute
    // catches both and is harmless where wget got there first.
    if ($base !== "") {
        $html = preg_replace("#\b([a-zA-Z-]+)=\"/(?!/)#", "$1=\"" . $base . "/", $html);
    }

    // Canonical follows the page path inside docs/, so a detail page does not
    // claim the same URL as a top-level one with a similar name.
    $rel  = ltrim(substr($file, strlen(str_replace(DIRECTORY_SEPARATOR, "/", $docs))), "/");
    $rel  = substr($rel, 0, -5);
    $page = basename($file, ".html");
    $url  = $site . ($rel === "index" ? "/" : "/" . $rel);

    // Injected once: rerunning the export must not stack duplicate tags.
    if (!str_contains($html, "rel=\"canonical\"")) {
        $tags  = "<link rel=\"canonical\" href=\"" . $url . "\">\n";
        $tags .= "<meta property=\"og:url\" content=\"" . $url . "\">\n";
        $tags .= "<meta property=\"og:site_name\" content=\"Sara Bonella\">\n";
        $tags .= "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
        $html = str_replace("</head>", $tags . "</head>", $html);
    }
    if ($page === "404" && !str_contains($html, "name=\"robots\"")) {
        $html = str_replace("</head>", "<meta name=\"robots\" content=\"noindex, follow\">\n</head>", $html);
    }
    file_put_contents($file, $html);
}
' "${DOCS}" "${BASE_PATH#/}" "${SITE_URL}"

php -r '$docs = $argv[1];
$root = $argv[2];

// wget only fetches what it can see in href/src. Assets named in a data
// attribute, or in an absolute og:image URL, are referenced by the pages but
// never downloaded — the particle field asset and the link-preview card both
// went missing this way. Copy anything referenced but absent.
$walk = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($docs, FilesystemIterator::SKIP_DOTS));
$wanted = [];
foreach ($walk as $entry) {
    $file = str_replace(DIRECTORY_SEPARATOR, "/", (string) $entry);
    if (substr($file, -5) !== ".html") { continue; }
    if (preg_match_all("#uploads/[A-Za-z0-9._/-]+\.[A-Za-z0-9]+#", file_get_contents($file), $m)) {
        foreach ($m[0] as $hit) { $wanted[$hit] = true; }
    }
}

$copied = 0;
foreach (array_keys($wanted) as $rel) {
    $target = $docs . "/" . $rel;
    if (is_file($target)) { continue; }
    $source = $root . "/" . $rel;
    if (!is_file($source)) { fwrite(STDERR, "referenced but not on disk: " . $rel . "\n"); continue; }
    @mkdir(dirname($target), 0777, true);
    copy($source, $target);
    $copied++;
}
echo "Copied " . $copied . " asset(s) referenced only from attributes wget cannot follow.\n";
' "${DOCS}" "${ROOT}"

# wget mirrors sitemap.xml and robots.txt verbatim, so they carry the local
# server origin. Rewrite it to the public one and drop the error page.
php -r '$docs = $argv[1];
$local = rtrim($argv[2], "/");
$site  = rtrim($argv[3], "/");
foreach (["sitemap.xml", "robots.txt"] as $name) {
    $file = $docs . "/" . $name;
    if (!is_file($file)) { continue; }
    $text = file_get_contents($file);
    // wget mirrors these verbatim, so they carry the local server origin.
    $text = str_replace($local, $site, $text);
    // An error page is not a destination.
    $text = preg_replace("#\s*<url>\s*<loc>[^<]*/404</loc>\s*</url>#", "", $text);
    file_put_contents($file, $text);
}
' "${DOCS}" "${BASE}" "${SITE_URL}"

echo "Static export complete: ${DOCS}"
echo "Files: $(find "${DOCS}" -type f | wc -l | tr -d ' ')"
