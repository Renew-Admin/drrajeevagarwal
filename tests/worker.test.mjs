import { test } from 'node:test';
import assert from 'node:assert/strict';

import blogSlugs from '../src/data/blogSlugs.cjs';
import { SECURITY_HEADERS, httpsRedirect, legacyWordPressResponse, trailingSlashRedirect, withSecurityHeaders, wwwRedirect } from '../src/worker.js';

const url = (href) => new URL(href);

test('wwwRedirect: www host answers 301 to the apex origin, path and query kept', () => {
  const response = wwwRedirect(url('https://www.drrajeevagarwal.co.in/about-me?x=1'));
  assert.ok(response, 'expected a Response');
  assert.equal(response.status, 301);
  assert.equal(response.headers.get('location'), 'https://drrajeevagarwal.co.in/about-me?x=1');
});

test('wwwRedirect: apex host is left alone', () => {
  assert.equal(wwwRedirect(url('https://drrajeevagarwal.co.in/about-me?x=1')), null);
});

test('trailingSlashRedirect: non-article "/x/" answers 301 to "/x"', () => {
  const response = trailingSlashRedirect(url('https://drrajeevagarwal.co.in/all-services/'));
  assert.ok(response, 'expected a Response');
  assert.equal(response.status, 301);
  assert.equal(response.headers.get('location'), 'https://drrajeevagarwal.co.in/all-services');
});

test('trailingSlashRedirect: the homepage is left alone', () => {
  assert.equal(trailingSlashRedirect(url('https://drrajeevagarwal.co.in/')), null);
});

test('trailingSlashRedirect: article URLs keep their trailing slash', () => {
  const slug = blogSlugs[0];
  assert.ok(slug, 'blogSlugs.cjs must list at least one article');
  assert.equal(trailingSlashRedirect(url(`https://drrajeevagarwal.co.in/${slug}/`)), null);
});

test('trailingSlashRedirect: slash-less paths are left alone', () => {
  assert.equal(trailingSlashRedirect(url('https://drrajeevagarwal.co.in/about-me')), null);
});

test('legacyWordPressResponse: the removed /doctors pages answer 410 Gone', () => {
  for (const pathname of ['/doctors', '/doctors/', '/doctors/dr-emily-walker']) {
    const response = legacyWordPressResponse(url(`https://drrajeevagarwal.co.in${pathname}`));
    assert.ok(response, `expected a Response for ${pathname}`);
    assert.equal(response.status, 410, pathname);
  }
});

test('legacyWordPressResponse: a live page is not a legacy path', () => {
  assert.equal(legacyWordPressResponse(url('https://drrajeevagarwal.co.in/about-me')), null);
});

test('httpsRedirect: plain http on the production host answers 301 to https, path and query kept', () => {
  const response = httpsRedirect(url('http://drrajeevagarwal.co.in/about-me?x=1'));
  assert.equal(response.status, 301);
  assert.equal(response.headers.get('location'), 'https://drrajeevagarwal.co.in/about-me?x=1');
});

test('httpsRedirect: https and local hosts are left alone', () => {
  assert.equal(httpsRedirect(url('https://drrajeevagarwal.co.in/about-me')), null);
  assert.equal(httpsRedirect(url('http://localhost:8787/about-me')), null);
});

test('withSecurityHeaders: every header set on https production responses, including redirects', () => {
  const secured = withSecurityHeaders(Response.redirect('https://drrajeevagarwal.co.in/', 301), url('https://drrajeevagarwal.co.in/x'));
  for (const [name, value] of Object.entries(SECURITY_HEADERS)) assert.equal(secured.headers.get(name), value, name);
  assert.equal(secured.status, 301);
});

