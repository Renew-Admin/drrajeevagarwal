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

const { SITE_ORIGIN, DEFAULT_META, DEFAULT_OG_IMAGE, getMetaForPath } = require('./seoMeta.cjs');

const ORG_ID = `${SITE_ORIGIN}/#clinic`;
const PHYSICIAN_ID = `${SITE_ORIGIN}/#physician`;
const WEBSITE_ID = `${SITE_ORIGIN}/#website`;
const LOGO_URL = `${SITE_ORIGIN}/assets/2025/03/cropped-Favicon-192x192.webp`;

// NAP — kept identical to CLINIC_INFO in src/components/WebMcpTools.jsx and the
// contact block in src/components/Footer.jsx. Name/address/phone consistency
// across a site and its directory listings is the strongest local ranking
// signal there is, so these three must never disagree.
const CLINIC_NAME = 'Renew Healthcare — Dr. Rajeev Agarwal';
const CLINIC_PHONE = '+91-83369-68661';
const CLINIC_EMAIL = 'fertilitywithoutborders@gmail.com';
const CLINIC_ADDRESS = {
  '@type': 'PostalAddress',
  streetAddress: '18C Mandeville Gardens',
  addressLocality: 'Kolkata',
  addressRegion: 'West Bengal',
  postalCode: '700019',
  addressCountry: 'IN',
};

// Profiles Google uses to reconcile this practice with the same entity
// elsewhere. Mirrors the social links in src/components/Footer.jsx.
const SAME_AS = [
  'https://www.facebook.com/profile.php?id=100064167933706',
  'https://www.instagram.com/docrajeevagarwal/',
  'https://www.youtube.com/@DrRajeevAgarwal',
  'https://www.linkedin.com/in/drrajeevagarwal/',
];

const OPENING_HOURS = [
  {
    '@type': 'OpeningHoursSpecification',
    dayOfWeek: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
    opens: '09:00',
    closes: '19:00',
  },
];

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
      // Prefer a blog post's real headline over a title-cased slug, so the
      // crumb reads "PCOS Diet: Food To Eat & Avoid With PCOS" rather than
      // "Pcos Diet Foods To Eat And Avoid". headline is only set for articles.
      const name = BREADCRUMB_LABELS[seg]
        || getMetaForPath(acc).headline
        || humanizeSegment(seg);
      items.push({ name, url: SITE_ORIGIN + acc });
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

/**
 * BlogPosting for /blog/<slug>, built from the same metadata that produces the
 * page's <title> and og:image. Returns null for any other route.
 */
function buildArticle(pathname) {
  const meta = getMetaForPath(pathname);
  if (meta.type !== 'article') return null;

  const article = {
    '@type': 'BlogPosting',
    '@id': `${meta.canonicalUrl}#article`,
    headline: meta.headline || meta.title,
    description: meta.description,
    url: meta.canonicalUrl,
    mainEntityOfPage: { '@type': 'WebPage', '@id': meta.canonicalUrl },
    image: (meta.image || DEFAULT_OG_IMAGE).startsWith('http')
      ? meta.image
      : SITE_ORIGIN + (meta.image || DEFAULT_OG_IMAGE),
    author: { '@id': PHYSICIAN_ID },
    publisher: { '@id': ORG_ID },
    inLanguage: 'en-IN',
    isAccessibleForFree: true,
  };

  if (meta.datePublished) {
    article.datePublished = meta.datePublished;
    // No separate edit timestamp is tracked, so modified === published rather
    // than a fabricated "updated today".
    article.dateModified = meta.datePublished;
  }
  if (meta.articleSection) article.articleSection = meta.articleSection;

  return article;
}

function buildJsonLdGraph(pathname) {
  const graph = [
    {
      '@type': ['MedicalClinic', 'MedicalBusiness'],
      '@id': ORG_ID,
      name: CLINIC_NAME,
      url: `${SITE_ORIGIN}/`,
      description: DEFAULT_META.description,
      image: LOGO_URL,
      logo: LOGO_URL,
      telephone: CLINIC_PHONE,
      email: CLINIC_EMAIL,
      address: CLINIC_ADDRESS,
      openingHoursSpecification: OPENING_HOURS,
      medicalSpecialty: ['Gynecologic', 'Obstetric', 'Endocrine'],
      areaServed: [
        { '@type': 'City', name: 'Kolkata' },
        { '@type': 'City', name: 'Jamshedpur' },
      ],
      founder: { '@id': PHYSICIAN_ID },
      sameAs: SAME_AS,
    },
    {
      '@type': 'Physician',
      '@id': PHYSICIAN_ID,
      name: 'Dr. Rajeev Agarwal',
      url: `${SITE_ORIGIN}/about-me`,
      jobTitle: 'Fertility Specialist & Gynaecologist',
      medicalSpecialty: ['Gynecologic', 'Obstetric', 'Endocrine'],
      knowsAbout: [
        'In Vitro Fertilisation (IVF)',
        'Intrauterine Insemination (IUI)',
        'Polycystic Ovary Syndrome (PCOS)',
        'Endometriosis',
        'Preconception Counselling',
        'Laparoscopic and Hysteroscopic Surgery',
        'Menopause Management',
        'Male Infertility',
      ],
      worksFor: { '@id': ORG_ID },
      address: CLINIC_ADDRESS,
      telephone: CLINIC_PHONE,
      image: LOGO_URL,
      sameAs: SAME_AS,
    },
    {
      '@type': 'WebSite',
      '@id': WEBSITE_ID,
      name: 'Dr. Rajeev Agarwal',
      url: `${SITE_ORIGIN}/`,
      inLanguage: 'en-IN',
      publisher: { '@id': ORG_ID },
    },
    buildBreadcrumb(pathname),
  ];

  const article = buildArticle(pathname);
  if (article) graph.push(article);

  return graph;
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
