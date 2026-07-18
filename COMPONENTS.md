# Components — known-good HTML patterns

When BRIEF.md or BUILD_BRIEF calls for one of these, USE THE PATTERN HERE
verbatim (adapt classes/copy to the brand) instead of inventing your own.
Especially: **do not draw fake versions of interactive widgets** (maps,
calendars, charts, audio players, etc.). Either use the real component or
omit it entirely.

If a section in BRIEF.md needs a component you don't see here, prefer
"omit and replace with simpler content" over "invent a fake".

---

## Map — real, free, no key (OpenStreetMap iframe)

```html
<figure class="map-block">
  <iframe
    src="https://www.openstreetmap.org/export/embed.html?bbox=9.0739%2C45.8067%2C9.0939%2C45.8167&layer=mapnik&marker=45.8117%2C9.0839"
    width="100%"
    height="380"
    style="border:0;"
    loading="lazy"
    title="Map — Maspes Piante e Fiori, Como"
  ></iframe>
  <figcaption class="address-card">
    <strong>Maspes Piante e Fiori</strong><br>
    Via Esempio 12, 22100 Como (CO)<br>
    <a href="https://www.openstreetmap.org/?mlat=45.8117&mlon=9.0839#map=16/45.8117/9.0839" target="_blank" rel="noopener">Open in OpenStreetMap</a>
    &middot;
    <a href="https://maps.apple.com/?ll=45.8117,9.0839&q=Maspes+Piante+e+Fiori" target="_blank" rel="noopener">Apple Maps</a>
  </figcaption>
</figure>
```

How to compute the `bbox` and `marker`: take `lat,lon` of the business
(from ANALYSIS.md hard facts), spread ±0.01 in each direction for the
bbox. If you don't know the coordinates, **use the address card alone**
(below) — better than a fake map.

## Address card — no map, just the info

```html
<aside class="address-card">
  <h3>Visit us</h3>
  <address>
    Maspes Piante e Fiori<br>
    Via Esempio 12, 22100 Como (CO)<br>
    <a href="tel:+390310000000">+39 031 000 0000</a><br>
    <a href="mailto:info@maspesfiori.it">info@maspesfiori.it</a>
  </address>
  <p>
    <a href="https://maps.apple.com/?q=Maspes+Piante+e+Fiori+Como" target="_blank" rel="noopener">Get directions</a>
  </p>
</aside>
```

## Contact form — Formspree placeholder (static-site-compatible)

```html
<!-- Replace REPLACE_ME with your Formspree endpoint: https://formspree.io/f/xxxxxxxx -->
<form action="https://formspree.io/f/REPLACE_ME" method="POST" class="contact-form">
  <label>
    <span>Name</span>
    <input name="name" type="text" required>
  </label>
  <label>
    <span>Email</span>
    <input name="email" type="email" required>
  </label>
  <label>
    <span>Message</span>
    <textarea name="message" rows="5" required></textarea>
  </label>
  <input type="text" name="_hp" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px;" aria-hidden="true">
  <button type="submit">Send</button>
</form>
```

If a Formspree endpoint isn't supplied, swap the whole form for a
`mailto:` link + plain address.

## Image gallery — CSS grid, no JS

```html
<section class="gallery">
  <figure><img src="/uploads/img-01.jpg" alt="Description"></figure>
  <figure><img src="/uploads/img-02.jpg" alt="Description"></figure>
  <figure><img src="/uploads/img-03.jpg" alt="Description"></figure>
</section>
```

```css
.gallery {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 12px;
}
.gallery img {
  width: 100%;
  height: 100%;
  aspect-ratio: 4 / 3;
  object-fit: cover;
}
```

## FAQ — semantic, no JS

```html
<section class="faq">
  <details>
    <summary>Do you deliver outside the city?</summary>
    <p>Yes — within 30km, same-day if ordered before 11am.</p>
  </details>
  <details>
    <summary>Can I order by phone?</summary>
    <p>Always: <a href="tel:+390310000000">+39 031 000 0000</a>.</p>
  </details>
</section>
```

## Mobile menu — vanilla JS, ~20 lines

