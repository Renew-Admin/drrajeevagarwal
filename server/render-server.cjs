const fs = require('node:fs');
const http = require('node:http');
const path = require('node:path');
const { getMetaForPath } = require('../src/utils/seoMeta.cjs');


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

function escapeHtml(str) {
  return str
    .replace(/&/g, '&amp;')
    .replace(/"/g, '&quot;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;');
}

function injectSeoTags(html, pathname) {
  const meta = getMetaForPath(pathname);
  const safeTitle = escapeHtml(meta.title);
  const safeDesc = escapeHtml(meta.description);
  const safeUrl = escapeHtml(meta.canonicalUrl);

  // Replace <title>
  let result = html.replace(
    /<title>[^<]*<\/title>/,
    `<title>${safeTitle}</title>`
  );

  // Inject meta tags right after closing </title>
  const seoTags = [
    `<meta name="description" content="${safeDesc}">`,
    `<link rel="canonical" href="${safeUrl}">`,
    `<meta property="og:title" content="${safeTitle}">`,
    `<meta property="og:description" content="${safeDesc}">`,
    `<meta property="og:url" content="${safeUrl}">`,
    `<meta property="og:type" content="website">`,
    `<meta property="og:site_name" content="Dr. Rajeev Agarwal">`
  ].join('\n    ');

  result = result.replace(
    /(<\/title>)/,
    `$1\n    ${seoTags}`
  );

  return result;
}

function sendSpaPage(response, pathname) {
  fs.readFile(INDEX_FILE, 'utf8', (err, html) => {
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

  const cleanPath = pathname.replace(/\/+$/, '');
  if (cleanPath === '/preconception-care') {
    response.writeHead(301, {
      'Location': 'https://drrajeevagarwal.co.in/preconception',
    });
    response.end();
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
