import { test } from 'node:test';
import assert from 'node:assert/strict';
import { existsSync, readdirSync, readFileSync, statSync } from 'node:fs';
import { join } from 'node:path';
import { fileURLToPath } from 'node:url';

import { DOCTOR_REGISTRATION_LINE } from '../src/data/doctorRegistration.js';

const REQUIRED_LINE = 'Dr. Rajeev Agarwal, MBBS, MD (Obstetrics & Gynaecology), West Bengal Medical Council Reg. No. WBMC52540';
// How the line appears in HTML (React and the static 404 page both escape "&").
const HTML_LINE = REQUIRED_LINE.replace('&', '&amp;');

const read = (path) => readFileSync(new URL(`../${path}`, import.meta.url), 'utf8');
const count = (haystack, needle) => haystack.split(needle).length - 1;

test('registration: the shared constant is the client checklist wording', () => {
  assert.equal(DOCTOR_REGISTRATION_LINE, REQUIRED_LINE);
});

test('registration: the shared footer renders the line once, through RegistrationLine', () => {
  const footer = read('src/components/Footer.jsx');
  assert.equal(count(footer, '<RegistrationLine'), 1);
  assert.equal(count(footer, 'Reg. No.'), 0, 'Footer.jsx must not hard-code its own copy');
  assert.match(read('src/components/RegistrationLine.jsx'), /\{DOCTOR_REGISTRATION_LINE\}/);
});

test('registration: every page layout that has a footer renders the shared Footer exactly once', () => {
  // SiteChrome (all routes except "/" and /admin) and the homepage, which renders its own.
  assert.equal(count(read('src/App.jsx'), '<Footer />'), 1);
  assert.equal(count(read('src/pages/Home.jsx'), '<Footer />'), 1);
});

test('registration: the standalone 404 page shows the line exactly once', () => {
  assert.equal(count(read('public/404.html'), HTML_LINE), 1);
});

function htmlFiles(dir) {
  return readdirSync(dir).flatMap((name) => {
    const path = join(dir, name);
    if (statSync(path).isDirectory()) return name === 'admin' || name === 'assets' ? [] : htmlFiles(path);
    // spa-shell.html is the empty client shell for routes that are not prerendered.
    return name.endsWith('.html') && name !== 'spa-shell.html' ? [path] : [];
  });
}

const buildDir = fileURLToPath(new URL('../build/', import.meta.url));
test('registration: every prerendered page and build/404.html show the line exactly once', {
  skip: existsSync(join(buildDir, 'index.html')) ? false : 'no build/ output; run npm run build first',
}, () => {
  const files = htmlFiles(buildDir);
  assert.ok(files.includes(join(buildDir, '404.html')), 'build/404.html missing');
  const wrong = files.filter((file) => count(readFileSync(file, 'utf8'), HTML_LINE) !== 1);
  assert.deepEqual(wrong, [], `${wrong.length} of ${files.length} pages do not show the line exactly once`);
});
