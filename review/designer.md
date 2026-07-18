# GRAPHIC DESIGNER REVIEW

## What I saw

At 1440px, each hero is a deliberate 8/4 split: a roughly 760px chromatically offset Syne orbit surrounds a cyan photographic aperture on the left, while a tall lunar-chalk thesis panel occupies the right. The display/body/mono pairing is visibly distinct and the page has at least six readable levels—curved display, panel H1, section H2, card H3, body, and coordinate eyebrow—but the desktop H1s break inside words: Home renders “Computa / tional” and “communi / ties,” while Leadership renders “leadershi / p” and “infrastruc / ture.” The solid chalk panel consequently catches the eye before the orbital map despite the map being the larger gesture.

At 375px, the Home orbit fills the width above a much better-wrapped thesis panel, but four dark node labels sit over the circular lettering and the title is clipped at both side edges and at the bottom; it reads as letter fragments rather than `SARA BONELLA — COMPUTATIONAL PHYSICS —`. The marquee, coordinate eyebrows, cyan/pink chromatic offsets, clipped card corners, and dashed trajectories are visible; fine grain is not perceptible. No Research or Outreach screenshot exists to verify the specified halftone halos, and the supplied 2400px captures end mid-page with no numbered continuations, so the late sticker seals and footer wordmark are not pixel-verifiable; polaroid, washi, drop-cap, scribble, and scallop motifs are not commitments in this brief.

## Findings

### Ship blockers (must fix before publish)

- **Desktop hero thesis H1s** — `review/screenshot-home-desktop.png` and `review/screenshot-leadership-desktop.png`, upper-right panels; `docs/index.html:72`–`80` applies `overflow-wrap: anywhere`, while `docs/index.html:493`–`515` confines a 4.25rem H1 to four grid columns — splitting “Computational,” “communities,” “leadership,” and “infrastructure” across arbitrary syllables makes the primary statement look typeset by accident. → Set the hero H1 to normal word wrapping, widen/overlap the panel to five columns or reduce its desktop scale to about 3.5–3.75rem, and author line breaks only at phrase boundaries.
- **Mobile orbital wordmark** — `review/screenshot-home-mobile.png`, top 0–395px; `docs/index.html:373`–`379` retains the 4.25rem minimum ring type while `docs/index.html:1078`–`1087` compresses the disc to the viewport and places four 7.2rem node boxes over it — the brief’s exact signature, “Every page opens with a `clamp(4.25rem, 12vw, 9rem)` Syne 700 title on an inline-SVG circular text path around a central photographic aperture and labeled orbit nodes,” is present but no longer legible at 375px. → Build a mobile-specific SVG/path composition with a larger internal viewBox, controlled start offset, and nodes moved clear of the letterforms so one complete readable arc survives above the panel.

### Important (should fix this revision pass)

- **Desktop hero focal composition** — all three desktop screenshots, first viewport; `docs/index.html:339`–`360` ends the orbit at column 8 and `docs/index.html:493`–`504` starts the chalk panel at column 9, producing two adjacent posters instead of the brief’s role panel that “overlaps the lower-right” of one instrument stage — the dense white rectangle and the white orbital lettering compete at equal visual weight. → Start the panel in column 8 with a modest negative inline offset, lower its top edge, and shorten it after fixing the H1 so the orbit remains the unmistakable first focal point.
- **Mobile research-constellation rhythm** — `review/screenshot-home-mobile.png`, lower half; the section becomes a sequence of same-width purple slabs, and `docs/index.html:1094`–`1096` explicitly hides the trajectory and removes the molecular-card offset — the named “constellation” loses its compositional identity and reads as a generic card stack. → Retain a slim vertical dashed trajectory on mobile, attach category dots to it, and alternate cards by 8–16px to preserve connected orbital rhythm without crowding the column.

### Nice to have (skip if budget tight)

- **Fine-grain texture** — the large abyss-navy fields in every supplied screenshot render visually smooth; `docs/index.html:126`–`133` supplies 4.5% high-frequency noise, but it disappears at screenshot scale — one of the brief’s named unifying motifs is therefore CSS-only rather than a visible pixel treatment. → Keep opacity below 6% but use a coarser, lower-frequency grain tile so the texture survives normal viewing and export.

## Summary for the synthesiser

The type system is strong, but arbitrary mid-word desktop H1 breaks and a node-obscured mobile orbit turn the site’s defining hero from a controlled computational instrument into visibly broken typography.
