/**
 * CommonJS version of seoMeta.js for use in Node.js server.
 */

const SITE_ORIGIN = 'https://drrajeevagarwal.co.in';

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
    title: 'Preconception Counselling | Dr. Rajeev Agarwal',
    description:
      'Preconception counselling with Dr. Rajeev Agarwal helps couples prepare for pregnancy with clear fertility, nutrition, testing, and timing guidance.',
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
};

function getMetaForPath(pathname) {
  const clean = (pathname || '/').replace(/\/+$/, '') || '/';

  if (ROUTE_META[clean]) {
    return Object.assign({}, ROUTE_META[clean], { canonicalUrl: SITE_ORIGIN + clean });
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

  return Object.assign({}, DEFAULT_META, { canonicalUrl: SITE_ORIGIN + clean });
}

module.exports = {
  SITE_ORIGIN,
  DEFAULT_META,
  ROUTE_META,
  getMetaForPath,
};