```html
<header class="site-header">
  <a href="/" class="brand">Maspes</a>
  <button class="menu-toggle" aria-controls="primary-nav" aria-expanded="false">Menu</button>
  <nav id="primary-nav" class="primary-nav">
    <a href="/">Home</a>
    <a href="/composizioni">Composizioni</a>
    <a href="/contatti">Contatti</a>
  </nav>
</header>

<script>
  const t = document.querySelector('.menu-toggle');
  const n = document.querySelector('#primary-nav');
  t && t.addEventListener('click', () => {
    const open = t.getAttribute('aria-expanded') === 'true';
    t.setAttribute('aria-expanded', String(!open));
    n.classList.toggle('open');
  });
</script>
```

Show `.primary-nav` inline at desktop, collapse at mobile via `@media (max-width: 720px)`. Show `.menu-toggle` only at mobile.

## Testimonial / pull quote

```html
<blockquote class="testimonial">
  <p>"They've been our florist for fifteen years. Corrado remembers what we ordered last Easter."</p>
  <cite>— Famiglia Rossi, cliente dal 2010</cite>
</blockquote>
```

Use real reviews from `source/text.md` when present. Don't fabricate.

## Pricing table — semantic

```html
<table class="pricing">
  <caption>Rose composition prices</caption>
  <thead><tr><th>Quantity</th><th>Price</th></tr></thead>
  <tbody>
    <tr><td>6 roses</td><td>€18</td></tr>
    <tr><td>9 roses</td><td>€25</td></tr>
    <tr><td>12 roses</td><td>€32</td></tr>
    <tr><td>24 roses</td><td>€60</td></tr>
  </tbody>
</table>
```

## Hero with full-bleed image + overlay

```html
<section class="hero" style="background-image: url('/uploads/hero.jpg');">
  <div class="hero-overlay">
    <h1>Fiori di Como dal 1954</h1>
    <p>Rose, bouquet, piante e composizioni preparate a mano da Corrado e consegnate a domicilio.</p>
    <a class="cta" href="/composizioni">Vedi le composizioni</a>
  </div>
</section>
```

```css
.hero {
  min-height: 70vh;
  display: flex;
  align-items: flex-end;
  background-size: cover;
  background-position: center;
}
.hero-overlay {
  background: linear-gradient(0deg, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0) 60%);
  width: 100%;
  padding: 4rem 2rem;
  color: #fff;
}
```

## Social links — footer block

```html
<ul class="social">
  <li><a href="https://instagram.com/handle" target="_blank" rel="noopener">Instagram</a></li>
  <li><a href="https://facebook.com/handle" target="_blank" rel="noopener">Facebook</a></li>
</ul>
```

Only include channels the business actually has. **Don't invent social
profiles.** If you don't see one in source/text.md, omit.

## Logo in header — brand lockup

The real brand logo lives at `source/images/og-image.<ext>` after ingest
(profile picture for social-media sources, OG image for owned sites).
BRIEF.md § 3 · Brand → Logo asset names the file + size. Move it into
`uploads/` and reference it from the header. **Do not redraw a generic
SVG wordmark when a real bitmap logo exists.**

### Logo + wordmark (default)

```html
<header class="site-header">
  <a class="brand" href="/">
    <img src="/uploads/logo.png" alt="" class="brand__mark">
    <span class="brand__name">Business Name</span>
  </a>
  <nav>…</nav>
</header>
```

```css
.brand { display: flex; align-items: center; gap: 0.6rem; text-decoration: none; }
.brand__mark { height: 44px; width: auto; display: block; }
.brand__name {
  font-family: var(--font-display);
  font-size: 1.25rem;
  letter-spacing: -0.01em;
  color: var(--ink);
}
@media (max-width: 600px) {
  .brand__mark { height: 36px; }
  .brand__name { font-size: 1.0625rem; }
}
```

### Logo-only (when og-image already contains the wordmark)

```html
<header class="site-header">
  <a class="brand brand--solo" href="/">
    <img src="/uploads/logo.png" alt="Business Name" class="brand__mark">
  </a>
  <nav>…</nav>
</header>
```

```css
.brand--solo .brand__mark { height: 56px; }
```

### Wordmark-only (no real logo bitmap, family demands typography)

```html
<header class="site-header">
  <a class="brand brand--wordmark" href="/">
    <span class="brand__name">Business Name</span>
  </a>
  <nav>…</nav>
</header>
```

```css
.brand--wordmark .brand__name {
  font-family: var(--font-display);
  font-size: 1.65rem;
  font-weight: 700;
  letter-spacing: -0.02em;
}
```

