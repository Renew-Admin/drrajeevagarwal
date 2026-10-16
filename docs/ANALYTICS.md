# Analytics, consent and lead proxy

Owner: website developer. Last reviewed: 16 Oct 2026.

## GA4

| Item | Value |
|---|---|
| Property | 324098394 "Dr Rajeev Agarwal" |
| Stream / Measurement ID | **16140752144 / `G-DJR8P0KSK5`** ("drrajeevagarwal.co.in (2026-10 clean)", created 16 Oct 2026) |
| Previous stream | 3850848430 / `G-VD03ZWG8Q4`. Retired from the site because the same ID was pasted into third-party Exly storefronts (soulalchemywithmm / deepshikhaexly), whose visits inflated this property by ~40 %. The stream is left active only so historical reports stay intact; it can be deleted once the new stream is confirmed. |
| Implementation | Direct gtag.js in `index.html` + `src/lib/analytics.js` (no GTM) |
| Page views | Only `src/hooks/usePageTracking.js` (`send_page_view:false`; history-based page views off on the stream) |
| Enhanced measurement | Scrolls, outbound clicks, site search, form interactions, video, file downloads |
| Redaction | Email on; query keys mcp_token, token, access_token, email, phone, mobile, name, contact_number, whatsapp_number, otp, __site_version |

### Event dictionary

| Event | Fires when | Params | Key event |
|---|---|---|---|
| `page_view` | Each genuine route change, after the route's `<title>` is written | page_location (campaign params only), page_title, page_category | No |
| `form_start` / `form_submit` | GA4 enhanced measurement | defaults | No |
| `form_error` | A form with `data-form-type` fails validation, or the save fails | form_type, error_field (name only), error_type | No |
| `generate_lead` | `submitLead()` — Supabase accepted the row; workshop — the workshop webhook accepted it | form_type, page_category | **Yes** |
| `phone_click` / `whatsapp_click` | Click/Enter on tel: / WhatsApp links | cta_location, page_category | Yes (contact intent) |
| `email_click` | mailto: | cta_location, page_category | No |
| `appointment_cta_click` | `[data-cta="appointment"]` buttons, `/book-an-appointment` links | cta_location, cta_type, page_category | No |

`form_type`: appointment, popup_appointment, floating_form, course_enrolment, workshop_registration, menopause_booking, menopause_quiz, website_form.
Never sent: names, numbers, emails, purpose of visit, quiz answers/scores, messages, Supabase IDs, tokens, non-campaign query parameters.

### Guards
Only `drrajeevagarwal.co.in` / `www.drrajeevagarwal.co.in` send data; every other host and `/admin` set `ga-disable-G-DJR8P0KSK5`.

## Consent
Consent Mode v2 defaults all denied in `index.html` before gtag loads; banner `src/components/ConsentBanner.jsx`; choice in `localStorage.dra_consent`; footer "Cookie settings" reopens it; `ad_personalization` always denied. Legal review of the privacy notice (DPDP Act 2023) still required.

## Lead proxy (`/api/lead-webhook`, `/api/workshop-webhook` in `src/worker.js`)
Webhook URLs are Worker secrets (`WEBHOOK_URL`, `WORKSHOP_WEBHOOK`). The proxy now requires a same-site Origin, ≤ 16 KB JSON, a lead with a name and a 10–13 digit phone, honeypot `website` empty, ≤ 20 requests / 10 min / IP per isolate, and drops the same phone + form within 2 minutes. Upstream error bodies are no longer echoed to the browser.
Recommended: Cloudflare WAF rate-limiting rule on `/api/*`.

## Rollback
Revert the merge commit and redeploy. Reverting restores G-VD03ZWG8Q4 (and the Exly mixing).
