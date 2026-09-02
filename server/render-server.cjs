const fs = require('node:fs');
const http = require('node:http');
const path = require('node:path');
const {
  getMetaForPath,
  escapeHtml,
  stripExistingSeoTags,
  buildSeoTags,
} = require('../src/utils/seoMeta.cjs');
const { buildJsonLd } = require('../src/utils/jsonLd.cjs');

const PORT = Number(process.env.PORT || 10000);
const BUILD_DIR = path.resolve(__dirname, '..', 'build');
const DIST_DIR = path.resolve(__dirname, '..', 'dist');
const PUBLIC_DIR = fs.existsSync(path.join(BUILD_DIR, 'index.html')) ? BUILD_DIR : DIST_DIR;
const INDEX_FILE = path.join(PUBLIC_DIR, 'index.html');
const WEBHOOK_ROUTES = new Map([
  [
    '/.netlify/functions/lead-webhook',
    {
      envNames: ['WEBHOOK_URL', 'VITE_WEBHOOK_URL'],
      missingKey: 'WEBHOOK_URL',
      rejectedMessage: 'Webhook rejected the lead payload.',
      failedMessage: 'Webhook delivery failed.',
    },
  ],
  [
    '/api/lead-webhook',
    {
      envNames: ['WEBHOOK_URL', 'VITE_WEBHOOK_URL'],
      missingKey: 'WEBHOOK_URL',
      rejectedMessage: 'Webhook rejected the lead payload.',
      failedMessage: 'Webhook delivery failed.',
    },
  ],
  [
    '/.netlify/functions/workshop-webhook',
    {
      envNames: ['WORKSHOP_WEBHOOK'],
      missingKey: 'WORKSHOP_WEBHOOK',
      rejectedMessage: 'Webhook rejected the workshop payload.',
      failedMessage: 'Workshop webhook delivery failed.',
    },
  ],
  [
    '/api/workshop-webhook',
    {
      envNames: ['WORKSHOP_WEBHOOK'],
      missingKey: 'WORKSHOP_WEBHOOK',
      rejectedMessage: 'Webhook rejected the workshop payload.',
      failedMessage: 'Workshop webhook delivery failed.',
    },
  ],
]);

const JSON_HEADERS = {
  'Content-Type': 'application/json',
  'Cache-Control': 'no-store',
};

const MIME_TYPES = {
  '.css': 'text/css; charset=utf-8',
  '.gif': 'image/gif',
  '.html': 'text/html; charset=utf-8',
  '.ico': 'image/x-icon',
  '.jpeg': 'image/jpeg',
  '.jpg': 'image/jpeg',
  '.js': 'text/javascript; charset=utf-8',
  '.json': 'application/json; charset=utf-8',
  '.map': 'application/json; charset=utf-8',
  '.png': 'image/png',
  '.svg': 'image/svg+xml',
  '.txt': 'text/plain; charset=utf-8',
  '.webmanifest': 'application/manifest+json',
  '.webp': 'image/webp',
  '.woff': 'font/woff',
  '.woff2': 'font/woff2',
  '.xml': 'application/xml; charset=utf-8',
};

function sendJson(response, statusCode, body) {
  response.writeHead(statusCode, JSON_HEADERS);
  response.end(JSON.stringify(body));
}

function readRequestBody(request, maxBytes = 1024 * 1024) {
  return new Promise((resolve, reject) => {
    let body = '';

    request.on('data', (chunk) => {
      body += chunk;
      if (Buffer.byteLength(body) > maxBytes) {
        reject(new Error('Request body too large.'));
        request.destroy();
      }
    });

    request.on('end', () => resolve(body));
    request.on('error', reject);
  });
}

async function readTextSafely(response) {
  try {
    return await response.text();
  } catch {
    return '';
  }
}

