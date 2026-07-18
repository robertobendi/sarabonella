# UI / INTERACTION REVIEW

## What I saw

The supplied set contains three 1440 × 2400 desktop captures (Home, Contact, and Leadership) and one 375 × 2400 Home capture. Each desktop hero uses a 72px sticky rail, a large orbital image stage on the left, and a pale role panel on the right with a roughly 48px-high primary button. In `screenshot-leadership-desktop.png`, the role-panel headline breaks as “leadershi / p” and “infrastruc / ture”; in the Home research cards, a cyan dashed trajectory is visible through the sentences inside both top cards. The Contact enquiry cards are staggered, with the fourth card crossing the empty lower edge of the second without covering its text.

At 375px, the header becomes a 64px rail with a bordered `MENU` control, the orbital stage stacks above a full-width role panel, and the main CTA spans the panel width. The five orbit labels render as small boxed links around the photo; the track-record ribbon below the hero is captured with the leading digit of “70+” outside the viewport. No numbered continuation screenshots exist, so the mobile capture ends during the second research card and none of the supplied captures reaches the footer. The Contact page renders direct `mailto:` actions rather than a form. Hero photos are visibly duotoned/cropped rather than bare images, and their markup includes intrinsic dimensions.

## Findings

### Ship blockers (must fix before publish)

- **Mobile track-record marquee** — `review/screenshot-home-mobile.png`, immediately below the hero, displays “0+ PEER-REVIEWED ARTICLES” because the leading “7” is clipped at the left edge; `docs/index.html:565–584` combines `overflow: hidden`, `white-space: nowrap`, and a translating max-content track, while the reduced-motion rule at `docs/index.html:1131–1138` stops that track with the remaining metrics still offscreen — key evidence is literally truncated and can become permanently unreachable for reduced-motion users. → Replace the moving ribbon with a static, wrapping three-metric layout at ≤640px and whenever reduced motion is requested.

### Important (should fix this revision pass)

- **Desktop hero headline column** — the right panel in `review/screenshot-home-desktop.png` breaks “Computational” as “Computa / tional” and “communities” as “communi / ties”; `review/screenshot-leadership-desktop.png` breaks “leadership” as “leadershi / p” and “infrastructure” as “infrastruc / ture”; `docs/index.html:72–76, 493–515` applies `overflow-wrap: anywhere` inside a narrow four-column panel — the overflow safeguard is destroying word integrity at the rendered desktop width. → Remove `overflow-wrap: anywhere` from display headings and widen the hero panel or lower its desktop font clamp until headings wrap only between words.

- **Mobile orbit-node links** — the five controls around the image in `review/screenshot-home-mobile.png` are about 36px tall with roughly 8px labels; `docs/index.html:1074–1087` explicitly sets `.orbit-node` to `min-height: 36px` and `font-size: .5rem`, below a 44 × 44px touch target and below comfortable mobile reading size. → Give every orbit node at least a 44px hit box and a 12px label, then reposition the nodes to preserve separation from the ring.

- **Research-card trajectory** — in `review/screenshot-home-desktop.png`, cyan dashes run through “the statistical structure behind molecular trajectories” and “effects and time-dependent observables computationally accessible”; `docs/index.html:597–605, 643–652` places the trajectory behind cards whose background is only 64% opaque, allowing decoration to compete with paragraph glyphs. → Route the trajectory through the grid gaps or add an opaque backing layer beneath each card’s text so no path is visible under copy.

- **Secondary hero action** — “ENTER THE RESEARCH MAP” in the lower part of the pale panel in `review/screenshot-home-mobile.png` reads like a coordinate caption rather than a control; `docs/index.html:299–310` removes its underline and gives it no boundary or conventional arrow, with motion appearing only on hover. → Render secondary actions as underlined text links with a persistent directional arrow, or as a visibly outlined secondary button while retaining the 44px hit area.

- **Mobile evidence-source labels** — the three lines below the ribbon in `review/screenshot-home-mobile.png` render as very small uppercase text at 375px; `docs/index.html:585–595` fixes them at `.65rem` (about 10.4px). → Raise mobile source/meta text to at least `.75rem` with a relaxed line-height and spacing that keeps each source readable without zoom.

### Nice to have (skip if budget tight)

- **Card hover contract** — `docs/index.html:597–614` moves and highlights the entire research/publication/instrument card on hover, but only the inner `.card-link` is clickable (`docs/index.html:632–640`) — the hover response implies a larger clickable surface than the DOM provides. → Either make the whole card the link or limit movement/highlight feedback to the actual linked control.

- **Mobile menu close state** — `review/screenshot-home-mobile.png` shows a discoverable, adequately sized `MENU` button, and `docs/index.html:1471–1478` confirms it toggles the panel, but the visible label never changes when open and there is no Escape/outside-tap close behavior. → Change the control to a stateful “Menu/Close” label and add Escape and outside-tap dismissal.

## Summary for the synthesiser

The revision must first stop the mobile evidence ribbon from clipping and stranding metrics, then repair the too-small orbit controls and desktop hero wrapping that currently breaks words into individual fragments.
