import { test } from 'node:test';
import assert from 'node:assert/strict';

import blogSlugs from '../src/data/blogSlugs.cjs';
import { legacyWordPressResponse, trailingSlashRedirect, wwwRedirect } from '../src/worker.js';

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
