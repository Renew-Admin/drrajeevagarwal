# Dr. Rajeev Agarwal Website

React + Vite site configured for Cloudflare Pages.

## Cloudflare Pages

Connect the GitHub repository to Cloudflare Pages. Cloudflare will deploy automatically on every push to the selected production branch.

Use these build settings:

- Production branch: `main`
- Build command: `npm run build`
- Build output directory: `build`
- Root directory: repository root

Required Cloudflare Pages environment variables:

- `VITE_SUPABASE_URL`
- `VITE_SUPABASE_ANON_KEY`
- `WEBHOOK_URL`
- `WORKSHOP_WEBHOOK`

The admin panel is a client-side Supabase admin. It needs `VITE_SUPABASE_URL` and `VITE_SUPABASE_ANON_KEY` at build time. The lead and workshop forms post to Cloudflare Pages Functions at `/api/lead-webhook` and `/api/workshop-webhook`, which forward to `WEBHOOK_URL` and `WORKSHOP_WEBHOOK` at runtime.

`public/_redirects` rewrites app routes to `index.html`, so direct visits to routes such as `/admin`, `/blog/...`, and `/preconception-workshop/` work on Cloudflare Pages.

`public/404.html` is the branded Cloudflare-level fallback. Broken app URLs are handled by the React `NotFound` page, and any Cloudflare static 404 also uses the site's own 404 instead of Cloudflare's default error page.
