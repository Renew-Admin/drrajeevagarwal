// analytics — the one place drrajeevagarwal.co.in talks to Google Analytics 4.
//
// Measurement ID G-DJR8P0KSK5 is the stream created on 16 Oct 2026
// ("drrajeevagarwal.co.in (2026-10 clean)", stream 16140752144, property
// 324098394). The previous ID G-VD03ZWG8Q4 was also pasted into third-party
// Exly storefronts, whose page views were mixing into this site's reports.
//
// Rules (see docs/ANALYTICS.md):
//   * Only production hostnames send data (gtag `ga-disable-<ID>` elsewhere).
//   * /admin is never tracked.
//   * Event parameters are allow-listed short tokens — never form values,
//     phone numbers, emails, names, purpose of visit or quiz answers.
//   * page_location keeps only campaign parameters.
export const GA_MEASUREMENT_ID = 'G-DJR8P0KSK5';

export const PRODUCTION_HOSTS = ['drrajeevagarwal.co.in', 'www.drrajeevagarwal.co.in'];

export const ALLOWED_QUERY_KEYS = [
  'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'utm_id',
  'gclid', 'gbraid', 'wbraid', 'dclid',
];

const EVENT_PARAMS = {
  page_view: ['page_location', 'page_title', 'page_category', 'send_to'],
  generate_lead: ['form_type', 'page_category'],
  form_error: ['form_type', 'error_field', 'error_type', 'page_category'],
  phone_click: ['cta_location', 'page_category'],
  whatsapp_click: ['cta_location', 'page_category'],
  email_click: ['cta_location', 'page_category'],
  appointment_cta_click: ['cta_location', 'cta_type', 'page_category'],
};

const TOKEN = /^[a-z0-9][a-z0-9_-]{0,39}$/;

export function isTrackedPath(pathname = '') {
  return !(pathname === '/admin' || pathname.startsWith('/admin/'));
}

export function isProductionHost(hostname = '') {
  return PRODUCTION_HOSTS.includes(hostname);
}

export function cleanPageLocation(href) {
  try {
    const url = new URL(href);
    const kept = new URLSearchParams();
    for (const key of ALLOWED_QUERY_KEYS) {
      const value = url.searchParams.get(key);
      if (value) kept.set(key, value.slice(0, 100));
    }
    const query = kept.toString();
    return `${url.origin}${url.pathname}${query ? `?${query}` : ''}`;
  } catch {
    return '';
  }
}

/** Generic section only — article and service slugs can name a condition. */
export function pageCategory(pathname = '/') {
  if (pathname === '/' || pathname === '') return 'home';
  const first = pathname.split('/').filter(Boolean)[0] || '';
  const map = {
    'about-me': 'trust_page',
    'success-stories': 'trust_page',
    preconception: 'program_page',
    'preconception-workshop': 'workshop',
    blog: 'blog',
    'book-an-appointment': 'booking',
    'all-services': 'service_page',
    courses: 'course',
    'menopause-care': 'program_page',
    'privacy-policy': 'policy',
    'terms-conditions': 'policy',
    'disclaimer-policy': 'policy',
    'cancellation-refund-policy': 'policy',
  };
  return map[first] || 'content_page';
}

/** Map a human form name ("Course Enrolment - …") to a stable token. */
export function formTypeFromName(formName = '') {
  const name = String(formName).toLowerCase();
  if (name.includes('workshop')) return 'workshop_registration';
  if (name.includes('course')) return 'course_enrolment';
  if (name.includes('perimenopause') || name.includes('quiz')) return 'menopause_quiz';
  if (name.includes('menopause')) return 'menopause_booking';
  if (name.includes('floating')) return 'floating_form';
  if (name.includes('header') || name.includes('sticky')) return 'popup_appointment';
  if (name.includes('appointment') || name.includes('booking')) return 'appointment';
  return 'website_form';
}

export function sanitizeParams(name, params = {}) {
  const allowed = EVENT_PARAMS[name];
  if (!allowed) return null;
  const out = {};
  for (const key of allowed) {
    const value = params[key];
    if (value === undefined || value === null || value === '') continue;
    if (key === 'page_location') {
      const cleaned = cleanPageLocation(String(value));
      if (cleaned) out.page_location = cleaned;
    } else if (key === 'page_title') {
      out.page_title = String(value).slice(0, 120);
    } else if (key === 'send_to') {
      out.send_to = GA_MEASUREMENT_ID;
    } else {
      const token = String(value).toLowerCase();
      if (TOKEN.test(token)) out[key] = token;
    }
  }
  return out;
}

export function analyticsAllowed() {
  if (typeof window === 'undefined') return false;
  if (window[`ga-disable-${GA_MEASUREMENT_ID}`]) return false;
  return isProductionHost(window.location.hostname) && isTrackedPath(window.location.pathname);
}

/** Send one GA4 event. Never throws, never blocks. */
export function track(name, params = {}) {
  try {
    if (!analyticsAllowed() || typeof window.gtag !== 'function') return false;
    const clean = sanitizeParams(name, { page_category: pageCategory(window.location.pathname), ...params });
    if (!clean) return false;
    window.gtag('event', name, { ...clean, send_to: GA_MEASUREMENT_ID });
    return true;
  } catch {
    return false;
  }
}
