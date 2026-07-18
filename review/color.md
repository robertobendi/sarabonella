# COLOUR REVIEW

## What I saw

The desktop and mobile home captures sit on an almost-black blue field: eyedropped surface pixels cluster at `#0A0D1B` and `#0B0E1C`, the grain-lifted rendering of the brief's `#070A18` Abyss navy. The large role panel is exactly `#F5F2FF` Lunar chalk rather than white; on desktop it occupies roughly the right third of the hero, while on mobile it becomes a near-full-width pale-lilac slab. The orbital wordmark is chalk with cyan/violet offsets, the aperture is strongly cyan-duotoned, and the primary CTA renders around `#5D4DFF`; pink appears in the panel rail and quantum-card edge, while lime appears in the Contact status light, CTA arrow, marquee figures, and molecular-card edge.

The Contact and Leadership captures repeat the same palette: cyan trajectories and active-nav rules, translucent plum cards around `#201845`–`#281A4B`, chalk body text, and category edges in cyan, pink, lime, and violet. Muted copy renders as a noticeably lighter blue-gray than the brief's `#6E789B`, matching the added `#AAB4D5` readable-slate token. Only single 2400px captures were present—no numbered continuation segments—so each page stops before its footer.

## Findings

### Ship blockers (must fix before publish)

- **Violet card metadata** — `screenshot-contact-desktop.png`, lower-right `E.04 / PROGRAMMES` card; `docs/contact.html:618`, `docs/contact.html:624`, `docs/contact.html:629`, and `docs/contact.html:1254`–`1255` — the 0.7rem label renders at about `#5D4DFF` on `#281A4B`, only `2.96:1` against the required `4.5:1`; the same `accent-violet` pattern recurs on Home, Research, and Publications cards.
  → Add a foreground-only token such as `--ultraviolet-readable: #8C82FF` (about `5.04:1` on the rendered card) for small violet text, retaining `#5B4BFF` for CTA fills and decorative edges.

- **Focus colour on Lunar-chalk panels** — `screenshot-home-desktop.png`, chalk hero panel; `docs/index.html:97`–`100` and `docs/index.html:501` — the global `#00D9FF` outline lands on the exact `#F5F2FF` panel around the CTA and secondary link, a `1.54:1` pair that fails the `3:1` focus-indicator contrast requirement and becomes especially weak when the CTA hovers cyan.
  → Override focus indicators on chalk panels with ultraviolet or Abyss navy at at least `3:1`, while retaining ion cyan for focus on dark surfaces.

### Important (should fix this revision pass)

None.

### Nice to have (skip if budget tight)

None.

## Summary for the synthesiser

The named navy/chalk/four-neon palette is unusually faithful in the pixels, but shipping still requires a readable violet text tint and a dark-surface-aware/light-surface-aware focus-colour pair.
