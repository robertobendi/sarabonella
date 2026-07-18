# REVIEW

## Visual evaluation

### What I saw

Across the three desktop captures, the eye lands first on the lunar-chalk thesis panel, not the larger orbit: it is the brightest solid mass, and its oversized Syne headline dominates the photographic aperture. The abyss-navy field, chromatic circular lettering, duotone scientific/location imagery, mono coordinates, and lime/cyan/pink/violet accents immediately read as a Y2K scientific instrument, but the primary statements look mechanically fitted: Home breaks “Computational” and “communities” within words, while Leadership leaves single-letter fragments from “leadership” and “infrastructure.”

Below the Home hero, the marquee arrives with its first numeral clipped, then a confident split heading gives way to plum chamfered cards whose dashed path visibly runs through paragraph glyphs. At 375px the orbital title is cropped at both sides and beneath four overlapping node labels; the thesis panel itself becomes more readable, but it pushes the first primary CTA to roughly y=1,020 and the evidence sequence becomes a long stack. Contact and Leadership preserve the family, yet none of the supplied 2400px captures reaches a footer, so that final composition is source-verified rather than pixel-verified.

### Visual pass/fail checks

- **No clipped or colliding content** — **FAIL.** In screenshot-home-mobile.png below the hero, “70+ PEER-REVIEWED ARTICLES” loses its leading “7,” while in screenshot-home-desktop.png the cyan dashed trajectory crosses “the statistical structure behind molecular trajectories” and “time-dependent observables computationally accessible.”
- **Logo visible in header** — **PASS.** The 40–44px SB orbit mark and SARA BONELLA lockup are clearly visible at the upper-left of the Home and Contact desktop headers, with the compact mark retained on mobile.
- **First-glance family recognizable** — **PASS.** Every first viewport reads immediately as a dark Y2K scientific instrument through the rotating orbital type, cyan-duotone aperture, node labels, and mono coordinate language.
- **Decorative system visible** — **PASS.** The chromatic orbit, dashed trajectories, capsule marquee, halftone field, chamfered corners, and neon offsets provide far more than the required two visible motifs.
- **Source imagery placed** — **PASS.** No source/images directory existed, and the shipped real EPFL, Lausanne, and scientific-infrastructure photographs are visibly used and accurately captioned rather than replaced by generic portrait stock.
- **Mobile holds** — **FAIL.** In screenshot-home-mobile.png the ring title is cropped and obscured, orbit links are tiny, the CTA falls around y=1,020, and the marquee clips its key metric before the long single-column card stack begins.
- **Production polish** — **FAIL.** The Home and Leadership desktop hero headings split words into fragments, the Home connector crosses card copy, and no supplied capture reaches the footer, leaving the visible finish below portfolio standard despite consistent section spacing and genuinely large display type.
- **Interaction + a11y finish** — **FAIL.** docs/index.html defines hover and focus-visible states, a skip link, and one main landmark, but the global cyan focus outline is only 1.54:1 against lunar-chalk panels and therefore is not a visibly finished focus state.

## Council consolidation

- **Designer**: The defining hero is broken at both breakpoints—mid-word desktop headings and a cropped, node-obscured mobile orbit (designer + UI).
- **UX**: The conversion funnel is not launch-ready because the mobile CTA misses the first viewport and every decisive mailto uses an address still marked for verification.
- **UI**: The evidence marquee clips and can strand metrics under reduced motion, while undersized orbit controls and translucent card layering damage legibility.
- **Colour**: The named neon palette is faithful, but violet metadata at 2.96:1 and cyan focus on chalk at 1.54:1 are accessibility blockers.
- **Programmer**: The static export is tied to /sarabonella/ extensionless paths and ships a 2.8MB non-responsive research hero, with secondary metadata, indexing, and current-page semantics still unfinished.

## Prioritised findings

### Must fix (revision will close these)

