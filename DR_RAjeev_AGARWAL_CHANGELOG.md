# Dr. Rajeev Agarwal Website — Changelog

## 26 Oct 2026 — Tasks A5 (footer registration line) and A2 (IVF cost redirect)

**Status at audit time: audit only. No code changed, committed, pushed, merged or deployed.**

Starting point: branch `main` at `9394a601`, working tree clean.

---

### Task A5 — Medical registration line on every page template

**Status: already correct. No code change.**

Required line (exact):

> Dr. Rajeev Agarwal, MBBS, MD (Obstetrics & Gynaecology), West Bengal Medical Council Reg. No. WBMC52540

#### Code findings (local repository)

- Single source of truth: `src/components/Footer.jsx:47-49` (`<p className="ra-footer-desc ra-footer-reg">`). The exact line exists once in the codebase.
- How each page type gets the footer:
  - All routes except `/` and `/admin/*` are wrapped by `SiteChrome` in `src/App.jsx:96-114`, which renders `Header`, the page and the shared `<Footer />`.
  - Homepage `/` is excluded from `SiteChrome` but renders the same `<Footer />` itself (`src/pages/Home.jsx:1285`).
  - `/admin/*` has no footer by design (internal admin dashboard). Not applicable.
- Templates covered by this shared footer: Home, About, Preconception, Preconception Workshop, Blog list, Blog article (`BlogPost` via `/:slug`), Service pages (`ServicePage` via `/:slug`), All Services, Success Stories, Courses, Book Appointment, Policy pages, all seven Menopause Care hub pages, and the in-app NotFound route.
- No duplicate copies of the line in other shared components. `src/pages/BlogPost.jsx:124` has a separate article author box with its own wording (it mentions the registration as part of the author bio). It is not a copy of the footer line and was left alone.
- `src/utils/jsonLd.cjs:26-33` holds the registration number for structured data. That is schema markup, not visible footer text. Unchanged.
- CSS (`src/index.css:3060`, `src/index.css:15576`): `.ra-footer-reg` has no `display`/`visibility` rules hiding it at any breakpoint.

#### Live findings (https://drrajeevagarwal.co.in, 26 Oct 2026, `curl` of the server HTML)

Number of times the exact line appears on each page:

| Page type | URL | HTTP | Count |
|---|---|---|---|
| Homepage | `/` | 200 | 1 |
| About | `/about-me` | 200 | 1 |
| All services | `/all-services` | 200 | 1 |
| Service page | `/pcos-care` | 200 | 1 |
| Service page | `/fertility-support-services` | 200 | 1 |
| Service page | `/laparoscopic-surgery` | 200 | 1 |
| Blog list | `/blog` | 200 | 1 |
| Blog article | `/how-age-impacts-fertility/` | 200 | 1 |
| Menopause hub | `/menopause-care` | 200 | 1 |
| Menopause sub-page | `/menopause-care/hrt-hormone-therapy` | 200 | 1 |
| Menopause sub-page | `/menopause-care/care-team` | 200 | 1 |
| Policy page | `/privacy-policy` | 200 | 1 |
| Policy page | `/disclaimer-policy` | 200 | 1 |
| Booking | `/book-an-appointment` | 200 | 1 |
| Courses | `/courses` | 200 | 1 |
| Success stories | `/success-stories` | 200 | 1 |
| Preconception | `/preconception` | 200 | 1 |
| Preconception workshop | `/preconception-workshop` | 200 | 1 |
| Unknown URL (404) | `/this-page-does-not-exist-xyz` | 404 | 0 (see note) |

Each page shows the line exactly once, so there are no duplicates. The homepage was not changed.

**Note on the 404 page:** unknown URLs get the standalone static `public/404.html` (wrangler `not_found_handling: "404-page"`). That page has no footer at all, so it falls outside "templates that have a footer". It is `noindex`. It was left unchanged and is listed under remaining items in case the team wants a footer there.

---

### Task A2 — IVF cost permanent redirect

**Status: already correct live. No code change. No duplicate rule added.**

- Source: `https://drrajeevagarwal.co.in/ivf-treatment-cost-in-kolkata-what-you-should-know/`
- Expected destination: `https://renewhealthcare.in/blogs/ivf-cost-in-kolkata`

#### Existing mechanism (code)

