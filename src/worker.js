/* ─────────────────────────────────────────────
 * SEO constants & helpers (inlined from seoMeta.js)
 * ───────────────────────────────────────────── */

const SITE_ORIGIN = 'https://drrajeevagarwal.co.in';

const DEFAULT_META = {
  title: 'Dr. Rajeev Agarwal \u2013 Fertility Specialist & Gynaecologist in Kolkata',
  description:
    'Consult Dr. Rajeev Agarwal, a leading fertility specialist and gynaecologist in Kolkata with 25+ years of experience in IVF, IUI, laparoscopy, PCOS, and women\u2019s health.',
};

const ROUTE_META = {
  '/': { ...DEFAULT_META },
  '/about-me': {
    title: 'About Dr. Rajeev Agarwal \u2013 Experience, Awards & Approach',
    description:
      'Learn about Dr. Rajeev Agarwal\u2019s 25+ year journey in fertility medicine, his training, awards, publications, and patient-first philosophy at Renew Healthcare, Kolkata.',
  },
  '/all-services': {
    title: 'All Services \u2013 Fertility, Gynaecology & Women\u2019s Health | Dr. Rajeev Agarwal',
    description:
      'Explore the full range of services by Dr. Rajeev Agarwal: IVF, IUI, laparoscopy, hysteroscopy, PCOS management, menopause care, fertility preservation, and more.',
  },
  '/book-an-appointment': {
    title: 'Book an Appointment with Dr. Rajeev Agarwal | Renew Healthcare Kolkata',
    description:
      'Schedule a consultation with Dr. Rajeev Agarwal for fertility treatment, gynaecological care, or preconception counselling. In-person and virtual appointments available.',
  },
  '/blog': {
    title: 'Health Blog \u2013 Fertility, Pregnancy & Women\u2019s Health | Dr. Rajeev Agarwal',
    description:
      'Expert articles on fertility, pregnancy, PCOS, menopause, IVF, and women\u2019s health by Dr. Rajeev Agarwal. Evidence-based guidance you can trust.',
  },
  '/doctors': {
    title: 'Our Doctors | Renew Healthcare Team',
    description:
      'Meet the specialist team at Renew Healthcare, Kolkata \u2014 experienced gynaecologists and fertility doctors led by Dr. Rajeev Agarwal.',
  },
  '/preconception': {
    title: 'Preconception Counselling in Kolkata | The Zero Trimester | Dr. Rajeev Agarwal',
    description:
      'Dr. Rajeev Agarwal offers structured preconception counselling in Kolkata — fertility tests, genetic screening, PCOS, thyroid, vaccination, and lifestyle optimisation for both partners. The Zero Trimester.',
  },
  '/preconception-workshop': {
    title: 'Preconception Workshop \u2013 Prepare for a Healthy Pregnancy | Dr. Rajeev Agarwal',
    description:
      'Join Dr. Rajeev Agarwal\u2019s preconception workshop for expert guidance on fertility, nutrition, genetic screening, and planning a healthy pregnancy.',
  },
  '/success-stories': {
    title: 'Patient Success Stories | Dr. Rajeev Agarwal',
    description:
      'Read inspiring success stories from patients who achieved parenthood with Dr. Rajeev Agarwal\u2019s expert fertility care at Renew Healthcare, Kolkata.',
  },
  '/courses': {
    title: 'Medical Courses & Training | Dr. Rajeev Agarwal',
    description:
      'Explore medical courses and professional training in fertility medicine and gynaecology by Dr. Rajeev Agarwal for doctors and healthcare professionals.',
  },
  '/privacy-policy': {
    title: 'Privacy Policy | Dr. Rajeev Agarwal',
    description: 'Read the privacy policy for drrajeevagarwal.co.in. Learn how we collect, use, and protect your personal information.',
  },
  '/terms-conditions': {
    title: 'Terms & Conditions | Dr. Rajeev Agarwal',
    description: 'Review the terms and conditions for using drrajeevagarwal.co.in and Renew Healthcare services.',
  },
  '/disclaimer-policy': {
    title: 'Medical Disclaimer | Dr. Rajeev Agarwal',
    description:
      'Read the medical disclaimer for drrajeevagarwal.co.in. Content is for informational purposes only and does not replace professional medical advice.',
  },
  '/cancellation-refund-policy': {
    title: 'Cancellation & Refund Policy | Dr. Rajeev Agarwal',
    description: 'Review the cancellation and refund policy for appointments and services at Renew Healthcare with Dr. Rajeev Agarwal.',
  },
};