Only use the wordmark-only variant when `source/images/og-image.*` does
NOT exist OR BRIEF.md § 3 explicitly opted for full-rebrand wordmark.

## Image treatments — apply per BRIEF.md § 5 Imagery plan

BRIEF.md § 5 Imagery plan's `Treatment` column names one of:
`polaroid`, `taped`, `duotone(A,B)`, `halftone`, `cutout-shadow`,
`rotated(<deg>)`, `full-bleed`, `untouched`. Polaroid/taped/marquee/
halftone/duotone have full patterns below in the Decorative kit; here
are the simpler treatments.

### Rotated photo
```html
<figure class="photo photo--rotated" style="--rotation: -6deg;">
  <img src="/uploads/photo.jpg" alt="Description">
</figure>
```
```css
.photo--rotated { display: inline-block; transform: rotate(var(--rotation)); }
.photo--rotated img { display: block; max-width: 100%; height: auto; }
```

### Cutout with hard shadow (mid-century / italian-poster)
```html
<figure class="photo photo--cutout">
  <img src="/uploads/photo.jpg" alt="Description">
</figure>
```
```css
.photo--cutout {
  display: inline-block;
  transform: rotate(-2deg);
  filter: drop-shadow(8px 10px 0 var(--accent-ink, #1a1a1a));
}
.photo--cutout img { display: block; max-width: 100%; height: auto; }
```

### Full-bleed hero photo
```html
<figure class="photo photo--bleed">
  <img src="/uploads/hero.jpg" alt="">
</figure>
```
```css
.photo--bleed {
  width: 100vw;
  margin-left: calc(50% - 50vw);
  margin-right: calc(50% - 50vw);
}
.photo--bleed img { display: block; width: 100%; height: auto; }
```

---

# Decorative kit — Pinterest-coded primitives

If `BRIEF.md § 2 · Aesthetic family` is anything beyond Slow editorial /
Soft modern / Brutalist, the build MUST ship at least 3 distinct motifs
from this kit on the home page. These are CSS+inline-SVG only — no JS
framework. Adapt classes/colours to the palette in BRIEF.md.

## Sticker / circular badge — rotated label

```html
<span class="sticker sticker--rotate">
  <svg viewBox="0 0 100 100" aria-hidden="true">
    <defs>
      <path id="ring" d="M50,50 m-38,0 a38,38 0 1,1 76,0 a38,38 0 1,1 -76,0"/>
    </defs>
    <text font-family="inherit" font-size="11" fill="currentColor" letter-spacing="2">
      <textPath href="#ring" startOffset="0">• SINCE 1954 • SINCE 1954 </textPath>
    </text>
    <text x="50" y="56" text-anchor="middle" font-family="inherit" font-size="18" font-weight="800" fill="currentColor">FRESH</text>
  </svg>
</span>
```

```css
.sticker { display:inline-block; width:120px; height:120px; color:var(--accent-2); }
.sticker--rotate { transform: rotate(-8deg); }
```

Use for "since YEAR", "open today", "made in PLACE". Slap one on a hero
corner or beside a section heading.

## Washi tape — corner adhesive

```html
<figure class="taped">
  <span class="tape tape--tl"></span>
  <span class="tape tape--br"></span>
  <img src="/uploads/hero.jpg" alt="">
</figure>
```

```css
.taped { position:relative; display:inline-block; }
.tape {
  position:absolute; width:96px; height:22px;
  background: linear-gradient(180deg, rgba(255,230,160,.88) 0%, rgba(245,200,120,.92) 100%);
  box-shadow: 0 1px 2px rgba(0,0,0,.12);
  opacity:.88;
}
.tape--tl { top:-10px; left:-14px; transform: rotate(-18deg); }
.tape--br { right:-14px; bottom:-10px; transform: rotate(14deg); }
```

Swap the gradient for the brand's washi colour (pastel pink, sage, kraft).

## Polaroid frame

```html
<figure class="polaroid">
  <img src="/uploads/photo.jpg" alt="Description">
  <figcaption>Hand-tied, June 2024</figcaption>
</figure>
```

