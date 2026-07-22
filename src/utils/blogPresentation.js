const imageOverrides = {
  'expanded-carrier-screening-whole-exome-sequencing-before-pregnancy-india': '/assets/blog-live/expanded-carrier-screening-before-pregnancy.webp',
  'what-is-testosterone': '/assets/blog-live/what-is-testosterone.webp',
  'thalassaemia-sma-carrier-screening-before-pregnancy-india': '/assets/blog-live/thalassaemia-sma-carrier-screening-before-pregnancy.webp',
  'thyroid-tsh-before-pregnancy-preconception-india': '/assets/blog-live/thyroid-tsh-before-pregnancy-preconception-india.webp',
  'tests-before-pregnancy-preconception-investigations-india': '/assets/2026/06/Dr-Rajeev-Agarwal-blog-images-1-1.webp',
  'no-fetal-pole-5-6-7-weeks-meaning-causes': '/assets/2026/05/Fetal-Pole-in-Pregnancy-1.webp',
  'husband-preconception-health-male-fertility-india': '/assets/2026/05/Husband-and-wife-at-preconception-consultation-with-fertility-specialist-in-Kolkata.webp',
  'hemorrhagic-ovarian-cyst-effects-reproductive-health': '/assets/2026/05/Hemorrhagic-Ovarian.webp',
  'when-to-see-fertility-specialist-trying-to-conceive': '/assets/2026/04/when-to-see-fertility-specialist-trying-to-conceive.webp',
  'pcos-diet-foods-to-eat-and-avoid': '/assets/2026/04/pcos-diet-foods-to-eat-and-avoid.webp',
  'white-discharge-before-period-pregnancy-sign': '/assets/2026/03/white-discharge-before-period-pregnancy-sign.webp',
  'how-age-impacts-fertility': '/assets/2026/03/how-age-impacts-firtility.jpg',
  'ivf-success-factors': '/assets/2026/02/Starting-Your-IVF-Journey-1.jpg',
  'ivf-journey-guide': '/assets/2026/02/Starting-Your-IVF-Journey.jpg',
  'infertility-diagnosis-for-couples': '/assets/2026/02/infertility-diagnosis-for-couples.jpg',
  'understanding-the-role-of-genetics-in-ivf-success': '/assets/2025/12/Genetics-IVF-Success-1.jpg',
  'how-egg-freezing-empowers-women-planning-for-future-motherhood': '/assets/2025/12/Egg-Frizzing.jpg',
  'sperm-donation-when-its-the-right-choice-and-what-to-expect': '/assets/2025/12/Sperm-Donation.jpg',
  'top-signs-you-should-consult-a-fertility-doctor-in-kolkata': '/assets/2025/12/Consult-Fertility-Doctor.jpg',
  'what-is-a-laparoscopy-a-simple-explanation-for-fertility-issues': '/assets/2025/12/Laproscopy.jpg',
  'male-infertility-treatment-in-kolkata-causes-tests-solutions': '/assets/2025/12/Male-infertility1.jpg',
  'tracking-your-cycle-fertile-days': '/assets/2025/12/Track-your-cycle.jpg',
  'hormone-shots-for-iui-ivf-guide': '/assets/2025/12/Hormone-Shots.jpg',
  'ivf-treatment-cost-in-kolkata-what-you-should-know': '/assets/2025/12/IVF-cost.jpg',
  'ovulation-pain-normal-or-problem': '/assets/2025/12/Ovulation-Pain-Normal.jpg',
  'vaginal-discharge-when-is-it-normal-and-when-should-you-see-a-doctor': '/assets/2025/12/Vaginal-Discharge.jpg',
  'understanding-your-amh-level-what-does-egg-count-test-really-means': '/assets/2025/12/AMH-Level.jpg',
  'low-sperm-count-simple-diet-lifestyle-changes': '/assets/2025/12/low-sperm-count.jpg',
  'fertility-diet-for-conception': '/assets/2026/01/Fertility-Boosting.avif',
  'blocked-fallopian-tubes-causes-treatment-options': '/assets/2025/03/Blocked-fallopian-tube-treatment-in-Kolkata.webp'
};

const fallbackImages = [
  '/assets/2026/06/thyroid-tsh-before-pregnancy-preconception-india-1.webp',
  '/assets/2026/05/Husband-and-wife-at-preconception-consultation-with-fertility-specialist-in-Kolkata.webp',
  '/assets/2026/04/when-to-see-fertility-specialist-trying-to-conceive.webp',
  '/assets/2025/12/Consult-Fertility-Doctor.jpg',
  '/assets/2025/03/Fertility-Support-1-515x400.webp'
];