function getMetaForPath(pathname) {
  const clean = (pathname || '/').replace(/\/+$/, '') || '/';

  if (ROUTE_META[clean]) {
    return { ...ROUTE_META[clean], canonicalUrl: SITE_ORIGIN + clean };
  }

  // Blog post: /blog/<slug>
  const blogMatch = clean.match(/^\/blog\/(.+)/);
  if (blogMatch) {
    const slug = blogMatch[1];
    const readable = slug.replace(/-/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase());
    return {
      title: `${readable} | Dr. Rajeev Agarwal Blog`,
      description: `Read this article on ${readable.toLowerCase()} by Dr. Rajeev Agarwal, fertility specialist and gynaecologist in Kolkata.`,
      canonicalUrl: SITE_ORIGIN + clean,
    };
  }

  // Top-level service page: /<slug>
  const segments = clean.split('/').filter(Boolean);
  if (segments.length === 1) {
    const slug = segments[0];
    const readable = slug.replace(/-/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase());
    return {
      title: `${readable} | Dr. Rajeev Agarwal`,
      description: `Expert ${readable.toLowerCase()} treatment and care by Dr. Rajeev Agarwal, leading fertility specialist and gynaecologist in Kolkata.`,
      canonicalUrl: SITE_ORIGIN + clean,
    };
  }

  return { ...DEFAULT_META, canonicalUrl: SITE_ORIGIN + clean };
}

