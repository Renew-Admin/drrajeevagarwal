# Dr. Agarwal website checklist

**6/8 done in the code** · 29 Oct 2026

Checks: 29/29 tests pass · build OK (91 pages) · About page checked at desktop and phone width

---

### [x] 1. Add four missing redirects

Permanent (301) redirects, to the destinations in the 18 Oct brief:

| Old article | Now goes to |
|---|---|
| `/trying-to-conceive-check-your-fallopian-tubes-for-blockages/` | `/blocked-fallopian-tubes-causes-treatment-options/` |
| `/unveiling-endometriosis-understanding-symptoms-diagnosis-and-treatment/` | `/faqs-about-endometriosis/` |
| `/treatment-strategies-for-endometriosis/` | `/faqs-about-endometriosis/` |
| `/everything-you-need-to-know-about-endometriosis-and-fertility/` | `/faqs-about-endometriosis/` |

- The `/blog/...` form of each address redirects the same way.
- **Note:** these four were put back live on 23 Oct on Dr. Rajeev's instruction. This checklist replaces that instruction.
- **Where:** `src/data/retiredArticles.js`.

### [x] 2. Remove redirected URLs from the sitemap

- All four are gone from the sitemap and from every blog list. The sitemap now has 91 URLs (was 95).

### [x] 3. Add the medical registration number to the footer

- Every page's footer shows: *Dr. Rajeev Agarwal, MBBS, MD (Obstetrics & Gynaecology), West Bengal Medical Council Reg. No. WBMC52540*
- Also on the 404 page and in the article author box. Changed from `WBMC 52540` (with a space) to match this checklist.
- **Where:** `src/data/doctorRegistration.js`.

### [x] 4. Add author boxes to all articles

- Already in place: all 55 live articles end with the author box (photo, name, qualifications, registration number, link to About Me).

### [x] 5. Fix the three Open in Maps buttons

- Each clinic card on `/about-me` now has an **Open in Maps** button linking to that clinic's own Google Maps profile. Each was opened and checked against its address:

| Clinic | Google Maps profile |
|---|---|
| Salt Lake | `https://maps.google.com/?cid=3902917559414819569` |
| Mandeville Gardens | `https://maps.google.com/?cid=445319978748151357` |
| Jamshedpur | `https://maps.google.com/?cid=7454174246179340593` |

- The Mandeville Gardens map was zoomed out about 57 km in satellite view, so it looked like the wrong place. It now shows the street with the pin, like the other two.

### [x] 6. Link Dr. Agarwal's own Google profile

- "See Dr. Rajeev Agarwal on Google" link added on `/about-me`, above the clinic cards, to `https://share.google/fWwU4fanBPE0E3ItN` (link from the client, 29 Oct).
- Google blocks automated checks, so please open the link once to confirm it shows his profile.

### [ ] 7. Publish the unexplained infertility article

- **Waiting on:** the 26 October brief for `/unexplained-infertility-all-reports-normal-not-pregnant/`.

### [ ] 8. Redirect the old infertility article

- `/infertility-diagnosis-for-couples/` → the new article, on the same day item 7 goes live.
- **Waiting on:** item 7. Adding it earlier would send visitors to a page that does not exist yet.
- Once item 7 is live, the Renew Healthcare site's redirect (`/blogs/unexplained-infertility-next-steps`) switches on by itself at its next deploy.

---

### Next steps

1. Open Dr. Agarwal's Google profile link once to confirm it is his.
2. Send the 26 October brief for items 7 and 8.
