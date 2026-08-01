/**
 * schema.org JSON-LD graph, shared by every renderer.
 *
 * Emitted as .cjs so the same code loads identically under Node ESM
 * (scripts/prerender.mjs), Node CJS (server/render-server.cjs) and esbuild
 * (wrangler bundling src/worker.js) — the same reason src/data/blogSlugs.cjs
 * is a .cjs file.
 *
 * scripts/prerender.mjs bakes the output into every prerendered page at build
 * time. That is what actually ships on Cloudflare, where static assets are
 * served without invoking the Worker.
 */

const { SITE_ORIGIN, DEFAULT_META } = require('./seoMeta.cjs');

const ORG_ID = `${SITE_ORIGIN}/#clinic`;
const PHYSICIAN_ID = `${SITE_ORIGIN}/#physician`;
const WEBSITE_ID = `${SITE_ORIGIN}/#website`;
const LOGO_URL = `${SITE_ORIGIN}/assets/2025/03/cropped-Favicon-192x192.webp`;

const BREADCRUMB_LABELS = {
  'about-me': 'About',
  'all-services': 'Services',
  'book-an-appointment': 'Book an Appointment',
  blog: 'Blog',
};

function humanizeSegment(seg) {
  return seg.replace(/-/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase());
}

function buildBreadcrumb(pathname) {
  const clean = (pathname || '/').replace(/\/+$/, '') || '/';
  const items = [{ name: 'Home', url: `${SITE_ORIGIN}/` }];

  if (clean !== '/') {
    let acc = '';
    for (const seg of clean.split('/').filter(Boolean)) {
      acc += `/${seg}`;
      items.push({ name: BREADCRUMB_LABELS[seg] || humanizeSegment(seg), url: SITE_ORIGIN + acc });
    }
  }

  return {
    '@type': 'BreadcrumbList',
    itemListElement: items.map((it, i) => ({
      '@type': 'ListItem',
      position: i + 1,
      name: it.name,
      item: it.url,
    })),
  };
}

function buildJsonLdGraph(pathname) {
  return [
    {
      '@type': ['MedicalClinic', 'MedicalBusiness'],
      '@id': ORG_ID,
      name: 'Dr. Rajeev Agarwal — Renew Healthcare',
      url: `${SITE_ORIGIN}/`,
      description: DEFAULT_META.description,
      image: LOGO_URL,
      logo: LOGO_URL,
      medicalSpecialty: ['Gynecologic', 'Obstetric', 'Endocrine'],
      areaServed: { '@type': 'City', name: 'Kolkata' },
      founder: { '@id': PHYSICIAN_ID },
      // TODO(NAP): add address + telephone once confirmed for GBP/Justdial/Practo.
    },
    {
      '@type': 'Physician',
      '@id': PHYSICIAN_ID,
      name: 'Dr. Rajeev Agarwal',
      url: `${SITE_ORIGIN}/about-me`,
      jobTitle: 'Fertility Specialist & Gynaecologist',
      medicalSpecialty: ['Gynecologic', 'Obstetric', 'Endocrine'],
      worksFor: { '@id': ORG_ID },
      image: LOGO_URL,
    },
    {
      '@type': 'WebSite',
      '@id': WEBSITE_ID,
      name: 'Dr. Rajeev Agarwal',
      url: `${SITE_ORIGIN}/`,
      publisher: { '@id': ORG_ID },
    },
    buildBreadcrumb(pathname),
  ];
}

/**
 * @param {string} pathname Route the page is being rendered for.
 * @returns {string} A complete <script type="application/ld+json"> element.
 */
function buildJsonLd(pathname) {
  const json = JSON.stringify({
    '@context': 'https://schema.org',
    '@graph': buildJsonLdGraph(pathname),
  })
    // Escape "<" so a stray "</script>" in any value cannot break out of the tag.
    .replace(/</g, '\\u003c');

  return `<script type="application/ld+json">${json}</script>`;
}

module.exports = { buildJsonLd, buildJsonLdGraph };