const coverImageSlugs = new Set([
  'husband-preconception-health-male-fertility-india',
  'hemorrhagic-ovarian-cyst-effects-reproductive-health',
  'unveiling-endometriosis-understanding-symptoms-diagnosis-and-treatment',
  'adenomyosis-what-is-it-all-about',
  'everything-you-need-to-know-about-endometriosis-and-fertility'
]);

const tagRules = [
  ['Preconception', /preconception|zero trimester|before pregnancy|trying|conceive|fertility readiness|thyroid/],
  ['IVF', /ivf|embryo|implantation/],
  ['IUI', /\biui\b/],
  ['Male Fertility', /male|sperm|husband/],
  ['PCOS', /pcos|polycystic/],
  ['Pregnancy', /pregnancy|pregnant|trimester|fetal|gestational|ectopic/],
  ['Endometriosis', /endometriosis|adenomyosis/],
  ['AMH Test', /\bamh\b|egg count|ovarian reserve/],
  ['Laparoscopy', /laparoscopy|hysteroscopy|fallopian/],
  ['Hormones', /hormone|thyroid|menopause|menstrual|period/],
  ['Women\'s Health', /vaginal|urinary|incontinence|vaginismus|discharge|menopause/],
  ['Fertility Care', /fertility|infertility|ovulation|egg|prp/]
];