- **Desktop hero headlines** — Home and Leadership upper-right panels render “Computa / tional,” “communi / ties,” “leadershi / p,” and “infrastruc / ture” — global overflow-wrap: anywhere inside a four-column panel destroys word integrity — remove that rule from display headings, widen/overlap the panel or reduce its desktop clamp, and author breaks only at phrase boundaries.
- **Mobile orbital hero and first action** — screenshot-home-mobile.png from y=64–1,020 shows cropped circular lettering, four labels over glyphs, 36px/0.5rem node controls, and no primary CTA in the first viewport — the signature becomes illegible and the primary funnel fails — build a mobile-specific SVG/viewBox and node layout, give links at least 44×44px with 12px labels, and place the name, compact value proposition, and CTA before or over the orbit.
- **Track-record ribbon** — screenshot-home-mobile.png displays “0+ PEER-REVIEWED ARTICLES,” and the reduced-motion rule freezes a max-content track with later metrics offscreen — core evidence is clipped and can become unreachable — replace animation with a static wrapping three-metric layout at ≤640px and under prefers-reduced-motion.
- **Published contact route** — BRIEF.md marks sara.bonella@epfl.ch “[verify],” while every CTA/footer mailto uses it and contact.html publicly exposes “final owner check before public launch” — the decisive endpoint is unconfirmed and internal QA copy is live — confirm the address from an owner or official directory, update all occurrences consistently, and remove the verification notices; otherwise use a verified institutional route.
- **Accessible neon tokens** — the Contact E.04 violet metadata measures 2.96:1 on plum and cyan focus measures 1.54:1 on chalk — small text and focus indication fail required contrast — add a lighter foreground-only violet token and surface-aware focus colors, retaining cyan on dark surfaces and using ultraviolet or abyss navy on chalk.
- **Static-export URLs** — the export contains sibling .html files but 117 internal href/src paths are rooted at /sarabonella/ and depend on extensionless rewrites — the build is hard-wired to one GitHub Pages slug and is not portable — emit relative .html and upload paths in the static export while preserving CMS routes in the Pebblestack templates.
- **Research hero payload** — research.html loads a 2,878,151-byte 1920×1148 PNG above the fold with no srcset, sizes, or modern variants — mobile devices pay the full LCP cost — export AVIF/WebP widths, add srcset/sizes, and mark only the chosen hero eager with fetchpriority="high".
- **Research trajectory layering** — screenshot-home-desktop.png shows cyan dashes crossing two research-card sentences because the cards use a 64%-opaque plum background over the connector — ornament competes with body copy and triggers the collision failure — route the trajectory through grid gaps or add an opaque text backing so no stroke touches glyphs.

### Defer

- **Home proof order and metric substantiation** — selected papers begin only after five research cards and the 70+/60+/25+ claims have neither dates nor inspectable sources — leadership proof arrives late and the figures cannot be audited — in a later pass, move a compact proof band directly after the ribbon and add “as of” dates plus CV/ORCID/event links.
- **Secondary-action contract** — “ENTER THE RESEARCH MAP” reads like a coordinate caption and whole-card hover motion exceeds the actual linked area — clickable scope is ambiguous — later give text actions a persistent underline/arrow and either link the full card or confine hover feedback to its link.
- **Mobile constellation and menu refinement** — the trajectory is removed and card offsets are flattened, while the Menu label never becomes Close and lacks Escape/outside-tap dismissal — mobile loses orbital rhythm and menu-state clarity — later restore a slim vertical connector with modest alternation and add complete close behavior.
- **Social metadata and error indexing** — Home lacks og:image, JSON-LD image URLs do not match the canonical base, and 404 is self-canonicalized and listed in the sitemap — sharing and crawl hygiene are unfinished — later add canonical social imagery and structured URLs, remove 404 from the sitemap/footer, and mark it noindex with a real 404 response.
- **Current-page and language semantics** — active navigation is visual only and the French role title lacks lang="fr" — screen readers miss current location and may mispronounce the title — later emit aria-current="page" and wrap the French phrase with the correct language attribute.
- **Microcopy and fine texture** — the final Home maxim and “Outreach” label are vague, while the 4.5% grain disappears at screenshot scale — these details weaken specificity without blocking use — later sharpen the invitation, consider “Outreach & training,” and use a slightly coarser sub-6% grain.

## Fingerprint check

