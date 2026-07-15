# Cloudflare Deployment Guide for AI Agents

Use this guide before configuring any React/Vite/static project on Cloudflare. The main rule: first decide whether the project is **Cloudflare Pages** or **Cloudflare Workers static assets**. Do not mix the commands or config.

## 1. Identify the Cloudflare Product

Check the live/dev URL:

- `*.pages.dev` means Cloudflare Pages.
- `*.workers.dev` means Cloudflare Workers.

Use the matching deploy command:

- Pages: `wrangler pages deploy <output-dir> --project-name=<pages-project-name>`
- Workers: `wrangler deploy`

Wrong combinations cause confusing errors:

- Do not use `wrangler deploy` for a Pages project.
- Do not use `wrangler pages deploy` for a Workers project.

## 2. Recommended Workers Static Assets Setup

Use this when the dashboard URL is like:

```text
https://project-name.account-subdomain.workers.dev
```

### package.json

```json
{
  "scripts": {
    "build": "vite build && node scripts/prepare-cloudflare-worker-build.mjs",
    "deploy:cloudflare": "node scripts/prepare-cloudflare-worker-build.mjs && npx wrangler deploy"
  }
}
```

### wrangler.toml

```toml
name = "project-name"
compatibility_date = "2026-07-15"
main = "./src/worker.js"

[assets]
directory = "./build"
binding = "ASSETS"
not_found_handling = "single-page-application"
run_worker_first = ["/api/*"]
```

Important:

- Use `not_found_handling = "single-page-application"` for React Router direct URLs.
- Do not add `public/_redirects` with `/* /index.html 200` for Workers static assets. It can create an infinite loop deploy error.
- Keep API routes in the Worker, for example `/api/lead-webhook`.

### Minimal src/worker.js Pattern

```js
export default {
  async fetch(request, env) {
    const url = new URL(request.url);

    if (url.pathname === "/api/example") {
      return Response.json({ ok: true });
    }

    return env.ASSETS.fetch(request);
  },
};
```

## 3. Recommended Pages Setup

Use this when the dashboard URL is like:

```text
https://project-name.pages.dev
```

Dashboard settings:

```text
Build command: npm run build
Build output directory: build
Root directory: /
Deploy command: leave empty for normal Git-integrated Pages
```

If a direct upload deploy command is required, use:

```bash
npx wrangler pages deploy build --project-name=<pages-project-name>
```

Pages Functions live in the root `functions/` folder:

```text
functions/api/example.js
```

```js
export async function onRequest({ request, env }) {
  return Response.json({ ok: true });
}
```

For Pages SPA fallback, `public/_redirects` can be used:

```text
/* /index.html 200
```

Do not use that file for Workers static assets.

## 4. Environment Variables and Secrets

Understand where each variable runs.

### Public Browser Variables

Vite exposes anything starting with `VITE_` in browser JavaScript. These are not private.

Examples:

```text
VITE_SUPABASE_URL
VITE_SUPABASE_ANON_KEY
```

Supabase anon keys are designed to be public. Security must come from Supabase RLS policies, not hiding the anon key.

### Server/Worker Runtime Secrets

These must be set as Cloudflare runtime secrets/variables:

```text
WEBHOOK_URL
WORKSHOP_WEBHOOK
STRIPE_SECRET_KEY
RAZORPAY_KEY_SECRET
ANY_PRIVATE_API_KEY
```

If the browser form saves to Supabase but webhook says "not configured", the Worker runtime secret is missing.

### Cloudflare Deploy Token

For automated deploys, set:

```text
CLOUDFLARE_API_TOKEN
CLOUDFLARE_ACCOUNT_ID
```

The token needs permission for the product being deployed:

- Workers deploy: Workers edit permissions.
- Pages deploy: Pages edit permissions.

## 5. Asset Count and Build Output

Workers static assets can fail if the uploaded manifest has too many files. Common causes:

- WordPress backup folders copied into `public/`.
- Optimizer/cache folders copied into `public/`.
- Plugin source backups copied into `public/`.

Check file count:

```bash
find build -type f | wc -l
```

If too high, prune unused folders after build. Example:

```js
// scripts/prepare-cloudflare-worker-build.mjs
import { rmSync } from "node:fs";
import { join } from "node:path";

const buildDir = join(process.cwd(), "build");

for (const relativePath of [
  "_redirects",
  "assets/al_opt_content",
  "assets/backup",
]) {
  rmSync(join(buildDir, relativePath), { force: true, recursive: true });
}

console.log("[cloudflare] prepared Worker build output");
```

## 6. Custom Domain Setup

If the dev URL works, adding the live domain should not require code changes if API calls are same-origin.

Good:

```js
fetch("/api/lead-webhook")
```

Avoid hardcoding:

```js
fetch("https://project-name.workers.dev/api/lead-webhook")
```

Attach the domain to the same Cloudflare project:

- Workers: Workers & Pages -> Worker -> Settings -> Domains & Routes.
- Pages: Workers & Pages -> Pages project -> Custom domains.

## 7. Fast Debug Checklist

When a Cloudflare deploy fails, inspect the exact failing stage:

1. Dependency install failed: package lock or Node/npm issue.
2. Build command failed: app code or env used during build is missing.
3. Asset upload failed: too many files or invalid static files.
4. Version/deploy failed: Worker config, redirects, token permission, or product mismatch.
5. Site still live after failed deploy: Cloudflare is serving the last successful deployment.

Common error meanings:

```text
Missing entry-point to Worker script or assets directory
```

You ran `wrangler deploy` without Worker config/assets, or you used Worker deploy for Pages.

```text
The Pages project "<name>" does not exist
```

You ran `wrangler pages deploy` but the project is actually a Worker, or the Pages project name is wrong.

```text
Invalid manifest: exceeds the limit of 20,000 files
```

Too many static files are being uploaded. Prune unused build output.

```text
Invalid _redirects configuration: Infinite loop
```

A Pages-style `_redirects` SPA fallback is being uploaded to Workers static assets. Remove it and use `not_found_handling = "single-page-application"`.

```text
WORKSHOP_WEBHOOK is not configured
```

The Worker runtime secret is missing. Add it under Cloudflare Variables and Secrets.

## 8. Final Pre-Deploy Checks

Run locally:

```bash
npm run build
test ! -e build/_redirects
find build -type f | wc -l
```

For Workers, confirm:

```text
package.json deploy command: npx wrangler deploy
wrangler.toml has main + [assets]
no public/_redirects file
runtime secrets are set in Cloudflare
```

For Pages, confirm:

```text
deploy command is empty for Git-integrated Pages, or uses wrangler pages deploy
functions live in functions/
project URL ends in .pages.dev
```

## Official References

- Cloudflare Workers Static Assets: https://developers.cloudflare.com/workers/static-assets/
- Cloudflare Wrangler Configuration: https://developers.cloudflare.com/workers/wrangler/configuration/
- Cloudflare Pages Functions: https://developers.cloudflare.com/pages/functions/get-started/