export function decodeHtml(value = '') {
  return String(value)
    .replace(/&nbsp;/g, ' ')
    .replace(/&amp;/g, '&')
    .replace(/&quot;/g, '"')
    .replace(/&#039;/g, "'")
    .replace(/&apos;/g, "'")
    .replace(/&rsquo;/g, "'")
    .replace(/&lsquo;/g, "'")
    .replace(/&rdquo;/g, '"')
    .replace(/&ldquo;/g, '"')
    .replace(/&ndash;/g, '-')
    .replace(/&mdash;/g, '-')
    .replace(/&hellip;/g, '...')
    .replace(/&#038;/g, '&')
    .replace(/&#8211;/g, '-')
    .replace(/&#8212;/g, '-')
    .replace(/&#8216;/g, "'")
    .replace(/&#8217;/g, "'")
    .replace(/&#8220;/g, '"')
    .replace(/&#8221;/g, '"')
    .replace(/&#8230;/g, '...');
}

export function stripBlogHtml(html = '') {
  return decodeHtml(html)
    .replace(/<!--[\s\S]*?-->/g, ' ')
    .replace(/<script[\s\S]*?<\/script>/gi, ' ')
    .replace(/<style[\s\S]*?<\/style>/gi, ' ')
    .replace(/<br\s*\/?>/gi, ' ')
    .replace(/<[^>]+>/g, ' ')
    .replace(/\s+/g, ' ')
    .trim();
}

export function cleanAssetPath(src = '') {
  const value = String(src).trim();
  if (!value) return '';
  if (value.startsWith('/assets/')) return value;

  const uploadIndex = value.indexOf('/wp-content/uploads/');
  if (uploadIndex >= 0) {
    return value.slice(uploadIndex).replace('/wp-content/uploads/', '/assets/');
  }

  return value
    .replace('https://drrajeevagarwal.co.in/wp-content/uploads/', '/assets/')
    .replace('http://drrajeevagarwal.co.in/wp-content/uploads/', '/assets/')
    .replace('http://slategray-heron-932325.hostingersite.com/wp-content/uploads/', '/assets/')
    .replace('/wp-content/uploads/', '/assets/');
}

export function cleanBlogHtml(html = '', options = {}) {
  let clean = String(html)
    .replace(/\s(?:data-)?srcset=["'][^"']*["']/gi, '')
    .replace(/\ssizes=["'][^"']*["']/gi, '')
    .replace(/https:\/\/drrajeevagarwal\.co\.in\/wp-content\/uploads\//g, '/assets/')
    .replace(/http:\/\/drrajeevagarwal\.co\.in\/wp-content\/uploads\//g, '/assets/')
    .replace(/http:\/\/slategray-heron-932325\.hostingersite\.com\/wp-content\/uploads\//g, '/assets/')
    .replace(/\/wp-content\/uploads\//g, '/assets/')
    .replace(/<a\s+([^>]*?)href=["']https?:\/\/drrajeevagarwal\.co\.in\/([^"']*)["']/gi, '<a $1href="/$2"');

  if (options.removeFirstImage) {
    clean = clean.replace(/<!--\s*wp:image[\s\S]*?<!--\s*\/wp:image\s*-->/i, '');
    clean = clean.replace(/<figure[^>]*>\s*<img[^>]*>\s*<\/figure>/i, '');
  }

  if (options.removeFirstParagraph) {
    clean = clean.replace(/<p[^>]*>[\s\S]*?<\/p>/i, '');
  }

  clean = clean.replace(/<p[^>]*>\s*(?:&nbsp;|\s)*Popular Services[\s\S]*$/i, '');
  clean = clean.replace(/<h5[^>]*>\s*(?:&nbsp;|\s)*Popular Blogs[\s\S]*$/i, '');

  return clean;
}

export function formatBlogDate(date) {
  if (!date) return '';
  const parsed = new Date(`${date}T00:00:00`);
  if (Number.isNaN(parsed.getTime())) return date;

  return new Intl.DateTimeFormat('en-US', {
    month: 'long',
    day: 'numeric',
    year: 'numeric'
  }).format(parsed);
}

export function getBlogImage(blog, index = 0) {
  if (blog?.image) {
    return cleanAssetPath(blog.image);
  }

  if (blog?.slug && imageOverrides[blog.slug]) {
    return imageOverrides[blog.slug];
  }

  const match = String(blog?.content || '').match(/<img[^>]+src=["']([^"']+)["']/i);
  if (match?.[1]) {
    return cleanAssetPath(match[1]);
  }

  return fallbackImages[index % fallbackImages.length];
}

export function getBlogCategory(blog) {
  if (blog?.category) {
    return blog.category;
  }

  const titleSlug = `${decodeHtml(blog?.title || '')} ${blog?.slug || ''}`.toLowerCase();

  if (/preconception|zero trimester|thyroid|tests-before-pregnancy|fertility-readiness|husband-preconception/.test(titleSlug)) return 'Preconception Care';
  if (/endometriosis|adenomyosis/.test(titleSlug)) return 'Endometriosis';
  if (/pcos|polycystic/.test(titleSlug)) return 'PCOS';
  if (/male|sperm|husband/.test(titleSlug)) return 'Male Fertility';
  if (/pregnancy|pregnant|fetal|trimester|gestational|miscarriage|postpartum|ectopic/.test(titleSlug)) return 'Safe Pregnancy';
  if (/ivf|iui|infertility|fertility|amh|egg|ovulation|ovarian|fallopian|laparoscopy|hysteroscopy|prp|conceive/.test(titleSlug)) return 'Fertility';
  if (/urinary|incontinence|vaginismus|menopause|period|menstrual|vaginal|discharge|hormone/.test(titleSlug)) return 'Women\'s Health';

  return 'Women\'s Wellness';
}

export function getBlogTags(blog) {
  if (Array.isArray(blog?.tags) && blog.tags.length) {
    return blog.tags;
  }

  const text = `${decodeHtml(blog?.title || '')} ${blog?.slug || ''} ${stripBlogHtml(blog?.content || '').slice(0, 600)}`.toLowerCase();
  const matches = tagRules.filter(([, pattern]) => pattern.test(text)).map(([tag]) => tag);
  return matches.length ? matches.slice(0, 4) : [getBlogCategory(blog)];
}

export function getBlogExcerpt(blog, maxLength = 170) {
  if (blog?.excerpt) {
    return decodeHtml(blog.excerpt);
  }

  const plainText = stripBlogHtml(blog?.content || '');
  if (plainText.length <= maxLength) return plainText;

  const trimmed = plainText.slice(0, maxLength);
  return `${trimmed.slice(0, trimmed.lastIndexOf(' ') || maxLength)}...`;
}

export function getReadingTime(blog) {
  const explicitTime = Number(blog?.readMins || blog?.read_mins || blog?.readingTime);
  if (explicitTime > 0) {
    return explicitTime;
  }

  const words = stripBlogHtml(blog?.content || '').split(/\s+/).filter(Boolean).length;
  return Math.max(2, Math.ceil(words / 220));
}

export function buildBlogPresentation(blog, index = 0) {
  const cleanTitle = decodeHtml(blog?.title || '');
  const plainText = stripBlogHtml(blog?.content || '');
  const slug = blog?.slug || '';

  return {
    ...blog,
    title: cleanTitle,
    displayDate: formatBlogDate(blog?.date || blog?.iso || blog?.published_at),
    image: getBlogImage(blog, index),
    imageFit: coverImageSlugs.has(slug) ? 'cover' : undefined,
    excerpt: getBlogExcerpt(blog),
    category: getBlogCategory(blog),
    tags: getBlogTags(blog),
    readingTime: getReadingTime(blog),
    searchText: `${cleanTitle} ${plainText}`.toLowerCase()
  };
}
