const fs = require('node:fs');
const http = require('node:http');
const path = require('node:path');

const PORT = Number(process.env.PORT || 10000);
const DIST_DIR = path.resolve(__dirname, '..', 'dist');
const INDEX_FILE = path.join(DIST_DIR, 'index.html');
const WEBHOOK_PATHS = new Set([
  '/.netlify/functions/lead-webhook',
  '/api/lead-webhook',
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

async function handleLeadWebhook(request, response) {
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

  const webhookUrl = process.env.WEBHOOK_URL || process.env.VITE_WEBHOOK_URL;
  if (!webhookUrl) {
    sendJson(response, 500, { error: 'WEBHOOK_URL is not configured.' });
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
        error: 'Webhook rejected the lead payload.',
        status: webhookResponse.status,
        body: body.slice(0, 500),
      });
      return;
    }

    sendJson(response, 200, { ok: true });
  } catch (error) {
    sendJson(response, 502, {
      error: 'Webhook delivery failed.',
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

  const filePath = path.resolve(DIST_DIR, `.${pathname}`);
  const isInsideDist = filePath === DIST_DIR || filePath.startsWith(`${DIST_DIR}${path.sep}`);

  if (isInsideDist && fs.existsSync(filePath) && fs.statSync(filePath).isFile()) {
    sendStaticFile(response, filePath);
    return;
  }

  sendStaticFile(response, INDEX_FILE);
}

const server = http.createServer((request, response) => {
  const requestUrl = new URL(request.url, `http://${request.headers.host || 'localhost'}`);

  if (WEBHOOK_PATHS.has(requestUrl.pathname)) {
    handleLeadWebhook(request, response);
    return;
  }

  handleStaticRequest(request, response);
});

server.listen(PORT, () => {
  console.log(`Render server listening on port ${PORT}`);
});
