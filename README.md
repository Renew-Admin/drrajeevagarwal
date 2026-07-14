# Dr. Rajeev Agarwal Website

React + Vite site configured for Cloudflare Workers static assets.

## Cloudflare Workers

This project is deployed as a Cloudflare Worker with static assets. The current Worker URL pattern is `https://drrajeevagarwal.lokesh-7e0.workers.dev/`.

When the live domain is ready, attach `drrajeevagarwal.co.in` to this same Worker under Workers & Pages -> `drrajeevagarwal` -> Settings -> Domains & Routes. The app uses same-origin `/api/...` routes, so the webhook endpoints continue working after the host changes from `workers.dev` to `drrajeevagarwal.co.in`.

Use these build settings:

- Production branch: `main`
- Build command: `npm run build`
- Root directory: repository root
- Deploy command: `npm run deploy:cloudflare`

The deploy command runs `npx wrangler deploy`. `wrangler.toml` tells Cloudflare to upload the Vite `build/` folder as Worker static assets and to run `src/worker.js` for `/api/*` routes.

The build removes unused copied WordPress optimizer and plugin backup folders from `build/assets` (`al_opt_content` and `backup`). This keeps the Worker static asset manifest under Cloudflare's 20,000-file limit while leaving the source files in `public/` untouched.

The deploy command needs a valid `CLOUDFLARE_API_TOKEN` with Workers edit access for the target account. If deploy fails with Cloudflare API authentication code `10000`, replace that token in the Cloudflare project environment variables.

Required Cloudflare environment variables:

- `VITE_SUPABASE_URL`
- `VITE_SUPABASE_ANON_KEY`
- `WEBHOOK_URL`
- `WORKSHOP_WEBHOOK`

The admin panel is a client-side Supabase admin. It needs `VITE_SUPABASE_URL` and `VITE_SUPABASE_ANON_KEY` at build time. The lead and workshop forms post to Worker routes at `/api/lead-webhook` and `/api/workshop-webhook`, which forward to `WEBHOOK_URL` and `WORKSHOP_WEBHOOK` at runtime.

`wrangler.toml` uses `not_found_handling = "single-page-application"`, so direct visits to routes such as `/admin`, `/blog/...`, and `/preconception-workshop/` work on the Worker URL.

`public/404.html` is the branded Cloudflare-level fallback. Broken app URLs are handled by the React `NotFound` page, and any Cloudflare static 404 also uses the site's own 404 instead of Cloudflare's default error page.