async function handleWebhook(request, response, routeConfig) {
  response.setHeader('Access-Control-Allow-Origin', '*');
  response.setHeader('Access-Control-Allow-Methods', 'POST, OPTIONS');
  response.setHeader('Access-Control-Allow-Headers', 'Content-Type');

  if (request.method === 'OPTIONS') {
    response.writeHead(204, JSON_HEADERS);
    response.end();
    return;
  }

  if (request.method !== 'POST') {
    sendJson(response, 405, { error: 'Method not allowed.' });
    return;
  }

  const webhookUrl = routeConfig.envNames.map((name) => process.env[name]).find(Boolean);
  if (!webhookUrl) {
    sendJson(response, 500, { error: `${routeConfig.missingKey} is not configured.` });
    return;
  }

  let payload;
  try {
    payload = JSON.parse(await readRequestBody(request));
  } catch (error) {
    const statusCode = error.message === 'Request body too large.' ? 413 : 400;
    sendJson(response, statusCode, { error: error.message || 'Invalid JSON payload.' });
    return;
  }

  const forwardedPayload = {
    ...payload,
    request: {
      forwarded_for: request.headers['x-forwarded-for'] || null,
      user_agent: request.headers['user-agent'] || null,
      referer: request.headers.referer || request.headers.referrer || null,
    },
  };

  try {
    const webhookResponse = await fetch(webhookUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(forwardedPayload),
    });

    if (!webhookResponse.ok) {
      const body = await readTextSafely(webhookResponse);
      sendJson(response, 502, {
        error: routeConfig.rejectedMessage,
        status: webhookResponse.status,
        body: body.slice(0, 500),
      });
      return;
    }

    sendJson(response, 200, { ok: true });
  } catch (error) {
    sendJson(response, 502, {
      error: routeConfig.failedMessage,
      message: error.message,
    });
  }
}

function sendStaticFile(response, filePath) {
  const extension = path.extname(filePath).toLowerCase();
  const headers = {
    'Content-Type': MIME_TYPES[extension] || 'application/octet-stream',
  };

  if (filePath.includes(`${path.sep}assets${path.sep}`)) {
    headers['Cache-Control'] = 'public, max-age=31536000, immutable';
  }

  fs.createReadStream(filePath)
    .on('open', () => response.writeHead(200, headers))
    .on('error', () => sendJson(response, 500, { error: 'Could not read static file.' }))
    .pipe(response);
}

// escapeHtml / stripExistingSeoTags / buildSeoTags come from src/utils/seoMeta.cjs,
// shared with scripts/prerender.mjs and src/worker.js. This file used to carry
// its own copies, which stripped the baked og:* tags and then re-added a block
// that had no og:image — silently undoing the share image on every page it
// served. JSON-LD is shared the same way, via src/utils/jsonLd.cjs.

function injectSeoTags(html, pathname) {
  const meta = getMetaForPath(pathname);

  // Strip pre-baked description/canonical/OG tags so we never emit duplicates.
  const result = stripExistingSeoTags(html).replace(
    /<title>[^<]*<\/title>/,
    `<title>${escapeHtml(meta.title)}</title>`
  );

  return result.replace(
    /(<\/title>)/,
    `$1\n    ${buildSeoTags(pathname)}\n    ${buildJsonLd(pathname)}`
  );
}

/**
 * Pick the HTML document for a route.
 *
 * scripts/prerender.mjs writes a prerendered <route>/index.html for every
 * indexable route, so serve that when it exists — otherwise the page would ship
 * the homepage's markup under a different URL. Paths that were not prerendered
 * fall back to the empty shell, which the client renders as before.
 */
function resolvePageFile(pathname) {
  const clean = (pathname || '/').replace(/^\/+|\/+$/g, '');

  if (clean) {
    const candidate = path.join(PUBLIC_DIR, clean, 'index.html');
    // path.join collapses "..", so confirm we never escape the build directory.
    if (candidate.startsWith(PUBLIC_DIR + path.sep) && fs.existsSync(candidate)) {
      return candidate;
    }
  } else {
    return INDEX_FILE;
  }

  const shell = path.join(PUBLIC_DIR, 'spa-shell.html');
  return fs.existsSync(shell) ? shell : INDEX_FILE;
}

function sendSpaPage(response, pathname) {
  fs.readFile(resolvePageFile(pathname), 'utf8', (err, html) => {
    if (err) {
      sendJson(response, 500, { error: 'Could not read index.html' });
      return;
    }
    const modifiedHtml = injectSeoTags(html, pathname);
    response.writeHead(200, {
      'Content-Type': 'text/html; charset=utf-8',
      'Cache-Control': 'no-cache',
    });
    response.end(modifiedHtml);
  });
}

const SITE_ORIGIN = 'https://drrajeevagarwal.co.in';

// Articles live at /<slug>/. resolvePageFile() already maps both "/<slug>" and
// "/<slug>/" onto build/<slug>/index.html, so no slug list is needed here; the
// retired /blog/<slug> form is 301'd in handleLegacyWordPress().

function sendPlain(response, statusCode, message) {
  response.writeHead(statusCode, {
    'Content-Type': 'text/plain; charset=utf-8',
    'Cache-Control': 'no-store',
  });
  response.end(message);
}