function escapeHtml(str) {
  return str
    .replace(/&/g, '&amp;')
    .replace(/"/g, '&quot;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;');
}

/**
 * Remove any SEO tags already present in the served HTML before we inject the
 * per-route block. Cloudflare's single-page-application fallback serves the
 * root build/index.html (which has homepage canonical/description/OG baked in
 * by scripts/inject-seo-tags.mjs) for unbaked routes such as /blog/<slug>, and
 * even baked routes arrive here with a correct-but-duplicate block. Stripping
 * first guarantees exactly one canonical per page pointing at the right URL.
 */
function stripExistingSeoTags(html) {
  return html
    .replace(/[ \t]*<meta[^>]*\sname=["']description["'][^>]*>\s*/gi, '')
    .replace(/[ \t]*<link[^>]*\srel=["']canonical["'][^>]*>\s*/gi, '')
    .replace(/[ \t]*<meta[^>]*\sproperty=["']og:[^"']*["'][^>]*>\s*/gi, '');
}

function injectSeoTags(html, pathname) {
  const meta = getMetaForPath(pathname);
  const safeTitle = escapeHtml(meta.title);
  const safeDesc = escapeHtml(meta.description);
  const safeCanonical = escapeHtml(meta.canonicalUrl);

  // Remove any pre-baked description/canonical/OG tags so we never emit duplicates.
  html = stripExistingSeoTags(html);

  // Replace <title>…</title>
  html = html.replace(/<title>[^<]*<\/title>/, `<title>${safeTitle}</title>`);

  // Build the meta / OG block to inject right after </title>
  const seoBlock = [
    `<meta name="description" content="${safeDesc}">`,
    `<link rel="canonical" href="${safeCanonical}">`,
    `<meta property="og:title" content="${safeTitle}">`,
    `<meta property="og:description" content="${safeDesc}">`,
    `<meta property="og:url" content="${safeCanonical}">`,
    `<meta property="og:type" content="website">`,
    `<meta property="og:site_name" content="Dr. Rajeev Agarwal">`,
  ].join('\n    ');

  html = html.replace('</title>', `</title>\n    ${seoBlock}`);

  return html;
}

/* ─────────────────────────────────────────────
 * Static-asset extension set (pass-through)
 * ───────────────────────────────────────────── */

const STATIC_EXT = /\.(?:js|css|webp|svg|png|jpg|jpeg|woff2|xml|txt|json|ico|gif|map)$/i;

/* ─────────────────────────────────────────────
 * Webhook helpers
 * ───────────────────────────────────────────── */

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

/* ─────────────────────────────────────────────
 * Legacy WordPress URL cleanup (mirrors public/.htaccess)
 * Returns a Response for legacy paths, or null to continue normal handling.
 * ───────────────────────────────────────────── */

function gone() {
  return new Response('Gone', {
    status: 410,
    headers: { 'Content-Type': 'text/plain; charset=utf-8', 'Cache-Control': 'no-store' },
  });
}

function forbidden() {
  return new Response('Forbidden', {
    status: 403,
    headers: { 'Content-Type': 'text/plain; charset=utf-8', 'Cache-Control': 'no-store' },
  });
}

function legacyWordPressResponse(url) {
  const { pathname, search } = url;

  // preconception-care → /preconception (301)
  if (pathname.replace(/\/+$/, '') === '/preconception-care') {
    return Response.redirect(`${SITE_ORIGIN}/preconception`, 301);
  }

  // WordPress attachment / post-id query params (?attachment_id= / ?p=) → 410 Gone
  if (/[?&](?:attachment_id|p)=/.test(search)) return gone();

  // xmlrpc.php → 403 Forbidden
  if (/^\/xmlrpc\.php$/i.test(pathname)) return forbidden();

  // wp-json / wp-admin / wp-login(.php) / wp-includes / wp-content → 410 Gone.
  // The trailing [/.] also catches file forms like /wp-login.php.
  // (note: /wp-styles/* are real assets and are intentionally NOT matched)
  if (/^\/wp-(?:admin|login|includes|content|json)(?:[/.]|$)/i.test(pathname)) {
    return gone();
  }

  // RSS / comment / trackback feeds (…/feed) → 301 to homepage
  if (/\/feed\/?$/i.test(pathname)) return Response.redirect(`${SITE_ORIGIN}/`, 301);

  // Author archives → 301 to About page
  if (/^\/author\/.+/i.test(pathname)) return Response.redirect(`${SITE_ORIGIN}/about-me`, 301);

  // WordPress pagination artifacts: /<parent>/page/N → /<parent>, /page/N → /
  const pageMatch = pathname.match(/^(\/.*?)?\/page\/\d+\/?$/i);
  if (pageMatch) {
    const parent = pageMatch[1] || '/';
    return Response.redirect(`${SITE_ORIGIN}${parent}`, 301);
  }

  return null;
}

export default {
  async fetch(request, env) {
    const url = new URL(request.url);

    // Legacy WordPress URL cleanup (301 / 410 / 403) — mirrors public/.htaccess.
    // Runs before asset pass-through so e.g. /wp-content/*.jpg 410s instead of 404-ing.
    const legacyResponse = legacyWordPressResponse(url);
    if (legacyResponse) return legacyResponse;

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

    if (url.pathname === '/version.json') {
      const versionResponse = await env.ASSETS.fetch(request);
      const headers = new Headers(versionResponse.headers);
      headers.set('Content-Type', 'application/json; charset=utf-8');
      headers.set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
      headers.set('CDN-Cache-Control', 'no-store');
      headers.set('Pragma', 'no-cache');
      headers.set('Expires', '0');

      return new Response(versionResponse.body, {
        status: versionResponse.status,
        headers,
      });
    }

    // Static assets — pass through directly
    if (STATIC_EXT.test(url.pathname)) {
      return env.ASSETS.fetch(request);
    }

    // Page routes — fetch HTML and inject SEO tags
    const assetResponse = await env.ASSETS.fetch(request);
    const html = await assetResponse.text();
    const modifiedHtml = injectSeoTags(html, url.pathname);

    const headers = new Headers(assetResponse.headers);
    headers.set('Content-Type', 'text/html; charset=utf-8');
    // HTML must revalidate so phones do not keep an old document that points
    // at an older Vite bundle. Hashed assets remain cacheable below.
    headers.set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    headers.set('CDN-Cache-Control', 'no-store');
    headers.set('Pragma', 'no-cache');
    headers.set('Expires', '0');

    return new Response(modifiedHtml, {
      status: assetResponse.status,
      headers,
    });
  },
};