```css
.polaroid {
  display:inline-block; background:#fbf6ee; padding:14px 14px 56px;
  box-shadow: 0 8px 20px rgba(0,0,0,.12), 0 2px 4px rgba(0,0,0,.08);
  transform: rotate(-2deg);
}
.polaroid img { display:block; width:100%; aspect-ratio: 4/5; object-fit:cover; }
.polaroid figcaption {
  position:absolute; left:0; right:0; bottom:14px; text-align:center;
  font-family: 'Caveat', cursive; font-size: 1.1rem; color:#444;
}
```

Stack 3–5 with alternating rotations for a collage hero.

## CSS-only marquee

```html
<div class="marquee" aria-hidden="true">
  <div class="marquee__track">
    <span>FRESH ROSES — DELIVERED DAILY — SINCE 1954 — </span>
    <span>FRESH ROSES — DELIVERED DAILY — SINCE 1954 — </span>
  </div>
</div>
```

```css
.marquee { overflow:hidden; border-block:2px solid currentColor; padding:.6rem 0; }
.marquee__track {
  display:inline-flex; gap:2rem; white-space:nowrap;
  animation: marquee 22s linear infinite;
  font-family: var(--font-display); font-size:1.5rem; letter-spacing:.06em;
}
@keyframes marquee { to { transform: translateX(-50%); } }
@media (prefers-reduced-motion: reduce) { .marquee__track { animation:none; } }
```

Use as a section divider or hero band. Pair with a strong color block.

## Grain / paper-texture overlay

```html
<body>
  …
  <div class="grain" aria-hidden="true"></div>
</body>
```

```css
.grain {
  position:fixed; inset:0; pointer-events:none; z-index:50;
  opacity:.12; mix-blend-mode: multiply;
  background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='160' height='160'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='2' stitchTiles='stitch'/></filter><rect width='100%' height='100%' filter='url(%23n)' opacity='.7'/></svg>");
}
```

For Riso / Italian-poster / Mid-century / Cottagecore. Tune opacity 0.06–0.18.

## Halftone dot overlay on images

```html
<figure class="halftone">
  <img src="/uploads/photo.jpg" alt="">
</figure>
```

```css
.halftone { position:relative; display:inline-block; }
.halftone::after {
  content:""; position:absolute; inset:0; pointer-events:none;
  background-image: radial-gradient(circle, rgba(0,0,0,.55) 22%, transparent 24%);
  background-size: 6px 6px;
  mix-blend-mode: multiply; opacity:.65;
}
.halftone img { display:block; filter: contrast(1.1) saturate(.6); }
```

Pair with a duotone filter for full riso effect.

## Duotone image — pure CSS

```html
<figure class="duo"><img src="/uploads/photo.jpg" alt=""></figure>
```

```css
.duo { background: var(--accent); display:inline-block; }
.duo img {
  display:block; width:100%;
  filter: grayscale(1) contrast(1.1);
  mix-blend-mode: screen; opacity:.92;
}
```

`--accent` becomes the highlight colour; replace `background` with the
shadow colour. Try magenta on cyan for riso, oxblood on bone for editorial.

## Scribble underline on headings

```html
<h2>About <span class="scribble">our roses</span></h2>
```

```css
.scribble { position:relative; display:inline-block; }
.scribble::after {
  content:""; position:absolute; left:-4%; right:-4%; bottom:-.12em; height:.45em;
  background: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 18' fill='none' stroke='%23e0473e' stroke-width='4' stroke-linecap='round'><path d='M3 12 Q 40 2 80 10 T 160 8 T 197 14'/></svg>") no-repeat center/100% 100%;
  pointer-events:none;
}
```

Swap the `stroke` colour to match a palette accent.

## Drop cap

```html
<p class="drop">In the spring of 1954, a small shop opened…</p>
```

```css
.drop::first-letter {
  font-family: var(--font-display); float:left;
  font-size: 5.4rem; line-height:.85; padding: .15em .14em 0 0;
  color: var(--accent); font-weight:800;
}
```

Use on the opening paragraph of editorial / cottagecore / about pages.

## Sticky-note callout

```html
<aside class="sticky-note">
  <p>Note from Corrado: <em>roses last 7 days if you change the water every other day.</em></p>
</aside>
```

```css
.sticky-note {
  background: #fff7a8; padding: 1.1rem 1.2rem; max-width: 22ch;
  font-family: 'Caveat', cursive; font-size: 1.15rem; line-height:1.35;
  box-shadow: 0 6px 14px rgba(0,0,0,.12); transform: rotate(-3deg);
  border: 1px solid rgba(0,0,0,.06);
}
```

