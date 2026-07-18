# BUILD_BRIEF — what "done" means

You are building the public face of **robertobendi/sarabonella**. Target: GitHub
Pages, served as a static export of this PebbleStack site.

## Hard requirements

1. **Single theme dir** — work inside `templates/theme/default/`. No new theme dirs.
2. **Inline CSS in layout.twig** — keep PebbleStack's pattern. Google Fonts via `<link>` in `<head>`. Palette + type scale from BRIEF.md.
3. **No JavaScript frameworks**. Vanilla `<script>` only for tiny interactions (mobile menu). Site must render meaningfully with JS disabled.
4. **Discoverable nav** — every public page must be linked from header or footer. The crawler is link-driven; orphan pages won't export.
5. **Collections from BRIEF.md § 4 · Plan** — implement them in `config/collections.php`.
6. **No admin work** — never edit `templates/admin/`.
7. **Real content** — every page must have real, branded copy in BRIEF.md's voice. No lorem ipsum. No "Coming soon".

## Fingerprint — the build must ship every item in BRIEF.md § 6

BRIEF.md § 6 Fingerprint lists 6–10 specific, opinionated, verifiable
design moves the build promised to ship. After you finish, an aesthetic
critic agent session opens the exported HTML and grades EACH item
PRESENT / PARTIAL / MISSING. Two-or-more MISSING items, or two-or-more
generic-AI tells, will bounce the build back to a revision session.

Walk § 6 top to bottom before you export. For each item, identify the
template + class + CSS rule that implements it. If you can't point at
HTML/CSS that satisfies the item, the item isn't shipped yet.

## Distinctiveness floor — the build must clear this

Boring sites are the failure mode this brief exists to prevent.
BRIEF.md § 2 picked an aesthetic family with personality; § 5 picked a
layout signature and a decorative system; § 6 picked a fingerprint.
The exported site must visibly reflect ALL of those choices. The
following are **failures** the build must not ship:

- **Clipped or colliding content** — body copy whose first/last
  character is hidden by an adjacent image or column; display
  headings half-occluded by a hero photo; a vertical sidebar element
  crashing into horizontal type. Asymmetric layouts are great when
  the column math works and broken when it doesn't. This is the
  single most blocking failure mode — TWO gates check for it. A
  DETERMINISTIC headless-browser probe renders each page and reports
  the exact CSS selector overlapping any text whose characters get
  clipped; then the design council's "no clipped or colliding
  content" PASS/FAIL judges the rendered screenshots. Either gate
  failing sends the build back for a focused fix.
- **Single-font stack** — only one Google Fonts family loaded, unless
  BRIEF.md typography explicitly committed to one font (e.g. Brutalist
  Helvetica-only). Most families need 2–3 fonts wired up.
- **No decorative motifs** — zero of the motifs BRIEF.md § 5 Decorative
  system named actually appear in the templates. If § 5 said "polaroid
  frames + washi tape + scribble underline + drop cap", ship at least
  three of those four.
- **Fingerprint misses** — two or more BRIEF.md § 6 items absent from
  the exported HTML. This is the hardest floor — every fingerprint
  item must be implementable; if one is genuinely impossible, edit the
  brief, don't silently skip.
- **Untreated hero photo** — hero `<img>` with no frame, no rotation,
  no halftone, no duotone, no tape, no decoration. Allowed only for
  Slow editorial / Soft modern.
- **Modest display type** — H1/display heading capped at ~3rem
  (~48px). Display should genuinely feel display: 5–9rem with
  `clamp()` for mobile, weight 700+, the family's character.
- **Symmetric grid-of-cards home page** — three identical cards in a
  row with body copy and a CTA each. Use the chosen family's
  vocabulary instead (collage row, marquee, magazine spread).
- **Default decoration only** — every visible ornament is
  `border-radius` + a soft shadow. The decorative system in BRIEF.md
  must show up as actual SVGs, transforms, mix-blend-modes, or texture
  overlays.
- **Generic-AI palette** — `#ffffff` surface + `#000000`/`#111`/`#333`
  ink + ONE muted accent. BRIEF.md § 3 picked named shades; load them
  as CSS custom properties and use them. Body text on pure white is the
  classic giveaway — set the surface to the brief's named shade.

