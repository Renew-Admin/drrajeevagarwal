const RESPONSE_HEADERS = {
  'Content-Type': 'application/json',
  'Cache-Control': 'no-store',
  'Access-Control-Allow-Origin': '*',
  'Access-Control-Allow-Methods': 'POST, OPTIONS',
  'Access-Control-Allow-Headers': 'Content-Type',
};

function jsonResponse(status, body) {
  return new Response(JSON.stringify(body), {
    status,
    headers: RESPONSE_HEADERS,
  });
}

async function readTextSafely(response) {
  try {
    return await response.text();
  } catch {
    return '';
  }
}

function requestMeta(request) {
  return {
    forwarded_for: request.headers.get('cf-connecting-ip') || request.headers.get('x-forwarded-for') || null,
    user_agent: request.headers.get('user-agent') || null,
    referer: request.headers.get('referer') || request.headers.get('referrer') || null,
  };
}

async function forwardWebhook(request, webhookUrl, labels) {
  if (request.method === 'OPTIONS') {
    return new Response(null, {
      status: 204,
      headers: RESPONSE_HEADERS,
    });
  }

  if (request.method !== 'POST') {
    return jsonResponse(405, { error: 'Method not allowed.' });
  }

  if (!webhookUrl) {
    return jsonResponse(500, { error: `${labels.envName} is not configured.` });
  }

  let payload;
  try {
    payload = await request.json();
  } catch {
    return jsonResponse(400, { error: 'Invalid JSON payload.' });
  }

  const forwardedPayload = {
    ...payload,
    request: requestMeta(request),
  };

  try {
    const webhookResponse = await fetch(webhookUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(forwardedPayload),
    });

    if (!webhookResponse.ok) {
      const body = await readTextSafely(webhookResponse);
      return jsonResponse(502, {
        error: labels.rejectedMessage,
        status: webhookResponse.status,
        body: body.slice(0, 500),
      });
    }

    return jsonResponse(200, { ok: true });
  } catch (error) {
    return jsonResponse(502, {
      error: labels.failedMessage,
      message: error.message,
    });
  }
}

export default {
  async fetch(request, env) {
    const url = new URL(request.url);

    if (url.pathname === '/api/lead-webhook') {
      return forwardWebhook(request, env.WEBHOOK_URL || env.VITE_WEBHOOK_URL, {
        envName: 'WEBHOOK_URL',
        rejectedMessage: 'Webhook rejected the lead payload.',
        failedMessage: 'Webhook delivery failed.',
      });
    }

    if (url.pathname === '/api/workshop-webhook') {
      return forwardWebhook(request, env.WORKSHOP_WEBHOOK, {
        envName: 'WORKSHOP_WEBHOOK',
        rejectedMessage: 'Webhook rejected the workshop payload.',
        failedMessage: 'Workshop webhook delivery failed.',
      });
    }

    if (url.pathname.startsWith('/api/')) {
      return jsonResponse(404, { error: 'API route not found.' });
    }

    return env.ASSETS.fetch(request);
  },
};
