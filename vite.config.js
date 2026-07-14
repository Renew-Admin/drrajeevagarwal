/* global process */
import { defineConfig } from 'vite'
import { loadEnv } from 'vite'
import react from '@vitejs/plugin-react'
import { renameSync, readdirSync, statSync } from 'fs'
import { join, dirname } from 'path'

function cleanAssetFilenames() {
  return {
    name: 'clean-asset-filenames',
    closeBundle() {
      const dir = join(process.cwd(), 'build/assets')
      const fix = (p) => {
        const files = readdirSync(p)
        for (const f of files) {
          const fp = join(p, f)
          if (statSync(fp).isDirectory()) { fix(fp); continue }
          if (f.includes('#') || f.includes('?')) {
            const clean = f.replace(/[#?].*$/, '')
            renameSync(fp, join(dirname(fp), clean))
          }
        }
      }
      try { fix(dir) } catch {
        // The build may not emit nested assets in every environment.
      }
    }
  }
}

function webhookProxy(path, webhookUrl, envName) {
  return {
    name: `${path.replace(/[^a-z0-9]+/gi, '-').replace(/^-|-$/g, '')}-proxy`,
    configureServer(server) {
      server.middlewares.use(path, async (req, res, next) => {
        if (req.method === 'OPTIONS') {
          res.statusCode = 204;
          res.setHeader('Access-Control-Allow-Origin', '*');
          res.setHeader('Access-Control-Allow-Methods', 'POST, OPTIONS');
          res.setHeader('Access-Control-Allow-Headers', 'Content-Type');
          res.end();
          return;
        }

        if (req.method !== 'POST') {
          next();
          return;
        }

        if (!webhookUrl) {
          res.statusCode = 500;
          res.setHeader('Content-Type', 'application/json');
          res.end(JSON.stringify({ error: `${envName} is not configured.` }));
          return;
        }

        let body = '';
        req.on('data', (chunk) => {
          body += chunk;
        });

        req.on('end', async () => {
          let payload;
          try {
            payload = JSON.parse(body || '{}');
          } catch {
            res.statusCode = 400;
            res.setHeader('Content-Type', 'application/json');
            res.end(JSON.stringify({ error: 'Invalid JSON payload.' }));
            return;
          }

          const forwardedPayload = {
            ...payload,
            request: {
              forwarded_for: req.headers['x-forwarded-for'] || null,
              user_agent: req.headers['user-agent'] || null,
              referer: req.headers.referer || req.headers.referrer || null,
            },
          };

          try {
            const webhookResponse = await fetch(webhookUrl, {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify(forwardedPayload),
            });

            const text = await webhookResponse.text().catch(() => '');
            res.statusCode = webhookResponse.ok ? 200 : 502;
            res.setHeader('Content-Type', 'application/json');
            if (!webhookResponse.ok) {
              res.end(JSON.stringify({
                error: 'Webhook rejected the lead payload.',
                status: webhookResponse.status,
                body: text.slice(0, 500),
              }));
              return;
            }

            res.end(JSON.stringify({ ok: true }));
          } catch (error) {
            res.statusCode = 502;
            res.setHeader('Content-Type', 'application/json');
            res.end(JSON.stringify({
              error: 'Webhook delivery failed.',
              message: error.message,
            }));
          }
        });
      });
    },
  };
}

// https://vite.dev/config/
export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd(), '');
  const webhookUrl = env.WEBHOOK_URL || env.VITE_WEBHOOK_URL || process.env.WEBHOOK_URL || process.env.VITE_WEBHOOK_URL;
  const workshopWebhookUrl = env.WORKSHOP_WEBHOOK || process.env.WORKSHOP_WEBHOOK;
  const directWebhookUrl = env.VITE_WEBHOOK_URL || process.env.VITE_WEBHOOK_URL;

  return {
    build: {
      outDir: 'build',
    },
    define: {
      'import.meta.env.VITE_WEBHOOK_URL': JSON.stringify(directWebhookUrl || ''),
    },
    plugins: [
      react(),
      cleanAssetFilenames(),
      webhookProxy('/api/lead-webhook', webhookUrl, 'WEBHOOK_URL'),
      webhookProxy('/api/workshop-webhook', workshopWebhookUrl, 'WORKSHOP_WEBHOOK'),
      webhookProxy('/.netlify/functions/lead-webhook', webhookUrl, 'WEBHOOK_URL'),
      webhookProxy('/.netlify/functions/workshop-webhook', workshopWebhookUrl, 'WORKSHOP_WEBHOOK'),
    ],
  };
})
