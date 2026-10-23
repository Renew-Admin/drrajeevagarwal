// retiredArticles — overlapping articles retired by the SEO brief of
// 18 Oct 2026 (Part 2, task 9). Each one repeats a stronger article on the
// same question, so its URL 301s to that article (src/worker.js) and the
// article itself is unpublished: it is filtered out of blogsData, the Supabase
// listing, the sitemap, the prerender and every blog list.
//
// Keys are the retired slugs; values are the absolute destination path (or a
// full URL for a page on another site). Add the week-of-26-October redirect
// (task 10) only on the day its target article goes live.
//
// 23 Oct 2026: on Dr. Rajeev's instruction, four articles were restored as live
// pages (trying-to-conceive-check-your-fallopian-tubes-for-blockages and three
// endometriosis articles); their /blog/ addresses 301 to them.
export const RETIRED_ARTICLE_REDIRECTS = {
  'tests-before-pregnancy-preconception-checkup-india': '/tests-before-pregnancy-preconception-investigations-india/',
  'is-preconception-counseling-necessary-if-im-not-ready-for-a-baby-heres-why-it-still-matters': '/preconception-counselling-preparing-for-a-healthy-pregnancy-from-the-start/',
  'the-zero-trimester-preparing-for-a-healthy-pregnancy-before-conception': '/preconception-counselling-preparing-for-a-healthy-pregnancy-from-the-start/',
  'dont-just-conceive-prepare-a-7-step-guide-to-fertility-readiness': '/preconception-counselling-preparing-for-a-healthy-pregnancy-from-the-start/',
  'when-to-seek-medical-advice-for-fertility-a-guide-for-couples-trying-to-conceive': '/when-to-see-fertility-specialist-trying-to-conceive/',
  'top-signs-you-should-consult-a-fertility-doctor-in-kolkata': '/when-to-see-fertility-specialist-trying-to-conceive/',
  'first-fertility-consultation-tips-for-best-consult': '/when-to-see-fertility-specialist-trying-to-conceive/',
  'what-is-a-laparoscopy-a-simple-explanation-for-fertility-issues': '/blocked-fallopian-tubes-causes-treatment-options/',
  'early-menopause-why-it-happens-and-when-to-seek-help': '/understanding-early-menopause-causes-symptoms-and-what-to-expect/',
  'menopause-symptoms-side-effects-and-solutions': '/menopause-care',
  'menopause-more-than-just-the-end-of-periods': '/menopause-care',
  'age-and-fertility-myths-and-facts': '/how-age-impacts-fertility/',
  'polycystic-ovarian-syndrome': '/can-pcos-affect-my-ability-to-have-children/',
  'understanding-iui-a-step-toward-parenthood': '/how-many-cycles-of-iui-should-you-try/',
  'ivf-treatment-cost-in-kolkata-what-you-should-know': 'https://renewhealthcare.in/blogs/ivf-cost-in-kolkata',
};

export const RETIRED_ARTICLE_SLUGS = new Set(Object.keys(RETIRED_ARTICLE_REDIRECTS));

export function isRetiredArticle(slug) {
  return RETIRED_ARTICLE_SLUGS.has(String(slug || '').trim().replace(/^\/+|\/+$/g, ''));
}
