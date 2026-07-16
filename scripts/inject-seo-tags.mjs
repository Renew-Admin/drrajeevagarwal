/**
 * Post-build script: injects per-route SEO tags into index.html copies
 * for each known route, so that even on static hosting (cPanel/Apache)
 * Googlebot sees unique title, meta description, canonical, and OG tags
 * in the very first HTML response.
 *
 * Run after `vite build`:
 *   node scripts/inject-seo-tags.mjs
 */

import { existsSync, mkdirSync, readFileSync, writeFileSync } from 'node:fs';
import { dirname, join } from 'node:path';

const BUILD_DIR = join(process.cwd(), 'build');
const INDEX_FILE = join(BUILD_DIR, 'index.html');

if (!existsSync(INDEX_FILE)) {
  console.error('[seo] build/index.html not found — run vite build first.');
  process.exit(1);
}

const SITE_ORIGIN = 'https://drrajeevagarwal.co.in';

const ROUTE_META = {
  '/': {
    title: 'Dr. Rajeev Agarwal \u2013 Fertility Specialist & Gynaecologist in Kolkata',
    description: 'Consult Dr. Rajeev Agarwal, a leading fertility specialist and gynaecologist in Kolkata with 25+ years of experience in IVF, IUI, laparoscopy, PCOS, and women\u2019s health.',
  },
  '/about-me': {
    title: 'About Dr. Rajeev Agarwal \u2013 Experience, Awards & Approach',
    description: 'Learn about Dr. Rajeev Agarwal\u2019s 25+ year journey in fertility medicine, his training, awards, publications, and patient-first philosophy at Renew Healthcare, Kolkata.',
  },
  '/all-services': {
    title: 'All Services \u2013 Fertility, Gynaecology & Women\u2019s Health | Dr. Rajeev Agarwal',
    description: 'Explore the full range of services by Dr. Rajeev Agarwal: IVF, IUI, laparoscopy, hysteroscopy, PCOS management, menopause care, fertility preservation, and more.',
  },
  '/book-an-appointment': {
    title: 'Book an Appointment with Dr. Rajeev Agarwal | Renew Healthcare Kolkata',
    description: 'Schedule a consultation with Dr. Rajeev Agarwal for fertility treatment, gynaecological care, or preconception counselling. In-person and virtual appointments available.',
  },
  '/blog': {
    title: 'Health Blog \u2013 Fertility, Pregnancy & Women\u2019s Health | Dr. Rajeev Agarwal',
    description: 'Expert articles on fertility, pregnancy, PCOS, menopause, IVF, and women\u2019s health by Dr. Rajeev Agarwal. Evidence-based guidance you can trust.',
  },
  '/doctors': {
    title: 'Our Doctors | Renew Healthcare Team',
    description: 'Meet the specialist team at Renew Healthcare, Kolkata \u2014 experienced gynaecologists and fertility doctors led by Dr. Rajeev Agarwal.',
  },
  '/preconception': {
    title: 'Preconception Counselling | Dr. Rajeev Agarwal',
    description: 'Preconception counselling with Dr. Rajeev Agarwal helps couples prepare for pregnancy with clear fertility, nutrition, testing, and timing guidance.',
  },
  '/preconception-workshop': {
    title: 'Preconception Workshop \u2013 Prepare for a Healthy Pregnancy | Dr. Rajeev Agarwal',
    description: 'Join Dr. Rajeev Agarwal\u2019s preconception workshop for expert guidance on fertility, nutrition, genetic screening, and planning a healthy pregnancy.',
  },
  '/success-stories': {
    title: 'Patient Success Stories | Dr. Rajeev Agarwal',
    description: 'Read inspiring success stories from patients who achieved parenthood with Dr. Rajeev Agarwal\u2019s expert fertility care at Renew Healthcare, Kolkata.',
  },
  '/courses': {
    title: 'Medical Courses & Training | Dr. Rajeev Agarwal',
    description: 'Explore medical courses and professional training in fertility medicine and gynaecology by Dr. Rajeev Agarwal for doctors and healthcare professionals.',
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
    description: 'Read the medical disclaimer for drrajeevagarwal.co.in. Content is for informational purposes only and does not replace professional medical advice.',
  },
  '/cancellation-refund-policy': {
    title: 'Cancellation & Refund Policy | Dr. Rajeev Agarwal',
    description: 'Review the cancellation and refund policy for appointments and services at Renew Healthcare with Dr. Rajeev Agarwal.',
  },
  // Service pages (dynamic slugs from sitemap)
  '/advanced-fertility-treatments': {
    title: 'Advanced Fertility Treatments | Dr. Rajeev Agarwal',
    description: 'Expert advanced fertility treatments including IVF, ICSI, and assisted reproduction by Dr. Rajeev Agarwal, leading fertility specialist in Kolkata.',
  },
  '/fertility-support-services': {
    title: 'Fertility Support Services | Dr. Rajeev Agarwal',
    description: 'Comprehensive fertility support and personalised guidance for couples planning pregnancy with Dr. Rajeev Agarwal in Kolkata.',
  },
  '/fibroids-solutions': {
    title: 'Fibroid Solutions | Dr. Rajeev Agarwal',
    description: 'Medical and minimally invasive treatment options for fibroids affecting fertility or menstrual health by Dr. Rajeev Agarwal.',
  },
  '/healthy-aging': {
    title: 'Healthy Aging for Women | Dr. Rajeev Agarwal',
    description: 'Hormonal balance, bone health, metabolic wellness, and long-term women\u2019s health support by Dr. Rajeev Agarwal in Kolkata.',
  },
  '/hysteroscopic-procedure': {
    title: 'Hysteroscopic Procedures | Dr. Rajeev Agarwal',
    description: 'Minimally invasive hysteroscopic procedures for diagnosis and treatment of uterine conditions by Dr. Rajeev Agarwal.',
  },
  '/infertility-help': {
    title: 'Infertility Help & Treatment | Dr. Rajeev Agarwal',
    description: 'Expert evaluation and fertility planning for couples facing difficulty conceiving with Dr. Rajeev Agarwal in Kolkata.',
  },
  '/laparoscopic-surgery': {
    title: 'Laparoscopic Surgery | Dr. Rajeev Agarwal',
    description: 'Minimally invasive laparoscopic surgery for gynaecological conditions by Dr. Rajeev Agarwal, specialist surgeon in Kolkata.',
  },
  '/learn-with-dr-rajeev-agarwal': {
    title: 'Learn with Dr. Rajeev Agarwal | Medical Education',
    description: 'Educational resources and learning programmes in fertility medicine and gynaecology by Dr. Rajeev Agarwal.',
  },
  '/menopause-wellness': {
    title: 'Menopause Wellness | Dr. Rajeev Agarwal',
    description: 'Holistic support for menopause including hot flashes, mood changes, bone health, and hormonal guidance by Dr. Rajeev Agarwal.',
  },
  '/pcos-care': {
    title: 'PCOS Care & Treatment | Dr. Rajeev Agarwal',
    description: 'Expert PCOS diagnosis, hormonal support, lifestyle guidance, and fertility-focused treatment by Dr. Rajeev Agarwal in Kolkata.',
  },
  '/period-pain-relief': {
    title: 'Period Pain Relief | Dr. Rajeev Agarwal',
    description: 'Evaluation and treatment for severe menstrual pain, endometriosis, fibroids, and hormonal causes by Dr. Rajeev Agarwal.',
  },
  '/sexual-pain-relief': {
    title: 'Sexual Pain Relief | Dr. Rajeev Agarwal',
    description: 'Compassionate evaluation and treatment for pain during intercourse and pelvic discomfort by Dr. Rajeev Agarwal.',
  },
  '/urinary-incontinence': {
    title: 'Urinary Incontinence Treatment | Dr. Rajeev Agarwal',
    description: 'Modern care for urinary incontinence, pelvic health, and post-childbirth concerns by Dr. Rajeev Agarwal in Kolkata.',
  },
  '/urinary-laser-therapy': {
    title: 'Urinary Laser Therapy | Dr. Rajeev Agarwal',
    description: 'Advanced laser therapy for urinary and pelvic health conditions by Dr. Rajeev Agarwal, gynaecologist in Kolkata.',
  },
  '/vaginismus-therapy': {
    title: 'Vaginismus Therapy | Dr. Rajeev Agarwal',
    description: 'Expert vaginismus therapy and treatment for painful intercourse by Dr. Rajeev Agarwal, gynaecologist in Kolkata.',
  },
  '/virtual-consults': {
    title: 'Virtual Consultations | Dr. Rajeev Agarwal',
    description: 'Book a virtual consultation with Dr. Rajeev Agarwal for expert fertility and gynaecological guidance from the comfort of your home.',
  },
  '/womens-health-check': {
    title: 'Women\u2019s Health Check | Dr. Rajeev Agarwal',
    description: 'Comprehensive women\u2019s health check-ups and preventive screening by Dr. Rajeev Agarwal at Renew Healthcare, Kolkata.',
  },
};