- **1. Rotating chromatic circular hero type** — **PRESENT.** All six built pages contain inline SVG textPaths in an orbit-rotor, with Syne 700 at clamp(4.25rem, 12vw, 9rem), violet/cyan offsets, and a 24s linear loop.
- **2. Home EPFL aperture with five research nodes** — **PRESENT.** Both Home captures show the cyan-duotone circular EPFL photograph, cyan cutout shadow, and five named nodes around the orbit.
- **3. Full-width 70+/60+/25+ data ribbon** — **PARTIAL.** The required Space Mono sequence, cyan rules, repetition, and 28s loop exist, but the leading “7” is clipped on mobile and the reduced-motion state strands later metrics.
- **4. Coordinate eyebrows on major H2s** — **PRESENT.** “01 / RESEARCH FIELD,” “06 / ENQUIRY ORBIT,” and equivalent cyan Space Mono labels visibly precede major section headings.
- **5. Chamfered category-edge cards** — **PRESENT.** Research and enquiry cards use the exact 24px clip-path corner, slate border, and cyan/pink/lime/violet 4px edges rather than rounded rectangles.
- **6. Dashed inter-section trajectories** — **PRESENT.** Ion-cyan 4 10 dashed SVG paths visibly leave each captured hero and continue into the first evidence field, with the same shared component present on all six pages.
- **7. Halftone halos and fine grain** — **PRESENT.** Shared source defines the 12px radial-dot halo and 4.5% grain, and Research/Outreach markup includes the stage halo, although those two hero pixels were not supplied.
- **8. Header status, active underline, and compact SB mark** — **PRESENT.** The 42px inline orbit logo, 7px lime Contact dot, and 2px cyan active underline are visible in the desktop headers and the mark survives mobile.
- **9. Outlined footer wordmark and contact seal** — **PRESENT.** Source defines the 9vw outlined SARA BONELLA wordmark on plum and a pink seal at -7deg; no supplied screenshot reaches it for pixel verification.
- **10. Reduced-motion final state** — **PARTIAL.** A single reduced-motion block stops orbit, marquee, mesh, trajectory animation, and transitions, but freezing the max-content marquee does not leave all three evidence figures visible.

## Generic-AI tells

- **Centered hero on white over generic stock photo** — **ABSENT.** The hero is an asymmetric dark orbital instrument with a context aperture and stable side panel.
- **Only Inter / Inter + Lora loaded as fonts** — **ABSENT.** The brief-specified Syne, IBM Plex Sans, and Space Mono trio is loaded.
- **Palette is 3 neutrals + 1 muted accent** — **ABSENT.** Abyss navy and lunar chalk support four visibly distinct neon accents with repeatable roles.
- **H1 / display capped near 3rem (no real display type)** — **ABSENT.** Circular display type reaches 9rem/12vw and the panel H1 reaches 4.25rem.
- **Three identical cards as the home page's primary content** — **ABSENT.** Home uses five asymmetrically placed, category-coded constellation cards plus evidence bands.
- **All decoration is border-radius + soft shadow** — **ABSENT.** Orbits, textPaths, trajectories, halftone dots, chamfers, marquee rules, chromatic offsets, and sticker seals form the ornament.
- **Modular scale 1.25 with body-sized H1** — **ABSENT.** The type hierarchy ranges from mono captions through 4.25rem H1s to a 9rem circular display.
- **Logo missing or replaced by generic SVG when og-image existed** — **ABSENT.** No source og-image existed, and the brief-requested custom SB orbit mark and text lockup are visible.
- **Real source imagery dropped (source/images/* unused)** — **ABSENT.** No source/images assets existed; the shipped EPFL, Lausanne, journal, outreach, and HPC photographs are integrated contextually.
- **Decorative kit unused — all ornament is CSS only** — **ABSENT.** No external kit existed, and the brief’s inline-SVG orbit, trajectories, halftone fields, marquee, and sticker seals are all implemented as a coherent system.

## Overall

This is mediocre precisely where it must be controlled: the defining hero is typeset carelessly, the mobile funnel clips both identity and proof, and the published contact path is explicitly unverified. The identity itself is unusually specific and the dark Y2K scientific system has real authorship, but the current build turns its signature into an obstacle while shipping obvious portability, performance, collision, and contrast failures. I would not sign my name to this as a design-portfolio piece until the eight blockers above are closed.

## Verdict

verdict: revise