- `src/data/retiredArticles.js:29` maps `'ivf-treatment-cost-in-kolkata-what-you-should-know'` to `'https://renewhealthcare.in/blogs/ivf-cost-in-kolkata'`.
- `src/worker.js:282-300` (`retiredTarget` / `legacyWordPressResponse`) returns `Response.redirect(target, 301)` for `/<slug>`, `/<slug>/`, `/blog/<slug>` and `/blog/<slug>/`.
- Covered by the existing test `SEO brief task 9: retired articles 301 in one hop from every form, including /blog/` in `tests/worker.test.mjs:85`. That test passes.
- `public/_redirects` has no rule for this slug. That is expected because the Worker handles it, so there is no conflicting rule.

#### Live HTTP results (26 Oct 2026)

| Check | Result |
|---|---|
| `curl -sSI <source>`: initial status | `HTTP/2 301` |
| Initial `Location` header | `https://renewhealthcare.in/blogs/ivf-cost-in-kolkata` (exact match) |
| `curl -sSIL <source>`: chain | 301 → 200. One hop, no loop |
| Final URL / status | `https://renewhealthcare.in/blogs/ivf-cost-in-kolkata` → `200` (`num_redirects=1`) |
| Destination direct (`HEAD` and `GET`) | `200` / `200` |
| `/ivf-treatment-cost-in-kolkata-what-you-should-know` (no slash) | 301 → destination |
| `/blog/ivf-treatment-cost-in-kolkata-what-you-should-know` (+ trailing slash) | 301 → destination |
| `http://` source | 301 → `https://drrajeevagarwal.co.in/...` then 301 → destination (two hops, by the site-wide HTTPS rule) |
| `https://www.` source | 301 → apex, then 301 → destination (two hops, by the site-wide www rule) |

#### Internal links to the obsolete URL

- No `href` in page data, blog bodies or components points to the old URL.
- The live `/blog` listing and the live `sitemap.xml` do not contain it.
- The only remaining references are non-link data: the article record in `src/data/blogs_data.js:149` (removed from listings by `isRetiredArticle`), its banner mapping in `src/utils/blogPresentation.js:26`, and the redirect map itself. These are fine as they are.

---

### Files changed

| File | Reason |
|---|---|
| `DR_RAjeev_AGARWAL_CHANGELOG.md` (new) | This audit record. |

No source, config, redirect or style file was changed.

### Validation actually run

| Command | Result |
|---|---|
| `npm test` (`node --test "tests/**/*.test.mjs"`) | **24/24 pass**, 0 fail |
| `npx eslint .` | 30 problems (25 errors, 5 warnings), all **pre-existing**: the tree was clean and no code was edited. Spread across 17 files (mostly `no-unused-vars`). |
| `npx eslint src/components/Footer.jsx src/App.jsx src/worker.js src/data/retiredArticles.js` | 1 pre-existing error: `Footer.jsx:1:8 'React' is defined but never used`. `App.jsx`, `worker.js` and `retiredArticles.js` are clean. |
| Live `curl` checks | As listed in the tables above |
| Production build (`npm run build`) | **Not run.** No source changed, and the prebuild step regenerates tracked files (`public/_redirects`, `public/sitemap.xml`), which would have dirtied the working tree for no benefit. |
| Browser desktop/mobile visual check | **Not performed** (no browser tooling used). Visibility was checked only by reading the CSS (no hide rules at any breakpoint) and by confirming the line is in the server-rendered HTML. |

### Remaining items / outside this task's scope (not fixed)

1. `public/404.html` is a standalone page with no footer, so it has no registration line. Decide whether a footer is wanted there.
2. Pre-existing lint errors (30 problems, including the unused `React` import in `Footer.jsx`). Not touched, to keep scope narrow.
3. `http://` and `www.` forms of the IVF source reach the destination in two 301 hops rather than one. This comes from the site-wide HTTPS/www rules and is acceptable, but it is noted here.

### Deployment status

At audit time, this record was in the local working tree only. **No deployment, commit, push or merge was performed during the audit.** No Cloudflare, DNS, SSL, secret or dashboard settings were touched. Both tasks were **verified live** against the production site on 26 Oct 2026.

Before this record was published, local `main` was fast-forwarded from `9394a601` to `43102b6f` to include newer GitHub commits. Those commits changed the footer's location and hours, but preserved the registration line described above.