For cottagecore / editorial-collage / soft-girl. Don't overuse — one per page.

## Collage row — overlapping rotated cards

```html
<div class="collage">
  <figure class="collage__item"><img src="/uploads/a.jpg" alt=""></figure>
  <figure class="collage__item"><img src="/uploads/b.jpg" alt=""></figure>
  <figure class="collage__item"><img src="/uploads/c.jpg" alt=""></figure>
</div>
```

```css
.collage { position:relative; padding: 3rem 0; min-height: 28rem; }
.collage__item { position:absolute; width: clamp(180px, 22vw, 320px); box-shadow: 0 12px 24px rgba(0,0,0,.16); }
.collage__item img { display:block; width:100%; height:auto; }
.collage__item:nth-child(1) { top: 0;  left: 4%;  transform: rotate(-5deg); }
.collage__item:nth-child(2) { top: 18%; left: 32%; transform: rotate(3deg);  z-index:2; }
.collage__item:nth-child(3) { top: 4%;  right: 6%; transform: rotate(-2deg); }
```

Heroes for editorial-collage / cottagecore / indie-sleaze. On mobile,
collapse via `@media (max-width:720px) { .collage { display:flex;
flex-direction:column; gap:1rem; } .collage__item { position:static;
width:100%; transform:none; } }`.

## Hand-drawn arrow — inline SVG

```html
<svg class="arrow" viewBox="0 0 200 60" aria-hidden="true">
  <path d="M5 40 C 50 5, 120 5, 180 30" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
  <path d="M180 30 l -12 -3 m 12 3 l -7 11" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
</svg>
```

Sketchy connector between two cards or pointing at a CTA. Set `color` on
the parent.

## Magazine pull quote

```html
<blockquote class="pullquote">
  <p><span aria-hidden="true">"</span>The best florist in Como, and a kind man besides.<span aria-hidden="true">"</span></p>
  <cite>— Famiglia Rossi, clienti dal 2010</cite>
</blockquote>
```

```css
.pullquote { position:relative; max-width: 28ch; margin: 3rem auto; }
.pullquote p {
  font-family: var(--font-display); font-size: clamp(1.6rem, 4vw, 3.2rem);
  line-height: 1.05; font-weight: 600; text-wrap: balance;
}
.pullquote p > span:first-child { position:absolute; left:-.5em; top:-.2em; font-size:1.6em; color: var(--accent); }
.pullquote cite { display:block; margin-top: 1rem; font-style: normal; letter-spacing:.1em; text-transform:uppercase; font-size:.8125rem; }
```

## Scallop section divider — inline SVG

```html
<svg class="scallop" viewBox="0 0 1200 40" preserveAspectRatio="none" aria-hidden="true">
  <path d="M0 0 Q 50 40 100 0 T 200 0 T 300 0 T 400 0 T 500 0 T 600 0 T 700 0 T 800 0 T 900 0 T 1000 0 T 1100 0 T 1200 0 V40 H0 Z" fill="currentColor"/>
</svg>
```

```css
.scallop { display:block; width:100%; height: 40px; color: var(--accent); }
```

Place between hero and next section. Swap path for wave/dotted/triangle
for different families.

## Eyebrow label

```html
<p class="eyebrow">Chapter Two</p>
<h2>How we arrange a bouquet</h2>
```

```css
.eyebrow {
  font-family: var(--font-accent, var(--font-body));
  text-transform: uppercase; letter-spacing: .14em;
  font-size: .8125rem; color: var(--accent); margin: 0 0 .4rem;
}
```

Cheap and effective — almost every family above benefits.

---

## Hard prohibitions

- **No fake maps** drawn as SVG or canvas. Use OSM iframe or address card.
- **No fake charts/graphs** with invented numbers.
- **No fake calendars** showing fake events.
- **No fake audio/video players** with no actual media.
- **No fake testimonials** with made-up names — use what's in source/text.md.
- **No fake "trusted by" logo strips** with made-up logos.
- **No fake newsletter counts** ("Join 10,000 readers" — unless actually true).

When in doubt: remove the section and find a simpler way to occupy that
real estate. Empty space + good typography is always better than fake
content.
