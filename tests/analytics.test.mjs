// GA4 helper and lead-proxy guard tests — `npm test`.
import { test } from 'node:test';
import assert from 'node:assert/strict';

import { cleanPageLocation, sanitizeParams, pageCategory, formTypeFromName, isTrackedPath, GA_MEASUREMENT_ID } from '../src/lib/analytics.js';
import worker, { validateLeadPayload, leadRateAllowed } from '../src/worker.js';

test('new measurement ID is in use', () => {
  assert.equal(GA_MEASUREMENT_ID, 'G-DJR8P0KSK5');
});

test('page_location keeps campaign params only', () => {
  assert.equal(cleanPageLocation('https://drrajeevagarwal.co.in/?mcp_token=eyJ.x.y&utm_source=ig&__site_version=1'), 'https://drrajeevagarwal.co.in/?utm_source=ig');
  assert.equal(cleanPageLocation('https://drrajeevagarwal.co.in/blog?tag=PCOS'), 'https://drrajeevagarwal.co.in/blog');
});

test('params are allow-listed tokens; form names become generic types', () => {
  assert.deepEqual(sanitizeParams('generate_lead', { form_type: 'appointment', name: 'X', contact_number: '9876543210' }), { form_type: 'appointment' });
  assert.equal(formTypeFromName('Course Enrolment - 12 Months Fellowship'), 'course_enrolment');
  assert.equal(formTypeFromName('Global Sticky Header Form'), 'popup_appointment');
  assert.equal(formTypeFromName('Perimenopause Symptoms Quiz'), 'menopause_quiz');
  assert.equal(pageCategory('/pcos-care'), 'content_page');
  assert.equal(pageCategory('/menopause-care/hrt-hormone-therapy'), 'program_page');
  assert.equal(isTrackedPath('/admin/leads'), false);
});

const lead = (over = {}) => ({ event: 'website_lead_submitted', lead: { name: 'Asha Roy', contact_number: '9876543210', form_name: 'Appointment Form', ...over } });

test('lead payload validation', () => {
  assert.equal(validateLeadPayload(lead()), null);
  assert.equal(validateLeadPayload(lead({ contact_number: '12', phone: '' })), 'invalid_phone');
  assert.equal(validateLeadPayload(lead({ name: '' })), 'invalid_name');
  assert.equal(validateLeadPayload(lead({ website: 'spam' })), 'rejected');
  assert.equal(validateLeadPayload({}), 'invalid_body');
  assert.equal(validateLeadPayload(lead({ contact_number: '+91 98765 43210' })), null);
});

test('rate limiter', () => {
  for (let i = 0; i < 20; i += 1) assert.equal(leadRateAllowed('t', 1000), true);
  assert.equal(leadRateAllowed('t', 1000), false);
});

const post = (body, origin = 'https://drrajeevagarwal.co.in') => new Request('https://drrajeevagarwal.co.in/api/lead-webhook', {
  method: 'POST',
  headers: { 'content-type': 'application/json', origin, 'cf-connecting-ip': `ip-${Math.random()}` },
  body: typeof body === 'string' ? body : JSON.stringify(body),
});

test('proxy rejects foreign origins and bad bodies before forwarding', async () => {
  let forwarded = 0;
  const realFetch = globalThis.fetch;
  globalThis.fetch = async () => { forwarded += 1; return new Response('Accepted', { status: 200 }); };
  try {
    const env = { WEBHOOK_URL: 'https://hook.example/test' };
    assert.equal((await worker.fetch(post(lead(), 'https://evil.example'), env)).status, 403);
    assert.equal((await worker.fetch(post('{bad'), env)).status, 400);
    assert.equal((await worker.fetch(post(lead({ contact_number: '1', phone: '' })), env)).status, 422);
    assert.equal((await worker.fetch(post('x'.repeat(20000)), env)).status, 413);
    assert.equal(forwarded, 0);
    assert.equal((await worker.fetch(post(lead()), env)).status, 200);
    assert.equal(forwarded, 1);
    const dup = await worker.fetch(post(lead()), env);
    assert.equal((await dup.json()).duplicate, true);
    assert.equal(forwarded, 1);
  } finally {
    globalThis.fetch = realFetch;
  }
});