If BRIEF.md picked Slow editorial luxury / Soft modern / Brutalist
(restraint-by-design families), the bullets above bend accordingly —
but the typography, type scale, fingerprint, and imagery must still
commit hard, not ship a tasteful average.

## Imagery — REQUIRED, NOT OPTIONAL

Four tiers, IN PRIORITY ORDER. Do not skip ahead to lower tiers when
higher-tier assets exist.

### 0. uploads/ + ASSETS.md — REAL BRAND ASSETS (already staged)

Bismuth has ALREADY copied the source site's real brand assets into
`uploads/` and written `ASSETS.md` naming the exact root-relative URL
for each. **You do not move or rename them — you place them.** Reference
each by the URL ASSETS.md gives (e.g. `/uploads/logo.png`); the export
adds the GitHub Pages project-path prefix automatically, so NEVER
hardcode the repo name into a URL.

- **Logo** (`/uploads/logo.<ext>`) — on social-media ingest this IS the
  profile picture and almost always the logo. Place the REAL file in the
  `<header>` AND footer at the size the brief picked. Do NOT replace it
  with a generic SVG/text wordmark. A deterministic gate fails the build
  if the staged logo is never referenced.
- **Favicon** (`/uploads/favicon.<ext>`) — wire it up as
  `<link rel="icon" href="/uploads/favicon.<ext>">` in `<head>`.
- **Photos** (`/uploads/img-NN.<ext>`) — real product photos /
  illustrations from the source. Place each per BRIEF.md § 5 · Design →
  Imagery plan (gallery, about photos, hero, blog). None should be
  discarded silently; if one is irrelevant, say so in a single HTML
  comment rather than just dropping it.

If ASSETS.md lists no logo/photos (common for JS-heavy social sources),
fall back to a typographic wordmark + fetched imagery (tiers 1–3 below).
If a staged file is genuinely unfit (corrupt, watermarked, excluded by
the brief), note it in the inline review pass — but the default
disposition is USE IT.

### 1. Real photographs (Wikimedia Commons, no auth) — fill the gaps

When BRIEF.md § 5 calls for an image slot that source/images/ doesn't
cover (e.g. a hero background when only the logo was pulled), fetch
from Wikimedia via `bismuth-tool`:

    ./scripts/bismuth-tool fetch-image "search query" [count] [dest_dir]

Examples — be specific and visual:

    ./scripts/bismuth-tool fetch-image "florist shop interior wood" 3 uploads/
    ./scripts/bismuth-tool fetch-image "rose bouquet pink white" 4 uploads/heroes

The tool saves to `dest_dir` and prints paths. Reference as `/uploads/<name>`.
Generic queries return generic results. Include 2–3 modifiers (color, mood,
material, setting). On social-media rebuilds where the source page
yielded mostly the logo, fetch generously — the rebuild needs hero +
section photography that the social profile didn't expose.

### 2. Inline SVG illustrations

For spot art, icons, decorative dividers, hand-drawn arrows, scallop
borders (see COMPONENTS.md § Decorative kit).

### 3. Color blocks

Only allowed for small accent areas — never the dominant visual slot.

### Hard rules

- Every page MUST use real imagery somewhere — hero minimum.
- The header MUST display the real logo at the `/uploads/logo.<ext>` URL
  ASSETS.md lists, if one was staged; if none was, fall back to a
  typographic wordmark in the brief's Display font. A deterministic gate
  fails the build when a staged logo is never referenced.
- The hero image, when it's a staged photo, is still subject to
  BRIEF.md § 5 Imagery plan's `Treatment` column — wrap it in a
  polaroid frame / duotone / halftone if the brief said so.

## Imagery treatment — apply what BRIEF.md called for

Every image slot in BRIEF.md § 5 Imagery plan has a `Treatment` column:
`polaroid`, `taped`, `duotone(A,B)`, `halftone`, `cutout-shadow`,
`rotated(n)`, `full-bleed`, or `untouched`. **Implement the treatment
the brief named.** Don't downgrade `polaroid` to a plain photo because
it's faster — the treatment is part of how the family reads.

The hero photo on the home page MUST use one of the non-`untouched`
treatments unless the family is Slow editorial / Soft modern. Pick from
`COMPONENTS.md § Decorative kit` for ready-to-use patterns (polaroid,
duotone, halftone, taped).

## Production-readiness — REQUIRED (this is graded)

