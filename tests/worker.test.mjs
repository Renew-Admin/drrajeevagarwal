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
