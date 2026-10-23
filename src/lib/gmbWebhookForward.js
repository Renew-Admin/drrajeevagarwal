/* ─────────────────────────────────────────────
 * GMB post → Make.com forwarder, shared by the Cloudflare Worker
 * (/api/gmb-webhook) and the Vite dev server.
 *
 * The browser only sends the post id plus the admin's Supabase session.
 * The row is re-read from Supabase with that session (RLS: authenticated
 * only), so a visitor without an admin login cannot push anything to the
 * Google Business Profile scenario, and the webhook always receives the
 * saved row rather than whatever the browser claims.
 * ───────────────────────────────────────────── */
export const GMB_SUPABASE_URL_FALLBACK = 'https://etwprdlmxirnuejxxuif.supabase.co';

const UUID_PATTERN = /^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i;

export function formatGmbWebhookPayload(row) {
  return {
    ...row,
    PostDate: String(row.PostDate || '').slice(0, 10),
    TimeSchedule: String(row.TimeSchedule || '').slice(0, 5),
  };
}

export async function forwardGmbPost({ id, token, apikey, supabaseUrl, webhookUrl }) {
  if (!webhookUrl) return { status: 500, body: { error: 'GMB_WEBHOOK_URL is not configured.' } };
  if (!token || !apikey) return { status: 401, body: { error: 'Admin login required.' } };
  if (!UUID_PATTERN.test(String(id || ''))) return { status: 400, body: { error: 'Invalid post id.' } };

  let rows;
  try {
    const response = await fetch(`${supabaseUrl}/rest/v1/gmb_posts?select=*&id=eq.${id}&limit=1`, {
      headers: { apikey, Authorization: `Bearer ${token}` },
    });
    if (response.status === 401 || response.status === 403) {
      return { status: 401, body: { error: 'Admin login required.' } };
    }
    if (!response.ok) return { status: 502, body: { error: 'Could not read the GMB post.' } };
    rows = await response.json();
  } catch {
    return { status: 502, body: { error: 'Could not read the GMB post.' } };
  }

  if (!Array.isArray(rows) || !rows[0]) return { status: 404, body: { error: 'GMB post not found.' } };

  try {
    const webhookResponse = await fetch(webhookUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(formatGmbWebhookPayload(rows[0])),
    });
    await webhookResponse.text().catch(() => '');
    if (!webhookResponse.ok) {
      return { status: 502, body: { error: 'Webhook rejected the GMB post.', status: webhookResponse.status } };
    }
    return { status: 200, body: { ok: true } };
  } catch {
    return { status: 502, body: { error: 'GMB webhook delivery failed.' } };
  }
}