A beautiful page that isn't production-ready is a failure. Bismuth's
export AUTOMATICALLY handles the mechanical layer for you — absolute
`canonical`/`og:url`/`og:image`, `<html lang>`, `theme-color`, favicon +
apple-touch-icon, image `width`/`height` + lazy-loading, `sitemap.xml`,
and a branded `404.html`. **Do not fight it or hardcode the repo name in
URLs.** Your job is the CONTENT-level hygiene the export can't author —
and a deterministic gate checks each item and bounces the build if it's
missing:

1. **Per-page `<title>`** — unique + descriptive, e.g.
   `Services — Sarabonella`. Not just the site name on every page.
2. **Per-page `<meta name="description">`** — 50–160 chars, in the brand
   voice, describing THAT page. Every public page.
3. **`alt` on every content image** — descriptive, specific (`alt="Anyo
   at Disenyo storefront on Rizal Avenue"`, not `alt="image"`). Use
   `alt=""` ONLY for purely decorative images.
4. **JSON-LD structured data** on the home page —
   `<script type="application/ld+json">` with `Organization` (or
   `LocalBusiness` if it's a physical business): name, url, logo,
   description, and `sameAs` (the social links from
   `source/metadata.json` / `source/text.md`). Add `address`/`telephone`
   ONLY if they're real facts from the source. Never fabricate.
5. **Semantic landmarks** — one `<header>`, one `<main>`, one `<footer>`,
   `<nav>` for navigation. A `skip to content` link as the first focusable
   element (`<a href="#main" class="skip-link">Skip to content</a>` +
   `#main` on the `<main>`).
6. **Open Graph** — set good `og:title` + `og:description` (the export
   fills `og:image`/`og:url` defaults, but author real values).

## Polish — the finish that separates a pro site from a generated one

The site must feel hand-finished, not auto-assembled:

- **Interaction states** — every link, button, and card has a visible
  `:hover` AND a visible `:focus-visible` state (keyboard users must see
  focus). Buttons get `:active`. No "dead" clickable elements.
- **Fluid type** — display/H1 uses `clamp()` so it scales smoothly from
  mobile to desktop; no heading that's huge on desktop and overflowing on
  a phone.
- **Spacing tokens** — define a small set of spacing CSS custom
  properties and reuse them; sections share a consistent vertical rhythm.
- **Reduced motion** — wrap non-essential animation in
  `@media (prefers-reduced-motion: reduce)` and disable it there.
- **Empty/edge states** — if a collection could be empty or have one
  item, the layout must still look intentional (no lone card stranded in
  a 3-col grid; no broken row).
- **Microcopy** — button labels and form helper text read like a real
  brand wrote them, not "Submit" / "Click here".
- **Font loading** — `<link rel="preconnect">` to the font host and
  `display=swap` on Google Fonts so text paints immediately.

## Forms

Per BRIEF.md § 4 · Plan's "Forms" decision. If Formspree placeholder, leave
an HTML comment next to the action telling the user to swap it.

## Build + verify command

Run the export with EXACTLY these credentials (Bismuth tracks them so the
user can log into the local admin later):

    ADMIN_EMAIL="admin@bismuth.local" \
    ADMIN_PASSWORD="bis-E2LHWYCKjqokPz" \
    ADMIN_NAME="Admin" \
    SITE_NAME="Sarabonella" \
    ./scripts/bismuth-tool export-static

This boots `php -S`, runs the headless install with the creds above, and
mirrors the site to `docs/`. If it fails, fix the underlying issue and
re-run.

## Visual self-check — Bismuth's internal toolkit

After the export succeeds, you MAY (sparingly) render the home page to
PNG and look at it before doing your one careful pass against
BRIEF.md § 6. Bismuth provides `bismuth-tool screenshot` for this — it
auto-serves the parent dir of the path you pass and tears down on
exit, so you don't have to babysit a server:

    ./scripts/bismuth-tool screenshot docs/index.html \
        review/build-selfcheck-home.png
    ./scripts/bismuth-tool screenshot docs/index.html \
        review/build-selfcheck-mobile.png 375,2400

Then `Read` the screenshots and check: logo visible? family
recognizable? decorative motifs showing? Mobile holds at 375px?

**Use this AT MOST ONCE** after your main template edits. The post-build
aesthetic critique pass will render and grade the site thoroughly — the
self-check is just to catch screaming failures (missing logo, blank
hero, broken layout) before handing off. Do NOT loop:
render → fix → render → fix; that's what the critique pass is for, and
each browser invocation costs several seconds.

If the toolkit is missing (no Chromium-family browser on this machine),
the screenshot command will fail cleanly — don't try to substitute a
different tool, just skip the self-check.

## Components — USE THESE BEFORE INVENTING

`COMPONENTS.md` in the repo root has known-good HTML patterns for: map,
address card, contact form, image gallery, FAQ, mobile menu, testimonial,
pricing table, hero with image, social links. **Use those patterns**
(adapt classes/copy to the brand) instead of inventing your own.

**Do NOT invent fake interactive widgets.** Specifically:

- No fake maps (drawn as SVG / canvas / divs). Use the OSM iframe pattern
  in COMPONENTS.md if coordinates are known, otherwise the address card.
- No fake charts or graphs with invented numbers.
- No fake calendars showing fake events.
- No fake audio/video players with no real media.
- No fake testimonials with made-up names — use what's in source/text.md.
- No fake "trusted by" logo strips.

When in doubt: REMOVE the section and find a simpler way to occupy the
real estate. Empty space + good typography > fake content.

## QA — what the build must meet

These are the targets the build needs to hit. **Do ONE careful self-review
pass against this list after the export succeeds, then return.** Bismuth
runs deterministic verification against `docs/` after you finish, and
THEN runs a post-build aesthetic critique that grades the site against
BRIEF.md § 6 Fingerprint. Both stages can spawn focused fix/revision
sessions. You do not need to loop; the orchestrator does — but the
better your first pass clears § 6, the less revision is needed.

### Desktop (1440px)

1. **Layout integrity — no clipped or colliding content** — the
   single most important check. For every block of body copy on
   every page, the FIRST and LAST character of every line must be
   fully visible. No hero image, sidebar stamp, decorative element,
   or adjacent column may overlap body text so that characters are
   cut off. No two distinct elements (e.g. a vertical sidebar stamp
   and a horizontal display heading) may claim the same pixels and
   obscure each other. If you've used an asymmetric editorial layout,
   walk it slowly: read every line in the export and confirm nothing
   is occluded. Common fixes: explicit column widths instead of
   "fill the rest", `min-width: 0` on flex children to stop them
   from spilling, `overflow: hidden` / `clip-path` on the type
   container, a CSS grid with named tracks instead of overlapping
   absolute positioning.
2. **Contrast (WCAG AA)** — every text/bg pair. Body ≥ 4.5:1, large
   headings ≥ 3:1. Hunt color-on-color (button text matching bg, link
   too close to body bg, muted text disappearing into surface).
3. **Spacing consistency** — match BRIEF.md § 5 · Design "Spacing &
   rhythm". No section cramped vs others. No collapsed margins between
   adjacent blocks.
4. **Imagery present** — every page has at least one real image.
5. **Hierarchy** — one H1 per page, H2 for sections, H3 within. Type
   sizes follow the design scale.

### Mobile (375px width)

1. **Viewport meta** — `<meta name="viewport" content="width=device-width,
   initial-scale=1">` is present.
2. **No horizontal overflow** — at 375px width, nothing scrolls
   horizontally. Wide images use `max-width: 100%; height: auto`. Long
   words break with `overflow-wrap: anywhere` where needed.
3. **Touch targets ≥ 44×44px** — buttons, nav links, form inputs all
   meet the minimum.
4. **Gutters ≥ 16px** — body text doesn't touch the viewport edge.
5. **Mobile nav** — the desktop nav collapses into a working hamburger
   menu at narrow widths (use the COMPONENTS.md pattern).
6. **Type sizes adapt** — display/H1 should reduce on mobile (use
   `clamp()` or media-query overrides). 8rem headings don't fit on a
   phone.
7. **Forms are usable** — input height, label legibility, no zoom-on-focus
   (set `font-size: 16px` on inputs to prevent iOS auto-zoom).

Make ONE pass through this list, fix what's clearly wrong, re-export if
you changed anything, and STOP. Bismuth's verify pass will report any
remaining defects back to a focused fix session — don't try to chase
perfection here.

## Tone

Use BRIEF.md § 3 · Brand's voice. Don't invent product features the source
didn't have. BRIEF.md § 1 · Analysis "Hard facts to preserve" is
non-negotiable.
