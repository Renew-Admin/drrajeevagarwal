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

export async function onRequest({ request, env }) {
  if (request.method === 'OPTIONS') {
    return new Response(null, {
      status: 204,
      headers: RESPONSE_HEADERS,
    });
  }

  if (request.method !== 'POST') {
    return jsonResponse(405, { error: 'Method not allowed.' });
  }

  const webhookUrl = env.WEBHOOK_URL || env.VITE_WEBHOOK_URL;

  if (!webhookUrl) {
    return jsonResponse(500, { error: 'WEBHOOK_URL is not configured.' });
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
        error: 'Webhook rejected the lead payload.',
        status: webhookResponse.status,
        body: body.slice(0, 500),
      });
    }

    return jsonResponse(200, { ok: true });
  } catch (error) {
    return jsonResponse(502, {
      error: 'Webhook delivery failed.',
      message: error.message,
    });
  }
}
