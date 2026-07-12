const JSON_HEADERS = {
  'Content-Type': 'application/json',
  'Cache-Control': 'no-store',
};

function jsonResponse(statusCode, body) {
  return {
    statusCode,
    headers: JSON_HEADERS,
    body: JSON.stringify(body),
  };
}

async function readTextSafely(response) {
  try {
    return await response.text();
  } catch {
    return '';
  }
}

exports.handler = async (event) => {
  if (event.httpMethod === 'OPTIONS') {
    return { statusCode: 204, headers: JSON_HEADERS, body: '' };
  }

  if (event.httpMethod !== 'POST') {
    return jsonResponse(405, { error: 'Method not allowed.' });
  }

  const webhookUrl = process.env.WEBHOOK_URL || process.env.VITE_WEBHOOK_URL;

  if (!webhookUrl) {
    return jsonResponse(500, { error: 'WEBHOOK_URL is not configured.' });
  }

  let payload;
  try {
    payload = JSON.parse(event.body || '{}');
  } catch {
    return jsonResponse(400, { error: 'Invalid JSON payload.' });
  }

  const forwardedPayload = {
    ...payload,
    request: {
      forwarded_for: event.headers['x-forwarded-for'] || null,
      user_agent: event.headers['user-agent'] || null,
      referer: event.headers.referer || event.headers.referrer || null,
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
};
