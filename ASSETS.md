# Staged brand assets

Bismuth already copied the source site's REAL brand assets into
`uploads/` at the paths below. Reference them by the **URL** column
exactly — root-relative, e.g. `/uploads/logo.png`. The static export
rewrites these to the GitHub Pages project path automatically, so
do NOT hardcode the repo name and do NOT move or rename these files.

## Logo

No logo asset was pulled from the source. Fall back to a
typographic wordmark in the brief's Display font.

## Photos

No in-page photos were pulled from the source (common for
social/SPA sources). Fetch hero + section imagery with
`./scripts/bismuth-tool fetch-image "…" 3 uploads/`.