function escapeHtml(str) {
  return str
    .replace(/&/g, '&amp;')
    .replace(/"/g, '&quot;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;');
}

function injectSeoTags(html, routePath) {
  const meta = ROUTE_META[routePath];
  if (!meta) return html;

  const canonicalUrl = SITE_ORIGIN + routePath;
  const safeTitle = escapeHtml(meta.title);
  const safeDesc = escapeHtml(meta.description);
  const safeUrl = escapeHtml(canonicalUrl);

  // Replace <title>
  let result = html.replace(
    /<title>[^<]*<\/title>/,
    `<title>${safeTitle}</title>`
  );

  // Inject SEO tags right after <title>…</title>
  const seoTags = [
    `<meta name="description" content="${safeDesc}">`,
    `<link rel="canonical" href="${safeUrl}">`,
    `<meta property="og:title" content="${safeTitle}">`,
    `<meta property="og:description" content="${safeDesc}">`,
    `<meta property="og:url" content="${safeUrl}">`,
    `<meta property="og:type" content="website">`,
    `<meta property="og:site_name" content="Dr. Rajeev Agarwal">`,
  ].join('\n    ');

  result = result.replace(
    /(<title>[^<]*<\/title>)/,
    `$1\n    ${seoTags}`
  );

  return result;
}

// ─── Main ──────────────────────────────────────────────────────────────
const baseHtml = readFileSync(INDEX_FILE, 'utf8');
let count = 0;

for (const [route, meta] of Object.entries(ROUTE_META)) {
  if (route === '/') continue; // Root index.html gets injected in-place

  const dirPath = join(BUILD_DIR, route.slice(1));
  const filePath = join(dirPath, 'index.html');

  mkdirSync(dirPath, { recursive: true });
  writeFileSync(filePath, injectSeoTags(baseHtml, route));
  count++;
}

// Inject SEO tags into the root index.html itself
writeFileSync(INDEX_FILE, injectSeoTags(baseHtml, '/'));
count++;

console.log(`[seo] injected SEO tags into ${count} route index.html files.`);
