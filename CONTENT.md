# Where the content lives

A map of what is editable from `/admin`, what is still written into the theme,
and how a change reaches the published site.

## Getting in

```bash
composer install --no-dev --optimize-autoloader   # once, if vendor/ is missing
php scripts/setup-admin.php                       # create or reset the admin
php scripts/seed-content.php                      # load the content below
php -S 127.0.0.1:8000 -t .                        # then open /admin
```

Default credentials, created by `setup-admin.php`:

| | |
|---|---|
| email | `admin@sarabonella.local` |
| password | `sarabonella-admin` |

**This is a development default, not a secret.** It is in the repository, so
anyone reading it can log in. Change it in `/admin/settings` before the admin is
reachable from anything but localhost, or pass your own:
`php scripts/setup-admin.php you@example.com your-password`.

## Editable in the admin

| What | Where | Notes |
|---|---|---|
| Publications | Collections → Publications | Title, authors, venue, year, DOI, abstract, category, card image, image description, featured, display order |
| Research areas | Collections → Research areas | Title, summary, body, category, order. Shown under “Research notes” and each gets its own page at `/research/{slug}` |
| Pages | Collections → Pages | Free markdown pages at `/{slug}` |
| Teaching & community notes | Collections → Teaching & community | Extra entries under `/leadership/{slug}` |
| Contact notes | Collections → Contact page | Extra entries under `/contact/{slug}` |
| Site name, contact details, profile links | Settings | `contact_email`, `contact_phone`, `contact_address`, `orcid_url`, `epfl_profile_url`, `cecam_url` |
| Images | Media | Upload, then paste the path into a `Card image` or `Lead image` field |

**Featured** decides which publications appear under “Where to start”. If none
are featured the page falls back to the first eight.

**Card image** takes a root-relative path such as
`/uploads/publications/pub-osscar.webp`, not a full URL. The six shipped images
are diagrams of each paper's subject, drawn in the site's palette — replace any
of them by pointing the field somewhere else.

## Still written into the theme

These are prose rather than records, so they live in
`templates/theme/default/` and are edited there:

| What | File |
|---|---|
| Hero copy on every page (eyebrow, title, deck, roles, buttons) | the page's `*-list.twig`, near the top |
| Home: the pull quote, biography, career timeline, the three questions, teaching blurbs, the personal coda | `home.twig` |
| Research: approach, the three questions, the methods list | `research-list.twig` |
| Teaching: CECAM, courses, open tools, public engagement | `leadership-list.twig` |
| Contact: what to include, privacy note | `contact-list.twig` |
| Footer, navigation, all styling and behaviour | `layout.twig` |

Moving the career timeline and the course list into collections would be the
next useful step; they are the two that read most like records rather than
prose. Everything else is written as continuous argument and would lose more in
being chopped into fields than it would gain.

## Publishing

`docs/` is what GitHub Pages serves. It is a static mirror, so **editing in the
admin does not change the published site until the export is re-run**:

```bash
bash scripts/export-static.sh
git add docs && git commit && git push
```

The script starts the app, mirrors it with `wget`, rebases root-relative URLs
onto `/sarabonella`, adds the canonical and social tags, copies assets that are
referenced only from attributes `wget` cannot follow, and rewrites the sitemap
and robots origins. Override with `BASE_PATH=` and `SITE_URL=` for a different
host; `BASE_PATH=` (empty) publishes at a domain root.
