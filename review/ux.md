# UX REVIEW

## What I saw

The 1440×2400 home capture opens with five concrete header links, an orbital photograph with five research labels, and a pale role panel naming Sara Bonella, her computational-physics territory, both EPFL/CECAM roles, and a “Discuss collaboration” CTA. A track-record ribbon follows with “70+ peer-reviewed articles,” “60+ invited talks,” and “25+ international events”; the capture then enters the research-card sequence and stops before the later publications, leadership evidence, final invitation, and footer.

At 375px, the orbital visual occupies the first roughly 460px, the identity/value panel follows, and the first CTA does not appear until roughly y=1,020; by y=2,400 the capture is still inside the second research card. The contact capture repeats the same hero model with “Write to Sara” and four enquiry routes below it, while the leadership capture carries forward Bonella’s role and an “Issue an invitation” action; no numbered screenshot segments exist, so the remaining below-fold sequence and footer were verified in the HTML.

## Findings

### Ship blockers (must fix before publish)

- **Mobile home hero / primary CTA** — `review/screenshot-home-mobile.png` (top through y≈1,020) and `docs/index.html:1046–1049` show the orbital visual ordered before the identity panel, with “Discuss collaboration” appearing only after the long headline, deck, and role list — a first-time mobile visitor gets the subject but no immediate next action in the first viewport, directly failing the brief’s before-first-scroll funnel → Put the name, compact value proposition, and primary contact action before or over the orbital visual on mobile so all three land within the first viewport.
- **Primary contact endpoint** — `BRIEF.md` §1 marks `sara.bonella@epfl.ch` `[verify]`, yet `docs/index.html:1232` and the site-wide footer use it as the decisive mailto action, while `docs/contact.html:1271` exposes the internal sentence “The email route is deliberately flagged for a final owner check before public launch.” — the site’s single conversion route is neither confirmed nor presented as launch-ready, which breaks both trust and task completion → Obtain owner/official-directory confirmation, update every mailto consistently, and remove the internal verification note before publishing; if confirmation is unavailable, route users to a verified institutional contact channel instead.

### Important (should fix this revision pass)

- **Home proof sequence** — `review/screenshot-home-desktop.png` ends amid the research constellation and `review/screenshot-home-mobile.png` is still in its second card at y=2,400, while the first auditable paper/leadership evidence does not begin until `docs/index.html:1335` after five research cards and the “Researcher / institution-builder” section — evaluators and funders must traverse a long taxonomy before seeing evidence for the leadership credibility the brief promises within one minute → Move a compact “Selected papers / leadership now” proof band directly after the track-record ribbon, then invite deeper exploration of the five research areas.
- **Above-fold enquiry scent** — the only home hero action is “Discuss collaboration” (`docs/index.html:1232`), although the primary objective explicitly includes speaking, supervision, and institutional work and the four distinct routes appear only on `docs/contact.html:1236–1258` — conference organizers and prospective supervisees are forced to guess whether the main action is for them → Rename the action to “Choose an enquiry route” or pair it with one short line listing collaboration, speaking, supervision, and institutional work.
- **Track-record substantiation** — the prominent metric ribbon in `review/screenshot-home-desktop.png` is followed only by the unlinked labels “supplied academic CV,” “international meetings & schools,” and “conferences, workshops & training” (`docs/index.html:1250–1253`) — the claims look authoritative but are not inspectable or dated by the academic audience asked to rely on them → Add an “as of” date and link each claim to the relevant publications, talks/events record, ORCID, or a dated CV.

### Nice to have (skip if budget tight)

- **Final home invitation copy** — “A strong collaboration begins with a precise question.” (`docs/index.html:1396`) is a generic maxim at the moment the visitor needs a concrete reason to act → Replace it with a specific promise about what context Bonella can evaluate or what next decision the exchange will enable.
- **Outreach navigation label** — “Outreach” appears alone in both header and footer (`docs/index.html:1184` and `docs/index.html:1448`), while the destination covers public science, training, comics, and participation — its information scent is weaker than the other academic labels → Rename it “Outreach & training” so the destination is legible before opening it.

## Summary for the synthesiser

The academic proposition is clear, but the primary contact funnel is not ship-ready: its action falls beyond the mobile first viewport and every decisive CTA points to an email address the brief still marks unverified.