// Legacy WordPress URL cleanup (301 / 410 / 403) — mirrors public/.htaccess and
// stripExistingSeoTags()'s sibling legacyWordPressResponse() in src/worker.js.
// Returns true if a response was sent.
function handleLegacyWordPress(response, requestUrl) {
  const pathname = requestUrl.pathname;
  const search = requestUrl.search || '';

  // preconception-care → /preconception (301)
  if (pathname.replace(/\/+$/, '') === '/preconception-care') {
    response.writeHead(301, { Location: `${SITE_ORIGIN}/preconception` });
    response.end();
    return true;
  }

  // WordPress attachment / post-id query params (?attachment_id= / ?p=) → 410 Gone
  if (/[?&](?:attachment_id|p)=/.test(search)) { sendPlain(response, 410, 'Gone'); return true; }

  // xmlrpc.php → 403 Forbidden
  if (/^\/xmlrpc\.php$/i.test(pathname)) { sendPlain(response, 403, 'Forbidden'); return true; }

  // wp-json / wp-admin / wp-login(.php) / wp-includes / wp-content → 410 Gone.
  // The trailing [/.] also catches file forms like /wp-login.php.
  // (note: /wp-styles/* are real assets and are intentionally NOT matched)
  if (/^\/wp-(?:admin|login|includes|content|json)(?:[/.]|$)/i.test(pathname)) {
    sendPlain(response, 410, 'Gone');
    return true;
  }

  // RSS / comment / trackback feeds (…/feed) → 301 to homepage
  if (/\/feed\/?$/i.test(pathname)) {
    response.writeHead(301, { Location: `${SITE_ORIGIN}/` });
    response.end();
    return true;
  }

  // Author archives → 301 to About page
  if (/^\/author\/.+/i.test(pathname)) {
    response.writeHead(301, { Location: `${SITE_ORIGIN}/about-me` });
    response.end();
    return true;
  }

  // WordPress pagination artifacts: /<parent>/page/N → /<parent>, /page/N → /
  const pageMatch = pathname.match(/^(\/.*?)?\/page\/\d+\/?$/i);
  if (pageMatch) {
    const parent = pageMatch[1] || '/';
    response.writeHead(301, { Location: `${SITE_ORIGIN}${parent}` });
    response.end();
    return true;
  }

  // Retired article URLs: /blog/<slug> and /blog/<slug>/ → /<slug>/ (301),
  // query string preserved. Mirrors legacyWordPressResponse() in src/worker.js.
  const oldArticle = pathname.match(/^\/blog\/([^/]+)\/?$/);
  if (oldArticle) {
    response.writeHead(301, { Location: `${SITE_ORIGIN}/${oldArticle[1]}/${search}` });
    response.end();
    return true;
  }

  return false;
}

function handleStaticRequest(request, response) {
  const requestUrl = new URL(request.url, `http://${request.headers.host || 'localhost'}`);

  if (requestUrl.pathname === '/healthz') {
    sendJson(response, 200, { ok: true });
    return;
  }

  if (request.method !== 'GET' && request.method !== 'HEAD') {
    sendJson(response, 405, { error: 'Method not allowed.' });
    return;
  }

  let pathname;
  try {
    pathname = decodeURIComponent(requestUrl.pathname);
  } catch {
    sendJson(response, 400, { error: 'Invalid path.' });
    return;
  }

  // Legacy WordPress URL cleanup (mirrors public/.htaccess) — before static/SPA handling.
  if (handleLegacyWordPress(response, requestUrl)) {
    return;
  }

  const filePath = path.resolve(PUBLIC_DIR, `.${pathname}`);
  const isInsidePublicDir = filePath === PUBLIC_DIR || filePath.startsWith(`${PUBLIC_DIR}${path.sep}`);

  if (isInsidePublicDir && fs.existsSync(filePath) && fs.statSync(filePath).isFile()) {
    sendStaticFile(response, filePath);
    return;
  }

  sendSpaPage(response, pathname);
}

const server = http.createServer((request, response) => {
  const requestUrl = new URL(request.url, `http://${request.headers.host || 'localhost'}`);

  const webhookRoute = WEBHOOK_ROUTES.get(requestUrl.pathname);

  if (webhookRoute) {
    handleWebhook(request, response, webhookRoute);
    return;
  }

  handleStaticRequest(request, response);
});

server.listen(PORT, () => {
  console.log(`Render server listening on port ${PORT}`);
});
