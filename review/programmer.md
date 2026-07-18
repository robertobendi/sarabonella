# FRONTEND ENGINEER REVIEW

## What I saw

The 1440px Home capture has a 72px dark header with a roughly 44px SB mark, five uppercase navigation labels, a cyan-edged photographic aperture about 520px across on the left, and a pale role panel about 426px wide on the right. The stable headline is visibly rendered inside that panel while the oversized circular wordmark remains separate around the photograph. At 375px, the header collapses to the mark and a text-labelled `MENU` control; the orbit, then a roughly 343px-wide headline panel, stack in one column, and the research cards follow beneath the marquee.

The Contact and Leadership desktop captures reuse that same split stage; Contact and Leadership each show a cyan underline on the visually active navigation item, and Contact also retains the lime status dot. Only the unnumbered screenshot files exist: Home ends during the research-card field, Contact during the enquiry cards, and Leadership during the network section, so none supplies footer pixels.

## Findings

### Ship blockers (must fix before publish)

- **Static navigation and asset URLs** — `docs/index.html:1168–1185` and `docs/index.html:1210` are representative; all 117 path-based internal `href` values and the shipped image `src` values are rooted at `/sarabonella/`, while the export actually contains sibling files such as `docs/research.html` and no links to any `.html` file — the export is hard-wired to one GitHub Pages repository slug and depends on extensionless server rewrites, so it is not portable static HTML → Rewrite exported URLs as relative file paths such as `./index.html`, `./research.html`, `./research.html#statistical`, and `./uploads/...`.
- **Research hero image payload** — `docs/research.html:1193` loads `docs/uploads/research-hero/dutch_national_supercomputer__huygens____8183833489_png.png`, a 2,878,151-byte 1920×1148 PNG, with no `srcset` or `sizes` — a 375px device must download the same 2.8MB above-the-fold image, making the likely LCP asset unacceptably heavy → Export compressed AVIF/WebP variants at appropriate widths, add `srcset`/`sizes`, and keep only the selected hero candidate eager with `fetchpriority="high"`.

### Important (should fix this revision pass)

- **Home social and structured metadata** — `docs/index.html:10–12` has `og:title`, `og:description`, and `og:type` but no `og:image` (also flagged in `review/POLISH_NOTES.md`), while JSON-LD at `docs/index.html:1146–1148` uses `/` and `/uploads/...` despite the canonical project URL at `docs/index.html:1159` — the share card has no image and the structured-data image resolves outside `/sarabonella/` → Add an absolute canonical `og:image` (plus width, height, and alt metadata) and use the same absolute canonical site/image URLs in the Person JSON-LD.
- **Error page indexing** — `docs/sitemap.xml:21–23` explicitly lists `/sarabonella/404`, `docs/404.html:1142` self-canonicalises it, and every page plants a visually hidden link to it (`docs/index.html:1465`) — this advertises error content for crawling instead of keeping it out of the index → Remove the 404 URL from the sitemap and page footers, add `meta name="robots" content="noindex"`, and ensure unknown routes return HTTP 404.
- **Current-page navigation semantics** — the Contact and Leadership screenshots show a cyan active underline, but their corresponding links at `docs/contact.html:1168` and `docs/leadership.html:1166` have no `aria-current="page"` — current location is conveyed visually but not to assistive technology → Emit `aria-current="page"` on the active primary-nav link on every page.

### Nice to have (skip if budget tight)

- **Language change for the French role title** — the document correctly declares English globally, but `Maître d’Enseignement et de Recherche` is unmarked at `docs/index.html:1230` and `docs/leadership.html:1213` — screen readers may pronounce the French title with an English voice → Wrap the French title in an element with `lang="fr"` wherever it is rendered.

## Summary for the synthesiser

The export’s hard-coded `/sarabonella/` routing and 2.8MB non-responsive research hero are the two frontend failures that must be removed before this can be called portable, performant static HTML.