test('withSecurityHeaders: no HSTS on http or local responses; existing headers are not overwritten', () => {
  const local = withSecurityHeaders(new Response('ok', { headers: { 'X-Frame-Options': 'DENY' } }), url('http://localhost:8787/'));
  assert.equal(local.headers.get('strict-transport-security'), null);
  assert.equal(local.headers.get('x-frame-options'), 'DENY');
  assert.equal(local.headers.get('x-content-type-options'), 'nosniff');
});

test('legacy: /learn-with-dr-rajeev-agarwal (any form) answers 301 to /courses', () => {
  for (const path of ['/learn-with-dr-rajeev-agarwal', '/learn-with-dr-rajeev-agarwal/', '/learn-with-dr-rajeev-agarwal/x']) {
    const response = legacyWordPressResponse(url(`https://drrajeevagarwal.co.in${path}`));
    assert.equal(response.status, 301, path);
    assert.equal(response.headers.get('location'), 'https://drrajeevagarwal.co.in/courses', path);
  }
});

test('SEO brief task 9: retired articles 301 in one hop from every form, including /blog/', async () => {
  const { RETIRED_ARTICLE_REDIRECTS } = await import('../src/data/retiredArticles.js');
  assert.equal(Object.keys(RETIRED_ARTICLE_REDIRECTS).length, 15);
  for (const [slug, to] of Object.entries(RETIRED_ARTICLE_REDIRECTS)) {
    const expected = to.startsWith('http') ? to : `https://drrajeevagarwal.co.in${to}`;
    for (const path of [`/${slug}`, `/${slug}/`, `/blog/${slug}`, `/blog/${slug}/`]) {
      const response = legacyWordPressResponse(url(`https://drrajeevagarwal.co.in${path}`));
      assert.equal(response?.status, 301, path);
      assert.equal(response.headers.get('location'), expected, path);
    }
  }
});

test('SEO brief task 7: deleted pages answer 410 with or without the slash', () => {
  for (const path of ['/elementor-10995', '/elementor-10995/', '/courses-page-copy', '/courses-page-copy/']) {
    assert.equal(legacyWordPressResponse(url(`https://drrajeevagarwal.co.in${path}`))?.status, 410, path);
  }
});

test('SEO brief task 1: /blog/<slug> lands on /<slug>/ and the listing is not redirected', () => {
  const response = legacyWordPressResponse(url('https://drrajeevagarwal.co.in/blog/ovulation-pain-normal-or-problem'));
  assert.equal(response.headers.get('location'), 'https://drrajeevagarwal.co.in/ovulation-pain-normal-or-problem/');
  assert.equal(legacyWordPressResponse(url('https://drrajeevagarwal.co.in/blog')), null);
});

test('SEO brief task 9: retired-article links in post bodies point at their replacement', async () => {
  const { cleanBlogHtml } = await import('../src/utils/blogPresentation.js');
  const html = cleanBlogHtml('<a href="/when-to-seek-medical-advice-for-fertility-a-guide-for-couples-trying-to-conceive/">see</a>');
  assert.equal(html, '<a href="/when-to-see-fertility-specialist-trying-to-conceive/">see</a>');
});

test('23 Oct: four restored articles are live; their /blog/ addresses go to them in one hop', async () => {
  const { isRetiredArticle } = await import('../src/data/retiredArticles.js');
  for (const slug of [
    'trying-to-conceive-check-your-fallopian-tubes-for-blockages',
    'unveiling-endometriosis-understanding-symptoms-diagnosis-and-treatment',
    'treatment-strategies-for-endometriosis',
    'everything-you-need-to-know-about-endometriosis-and-fertility',
  ]) {
    assert.equal(isRetiredArticle(slug), false, slug);
    assert.equal(legacyWordPressResponse(url(`https://drrajeevagarwal.co.in/${slug}/`)), null, slug);
    const response = legacyWordPressResponse(url(`https://drrajeevagarwal.co.in/blog/${slug}`));
    assert.equal(response?.status, 301, slug);
    assert.equal(response.headers.get('location'), `https://drrajeevagarwal.co.in/${slug}/`, slug);
  }
});
