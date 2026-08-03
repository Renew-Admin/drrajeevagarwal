/**
 * CommonJS version of seoMeta.js for use in Node.js server.
 */

const blogMeta = require('../data/blogMeta.cjs');

const SITE_ORIGIN = 'https://drrajeevagarwal.co.in';

// Share card for any page without a more specific image. Must be a path under
// public/assets — anything imported through src/assets gets a content hash at
// build time and would break on the next deploy. 1140x500.
const DEFAULT_OG_IMAGE = '/assets/all-services-hero.webp';

const DEFAULT_META = {
  title: 'Dr. Rajeev Agarwal – Fertility Specialist & Gynaecologist in Kolkata',
  description:
    'Consult Dr. Rajeev Agarwal, a leading fertility specialist and gynaecologist in Kolkata with 25+ years of experience in IVF, IUI, laparoscopy, PCOS, and women’s health.',
};

const ROUTE_META = {
  '/': { ...DEFAULT_META },
  '/about-me': {
    title: 'About Dr. Rajeev Agarwal – Experience, Awards & Approach',
    description:
      'Learn about Dr. Rajeev Agarwal’s 25+ year journey in fertility medicine, his training, awards, publications, and patient-first philosophy at Renew Healthcare, Kolkata.',
  },
  '/all-services': {
    title: 'All Services – Fertility, Gynaecology & Women’s Health | Dr. Rajeev Agarwal',
    description:
      'Explore the full range of services by Dr. Rajeev Agarwal: IVF, IUI, laparoscopy, hysteroscopy, PCOS management, menopause care, fertility preservation, and more.',
  },
  '/book-an-appointment': {
    title: 'Book an Appointment with Dr. Rajeev Agarwal | Renew Healthcare Kolkata',
    description:
      'Schedule a consultation with Dr. Rajeev Agarwal for fertility treatment, gynaecological care, or preconception counselling. In-person and virtual appointments available.',
  },
  '/blog': {
    title: 'Health Blog – Fertility, Pregnancy & Women’s Health | Dr. Rajeev Agarwal',
    description:
      'Expert articles on fertility, pregnancy, PCOS, menopause, IVF, and women’s health by Dr. Rajeev Agarwal. Evidence-based guidance you can trust.',
  },
  '/doctors': {
    title: 'Our Doctors | Renew Healthcare Team',
    description:
      'Meet the specialist team at Renew Healthcare, Kolkata — experienced gynaecologists and fertility doctors led by Dr. Rajeev Agarwal.',
  },
  '/preconception': {
    title: 'Preconception Counselling in Kolkata | The Zero Trimester | Dr. Rajeev Agarwal',
    description:
      'Dr. Rajeev Agarwal offers structured preconception counselling in Kolkata — fertility tests, genetic screening, PCOS, thyroid, vaccination, and lifestyle optimisation for both partners. The Zero Trimester.',
  },
  '/preconception-workshop': {
    title: 'Preconception Workshop – Prepare for a Healthy Pregnancy | Dr. Rajeev Agarwal',
    description:
      'Join Dr. Rajeev Agarwal’s preconception workshop for expert guidance on fertility, nutrition, genetic screening, and planning a healthy pregnancy.',
  },
  '/success-stories': {
    title: 'Patient Success Stories | Dr. Rajeev Agarwal',
    description:
      'Read inspiring success stories from patients who achieved parenthood with Dr. Rajeev Agarwal’s expert fertility care at Renew Healthcare, Kolkata.',
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

  // ── Service pages ────────────────────────────────────────────────────────
  // These were previously title-cased from the slug, which produced broken
  // acronyms ("Pcos Care") and the ungrammatical description template
  // "Expert pcos care treatment and care by…". They carry the commercial
  // intent, so they get written meta.
  '/advanced-fertility-treatments': {
    title: 'IVF & ICSI Treatment in Kolkata | Dr. Rajeev Agarwal',
    description:
      'Advanced fertility treatment in Kolkata — IVF, ICSI, blastocyst transfer and embryo freezing, led by Dr. Rajeev Agarwal with 25+ years of experience.',
  },
  '/fertility-support-services': {
    title: 'Fertility Support Services in Kolkata | Dr. Rajeev Agarwal',
    description:
      'Counselling, nutrition, cycle monitoring and emotional support alongside fertility treatment at Renew Healthcare, Kolkata.',
  },
  '/fibroids-solutions': {
    title: 'Uterine Fibroid Treatment in Kolkata | Dr. Rajeev Agarwal',
    description:
      'Diagnosis and treatment of uterine fibroids in Kolkata — medical management, laparoscopic and hysteroscopic myomectomy, and fertility-sparing options.',
  },
  '/healthy-aging': {
    title: 'Healthy Aging for Women in Kolkata | Dr. Rajeev Agarwal',
    description:
      'Bone health, hormone balance, cardiovascular and metabolic screening for women through midlife and beyond, with Dr. Rajeev Agarwal in Kolkata.',
  },
  '/hysteroscopic-procedure': {
    title: 'Hysteroscopy in Kolkata — Diagnosis & Treatment | Dr. Rajeev Agarwal',
    description:
      'Diagnostic and operative hysteroscopy in Kolkata for polyps, fibroids, adhesions, septum and recurrent miscarriage, performed by Dr. Rajeev Agarwal.',
  },
  '/infertility-help': {
    title: 'Infertility Treatment in Kolkata | Dr. Rajeev Agarwal',
    description:
      'Structured infertility evaluation and treatment for couples in Kolkata — investigations, ovulation induction, IUI and IVF, guided by Dr. Rajeev Agarwal.',
  },
  '/laparoscopic-surgery': {
    title: 'Laparoscopic Gynaecological Surgery in Kolkata | Dr. Rajeev Agarwal',
    description:
      'Minimally invasive laparoscopic surgery in Kolkata for endometriosis, ovarian cysts, fibroids and blocked fallopian tubes, with faster recovery.',
  },
  '/learn-with-dr-rajeev-agarwal': {
    title: 'Learn With Dr. Rajeev Agarwal — Courses & Training',
    description:
      'Structured learning in fertility medicine and gynaecology for doctors, trainees and healthcare professionals, taught by Dr. Rajeev Agarwal.',
  },
  '/menopause-wellness': {
    title: 'Menopause Treatment & Wellness in Kolkata | Dr. Rajeev Agarwal',
    description:
      'Evidence-based menopause care in Kolkata — hot flushes, sleep, mood, bone and vaginal health, including hormone therapy where appropriate.',
  },
  '/pcos-care': {
    title: 'PCOS Treatment in Kolkata | Dr. Rajeev Agarwal',
    description:
      'Comprehensive PCOS care in Kolkata — diagnosis, insulin resistance, weight and cycle management, and fertility planning with Dr. Rajeev Agarwal.',
  },
  '/period-pain-relief': {
    title: 'Period Pain Treatment in Kolkata | Dr. Rajeev Agarwal',
    description:
      'Severe or worsening period pain is not something to endure. Diagnosis and treatment of dysmenorrhoea, endometriosis and adenomyosis in Kolkata.',
  },
  '/sexual-pain-relief': {
    title: 'Painful Intercourse Treatment in Kolkata | Dr. Rajeev Agarwal',
    description:
      'Confidential assessment and treatment of dyspareunia and sexual pain in Kolkata — medical, physiotherapy and counselling-based approaches.',
  },
  '/urinary-incontinence': {
    title: 'Urinary Incontinence Treatment for Women in Kolkata | Dr. Rajeev Agarwal',
    description:
      'Treatment for stress and urge urinary incontinence in Kolkata — pelvic floor therapy, laser treatment and surgical options for lasting relief.',
  },
  '/urinary-laser-therapy': {
    title: 'Urinary Laser Therapy in Kolkata | Dr. Rajeev Agarwal',
    description:
      'Non-surgical laser therapy for urinary incontinence and vaginal laxity in Kolkata — a short, day-care procedure with minimal downtime.',
  },
  '/vaginismus-therapy': {
    title: 'Vaginismus Treatment in Kolkata | Dr. Rajeev Agarwal',
    description:
      'Sensitive, structured treatment for vaginismus in Kolkata — dilator therapy, pelvic floor work and counselling, at your own pace.',
  },
  '/virtual-consults': {
    title: 'Online Fertility Consultation | Dr. Rajeev Agarwal',
    description:
      'Consult Dr. Rajeev Agarwal online from anywhere in India or abroad — second opinions, report reviews and treatment planning by video.',
  },
  '/womens-health-check': {
    title: "Women's Health Check-up in Kolkata | Dr. Rajeev Agarwal",
    description:
      'Preventive health checks for women in Kolkata — cervical screening, ultrasound, hormone and metabolic tests, tailored to your age and history.',
  },
};

function getMetaForPath(pathname) {
  const clean = (pathname || '/').replace(/\/+$/, '') || '/';

  if (ROUTE_META[clean]) {
    return Object.assign({}, ROUTE_META[clean], {
      canonicalUrl: SITE_ORIGIN + clean,
      image: DEFAULT_OG_IMAGE,
    });
  }

  // Blog post: /blog/<slug>. Real title/description/image come from
  // blogMeta.cjs, generated by scripts/gen-seo-assets.mjs from the post body.
  const blogMatch = clean.match(/^\/blog\/(.+)/);
  if (blogMatch) {
    const slug = blogMatch[1];
    const post = blogMeta[slug];

    if (post) {
      return {
        title: post.title,
        headline: post.headline,
        description: post.description,
        canonicalUrl: SITE_ORIGIN + clean,
        image: post.image || DEFAULT_OG_IMAGE,
        datePublished: post.date || undefined,
        articleSection: post.category || undefined,
        type: 'article',
      };
    }

    // Unknown slug: still emit something sane rather than an empty head.
    const readable = slug.replace(/-/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase());
    return {
      title: `${readable} | Dr. Rajeev Agarwal Blog`,
      description: `Read this article on ${readable.toLowerCase()} by Dr. Rajeev Agarwal, fertility specialist and gynaecologist in Kolkata.`,
      canonicalUrl: SITE_ORIGIN + clean,
      image: DEFAULT_OG_IMAGE,
    };
  }

  // Top-level page not in ROUTE_META (e.g. a doctor profile or a new service
  // page added before its meta was written).
  const segments = clean.split('/').filter(Boolean);
  if (segments.length === 1) {
    const slug = segments[0];
    const readable = slug.replace(/-/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase());
    return {
      title: `${readable} | Dr. Rajeev Agarwal`,
      description: `${readable} at Renew Healthcare, Kolkata — with Dr. Rajeev Agarwal, fertility specialist and gynaecologist.`,
      canonicalUrl: SITE_ORIGIN + clean,
      image: DEFAULT_OG_IMAGE,
    };
  }

  return Object.assign({}, DEFAULT_META, {
    canonicalUrl: SITE_ORIGIN + clean,
    image: DEFAULT_OG_IMAGE,
  });
}

/* ─────────────────────────────────────────────
 * Head-tag rendering
 *
 * scripts/prerender.mjs and src/worker.js both need the identical block. It
 * lived in both files, which is how og:image came to be missing from both —
 * there was no single place to add it. One implementation now.
 * ───────────────────────────────────────────── */

function escapeHtml(str) {
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/"/g, '&quot;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;');
}

/**
 * Remove SEO tags already present in the HTML before injecting the per-route
 * block, so a page can never end up with two canonicals or two descriptions.
 */
function stripExistingSeoTags(html) {
  return html
    .replace(/[ \t]*<meta[^>]*\sname=["']description["'][^>]*>\s*/gi, '')
    .replace(/[ \t]*<link[^>]*\srel=["']canonical["'][^>]*>\s*/gi, '')
    .replace(/[ \t]*<meta[^>]*\sproperty=["']og:[^"']*["'][^>]*>\s*/gi, '')
    .replace(/[ \t]*<meta[^>]*\sproperty=["']article:[^"']*["'][^>]*>\s*/gi, '')
    .replace(/[ \t]*<meta[^>]*\sname=["']twitter:[^"']*["'][^>]*>\s*/gi, '')
    .replace(/[ \t]*<script[^>]*type=["']application\/ld\+json["'][^>]*>[\s\S]*?<\/script>\s*/gi, '');
}

/**
 * The full per-route head block: description, canonical, Open Graph, Twitter
 * card and article timestamps. Returns a string of tags separated by the
 * indentation used in index.html.
 */
function buildSeoTags(pathname) {
  const meta = getMetaForPath(pathname);
  const title = escapeHtml(meta.title);
  const description = escapeHtml(meta.description);
  const canonical = escapeHtml(meta.canonicalUrl);
  const imageUrl = escapeHtml(
    (meta.image || DEFAULT_OG_IMAGE).startsWith('http')
      ? meta.image
      : SITE_ORIGIN + (meta.image || DEFAULT_OG_IMAGE),
  );

  const tags = [
    `<meta name="description" content="${description}">`,
    `<link rel="canonical" href="${canonical}">`,
    `<meta property="og:title" content="${title}">`,
    `<meta property="og:description" content="${description}">`,
    `<meta property="og:url" content="${canonical}">`,
    `<meta property="og:type" content="${meta.type === 'article' ? 'article' : 'website'}">`,
    `<meta property="og:site_name" content="Dr. Rajeev Agarwal">`,
    `<meta property="og:locale" content="en_IN">`,
    `<meta property="og:image" content="${imageUrl}">`,
    `<meta property="og:image:alt" content="${title}">`,
    `<meta name="twitter:card" content="summary_large_image">`,
    `<meta name="twitter:title" content="${title}">`,
    `<meta name="twitter:description" content="${description}">`,
    `<meta name="twitter:image" content="${imageUrl}">`,
  ];

  if (meta.type === 'article' && meta.datePublished) {
    tags.push(`<meta property="article:published_time" content="${escapeHtml(meta.datePublished)}">`);
    tags.push(`<meta property="article:author" content="Dr. Rajeev Agarwal">`);
    if (meta.articleSection) {
      tags.push(`<meta property="article:section" content="${escapeHtml(meta.articleSection)}">`);
    }
  }

  return tags.join('\n    ');
}

module.exports = {
  SITE_ORIGIN,
  DEFAULT_META,
  DEFAULT_OG_IMAGE,
  ROUTE_META,
  getMetaForPath,
  escapeHtml,
  stripExistingSeoTags,
  buildSeoTags,
};
