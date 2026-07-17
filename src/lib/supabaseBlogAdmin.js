export const SUPABASE_URL = import.meta.env.VITE_SUPABASE_URL;
export const SUPABASE_ANON_KEY = import.meta.env.VITE_SUPABASE_ANON_KEY;
export const BLOG_IMAGE_BUCKET = 'blog-images';
export const BLOG_IMAGE_MAX_BYTES = 200 * 1024;
export const ANNOUNCEMENT_ID = 'global';

const SESSION_KEY = 'drrajeev_admin_session';
const LEAD_WEBHOOK_ENDPOINT = '/api/lead-webhook';
const WORKSHOP_WEBHOOK_ENDPOINT = '/api/workshop-webhook';
const LEAD_SUBMIT_RPC_ENDPOINTS = [
  '/rest/v1/rpc/submit_main_website_lead',
  '/rest/v1/rpc/submit_mian_website_lead',
];

function assertSupabaseConfig() {
  if (!SUPABASE_URL || !SUPABASE_ANON_KEY) {
    throw new Error('Missing Supabase env config. Set VITE_SUPABASE_URL and VITE_SUPABASE_ANON_KEY in .env.');
  }
}

function authHeaders(token) {
  assertSupabaseConfig();

  return {
    apikey: SUPABASE_ANON_KEY,
    Authorization: `Bearer ${token || SUPABASE_ANON_KEY}`,
  };
}

async function readResponse(response) {
  const text = await response.text();
  let payload = null;

  if (text) {
    try {
      payload = JSON.parse(text);
    } catch {
      payload = { message: text };
    }
  }

  if (!response.ok) {
    const message = payload?.msg || payload?.message || payload?.error_description || payload?.hint || 'Supabase request failed.';
    const error = new Error(message);
    error.status = response.status;
    error.code = payload?.code;
    error.details = payload?.details;
    error.hint = payload?.hint;
    error.payload = payload;
    throw error;
  }

  return payload;
}

async function supabaseFetch(path, options = {}) {
  const { token, headers = {}, body, ...rest } = options;
  const response = await fetch(`${SUPABASE_URL}${path}`, {
    ...rest,
    headers: {
      ...authHeaders(token),
      ...(body && !(body instanceof Blob) ? { 'Content-Type': 'application/json' } : {}),
      ...headers,
    },
    body: body && !(body instanceof Blob) ? JSON.stringify(body) : body,
  });

  return readResponse(response);
}

function isMissingRpcError(error) {
  const text = [
    error?.code,
    error?.message,
    error?.details,
    error?.hint,
  ]
    .filter(Boolean)
    .join(' ')
    .toLowerCase();

  return error?.code === 'PGRST202' || (text.includes('schema cache') && text.includes('function'));
}

async function submitLeadRpc(row) {
  let lastMissingRpcError = null;

  for (const endpoint of LEAD_SUBMIT_RPC_ENDPOINTS) {
    try {
      return await supabaseFetch(endpoint, {
        method: 'POST',
        body: { payload: row },
      });
    } catch (error) {
      if (!isMissingRpcError(error)) {
        throw error;
      }

      lastMissingRpcError = error;
    }
  }

  throw lastMissingRpcError || new Error('Supabase lead submit function is not available.');
}

function currentPageContext() {
  if (typeof window === 'undefined') {
    return {
      page_path: null,
      page_url: null,
      page_title: null,
      referrer: null,
    };
  }

  return {
    page_path: window.location.pathname,
    page_url: window.location.href,
    page_title: typeof document !== 'undefined' ? document.title : null,
    referrer: typeof document !== 'undefined' ? document.referrer || null : null,
  };
}

async function readWebhookResponse(response) {
  const text = await response.text();
  if (!text) return null;

  try {
    return JSON.parse(text);
  } catch {
    return { message: text };
  }
}

function formatLeadDateDDMMYYYY(value = new Date()) {
  const parts = new Intl.DateTimeFormat('en-GB', {
    timeZone: 'Asia/Kolkata',
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
  }).formatToParts(value);
  const part = (type) => parts.find((item) => item.type === type)?.value || '';

  return `${part('day')}-${part('month')}-${part('year')}`;
}

async function notifyLeadWebhook(row, options = {}) {
  if (typeof window === 'undefined') return;

  const {
    directWebhookUrl = '',
    endpoint = LEAD_WEBHOOK_ENDPOINT,
    event = 'website_lead_submitted',
  } = options;
  const lead = row.payload || row;
  const submitEndpoint = directWebhookUrl || endpoint;

  const response = await fetch(submitEndpoint, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      event,
      submitted_at: new Date().toISOString(),
      lead_date: row.lead_date || formatLeadDateDDMMYYYY(),
      lead,
    }),
  });

  if (!response.ok) {
    const payload = await readWebhookResponse(response);
    throw new Error(payload?.error || payload?.message || 'Lead webhook delivery failed.');
  }
}

function buildLeadRow(formName, data = {}) {
  const pageContext = currentPageContext();
  const leadDate = formatLeadDateDDMMYYYY();
  const name = data.name?.trim() || null;
  const contactNumber = data.contact_number?.trim() || data.phone?.trim() || null;
  const whatsappNumber = data.whatsapp_number?.trim() || data.phone?.trim() || null;
  const purposeOfVisit = data.purpose_of_visit?.trim() || data.service?.trim() || data.course?.trim() || data.concern?.trim() || null;
  const payload = {
    ...data,
    ...pageContext,
    form_name: formName || 'Website Form',
    lead_date: leadDate,
    name,
    contact_number: contactNumber,
    whatsapp_number: whatsappNumber,
    purpose_of_visit: purposeOfVisit,
  };

  return {
    ...payload,
    name,
    phone: contactNumber,
    service: purposeOfVisit,
    payload,
  };
}

function normalizeSession(payload) {
  return {
    access_token: payload.access_token,
    refresh_token: payload.refresh_token,
    expires_at: payload.expires_at || Math.floor(Date.now() / 1000) + Number(payload.expires_in || 3600),
    user: {
      id: payload.user?.id,
      email: payload.user?.email,
    },
  };
}

export function getStoredAdminSession() {
  try {
    return JSON.parse(localStorage.getItem(SESSION_KEY) || 'null');
  } catch {
    return null;
  }
}

function storeAdminSession(session) {
  localStorage.setItem(SESSION_KEY, JSON.stringify(session));
  return session;
}

export function clearAdminSession() {
  localStorage.removeItem(SESSION_KEY);
}

export async function signInAdmin(email, password) {
  const payload = await supabaseFetch('/auth/v1/token?grant_type=password', {
    method: 'POST',
    body: { email, password },
  });
  return storeAdminSession(normalizeSession(payload));
}

export async function refreshAdminSession(session = getStoredAdminSession()) {
  if (!session?.refresh_token) return null;

  const payload = await supabaseFetch('/auth/v1/token?grant_type=refresh_token', {
    method: 'POST',
    body: { refresh_token: session.refresh_token },
  });

  return storeAdminSession(normalizeSession(payload));
}

export async function getValidAdminSession() {
  const session = getStoredAdminSession();
  if (!session) return null;

  const expiresSoon = Number(session.expires_at || 0) * 1000 - Date.now() < 60 * 1000;
  try {
    if (expiresSoon) {
      return await refreshAdminSession(session);
    }

    return session;
  } catch {
    clearAdminSession();
    return null;
  }
}

export function slugify(text) {
  return String(text || '')
    .toLowerCase()
    .trim()
    .replace(/[^a-z0-9\s-]/g, '')
    .replace(/\s+/g, '-')
    .replace(/-+/g, '-')
    .replace(/^-|-$/g, '');
}

export function estimateReadMins(html) {
  const words = String(html || '')
    .replace(/<[^>]+>/g, ' ')
    .trim()
    .split(/\s+/)
    .filter(Boolean).length;

  return Math.max(2, Math.ceil(words / 220));
}

function dateOnly(value) {
  if (!value) return new Date().toISOString().slice(0, 10);
  return String(value).slice(0, 10);
}

function requireReturnedRow(rows, action) {
  if (!Array.isArray(rows) || !rows[0]) {
    throw new Error(`Supabase did not return a ${action} row. Please refresh and try again.`);
  }

  return rows[0];
}

export function supabaseBlogToLocal(row) {
  return {
    id: row.id,
    slug: row.slug,
    title: row.title,
    date: dateOnly(row.published_at || row.created_at),
    content: row.content || '',
    excerpt: row.excerpt || '',
    category: row.category || 'Fertility Care',
    image: row.cover_image || '',
    readMins: row.read_mins || 2,
    tags: row.tags || [],
    published: row.published,
    isFeatured: Boolean(row.is_featured),
    _remote: true,
  };
}

export async function listPublishedBlogs() {
  try {
    const rows = await supabaseFetch(
      '/rest/v1/blogs?select=*&published=eq.true&order=published_at.desc.nullslast,created_at.desc'
    );
    return (rows || []).map(supabaseBlogToLocal);
  } catch (error) {
    console.warn('[supabase blogs] public fetch failed:', error.message);
    return [];
  }
}

export async function listAdminBlogs(token) {
  const rows = await supabaseFetch('/rest/v1/blogs?select=*&order=published_at.desc.nullslast,created_at.desc', { token });
  return (rows || []).map(supabaseBlogToLocal);
}

export async function createBlogPost(input, token) {
  const rows = await supabaseFetch('/rest/v1/blogs', {
    method: 'POST',
    token,
    headers: { Prefer: 'return=representation' },
    body: {
      slug: input.slug,
      title: input.title,
      category: input.category,
      excerpt: input.excerpt,
      content: input.content,
      cover_image: input.cover_image,
      read_mins: input.read_mins,
      tags: input.tags,
      published: input.published,
      is_featured: input.is_featured,
      published_at: input.published_at,
    },
  });

  return supabaseBlogToLocal(requireReturnedRow(rows, 'created blog'));
}

export async function updateBlogPost(id, input, token) {
  if (!id) throw new Error('Missing blog id. Refresh the admin blog list and try again.');

  const rows = await supabaseFetch(`/rest/v1/blogs?id=eq.${encodeURIComponent(id)}`, {
    method: 'PATCH',
    token,
    headers: { Prefer: 'return=representation' },
    body: {
      slug: input.slug,
      title: input.title,
      category: input.category,
      excerpt: input.excerpt,
      content: input.content,
      cover_image: input.cover_image,
      read_mins: input.read_mins,
      tags: input.tags,
      published: input.published,
      is_featured: input.is_featured,
      published_at: input.published_at,
    },
  });

  return supabaseBlogToLocal(requireReturnedRow(rows, 'updated blog'));
}

export async function deleteBlogPost(id, token) {
  if (!id) throw new Error('Missing blog id. Refresh the admin blog list and try again.');

  const rows = await supabaseFetch(`/rest/v1/blogs?id=eq.${encodeURIComponent(id)}`, {
    method: 'DELETE',
    token,
    headers: { Prefer: 'return=representation' },
  });

  requireReturnedRow(rows, 'deleted blog');
}

export async function submitLead(formName, data = {}) {
  const row = buildLeadRow(formName, data);
  const leadId = await submitLeadRpc(row);

  try {
    const isPreconceptionWorkshop =
      formName === 'Preconception Workshop Registration' ||
      (row.page_path && row.page_path.includes('preconception-workshop'));

    if (isPreconceptionWorkshop) {
      await notifyLeadWebhook(
        { ...row, id: leadId || null },
        {
          directWebhookUrl: '',
          endpoint: WORKSHOP_WEBHOOK_ENDPOINT,
          event: 'workshop_registration_submitted',
        }
      );
    } else {
      await notifyLeadWebhook({ ...row, id: leadId || null });
    }
  } catch (error) {
    console.warn('[lead webhook] delivery failed:', error.message);
  }

  return true;
}

export async function submitWorkshopRegistration(data = {}) {
  const row = buildLeadRow('Preconception Workshop Registration', data);
  let leadId = null;

  try {
    leadId = await submitLeadRpc(row);
  } catch (error) {
    console.warn('[supabase leads] workshop registration save failed:', error.message);
  }

  await notifyLeadWebhook(
    { ...row, id: leadId || null },
    {
      directWebhookUrl: '',
      endpoint: WORKSHOP_WEBHOOK_ENDPOINT,
      event: 'workshop_registration_submitted',
    }
  );

  return true;
}

function formatLeadDate(value) {
  if (!value) return '';
  const parsed = new Date(value);
  return Number.isNaN(parsed.getTime()) ? value : parsed.toLocaleString();
}

export function supabaseLeadToLocal(row) {
  const payload = row.payload || {};

  return {
    id: row.id,
    formName: row.form_name || 'Website Form',
    submittedAt: formatLeadDate(row.created_at),
    status: row.status || 'new',
    data: {
      ...payload,
      name: row.name || payload.name || '',
      contact_number: row.contact_number || payload.contact_number || row.phone || payload.phone || '',
      whatsapp_number: row.whatsapp_number || payload.whatsapp_number || row.phone || payload.phone || '',
      purpose_of_visit: row.purpose_of_visit || payload.purpose_of_visit || row.service || payload.service || row.concern || payload.concern || '',
      lead_date: row.lead_date || payload.lead_date || row.preferred_date || payload.date || '',
      phone: row.phone || payload.phone || '',
      service: row.service || payload.service || '',
      concern: row.concern || payload.concern || '',
      message: row.message || payload.message || row.concern || '',
      email: row.email || payload.email || '',
      date: row.preferred_date || payload.date || '',
      timeSlot: row.time_slot || payload.timeSlot || '',
      profile: row.profile || payload.profile || '',
      course: row.course || payload.course || '',
    },
  };
}

export async function listLeads(token) {
  const rows = await supabaseFetch('/rest/v1/mian_website_leads?select=*&order=created_at.desc', { token });
  return (rows || []).map(supabaseLeadToLocal);
}

export async function deleteLead(id, token) {
  if (!id) throw new Error('Missing lead id. Refresh the admin lead list and try again.');

  const rows = await supabaseFetch(`/rest/v1/mian_website_leads?id=eq.${encodeURIComponent(id)}`, {
    method: 'DELETE',
    token,
    headers: { Prefer: 'return=representation' },
  });

  requireReturnedRow(rows, 'deleted lead');
}

function normalizeAnnouncement(row = {}) {
  return {
    id: row.id || ANNOUNCEMENT_ID,
    message: row.message || '',
    linkUrl: row.link_url || '',
    enabled: Boolean(row.enabled),
    updatedAt: row.updated_at || null,
  };
}

function normalizeAnnouncementLink(value) {
  const link = String(value || '').trim();
  if (!link) return '';
  if (link.startsWith('/') || link.startsWith('#')) return link;
  if (/^https?:\/\//i.test(link)) return link;
  throw new Error('Announcement link must start with /, #, http://, or https://.');
}

export async function getActiveAnnouncement() {
  try {
    const rows = await supabaseFetch(
      `/rest/v1/site_announcements?select=*&id=eq.${encodeURIComponent(ANNOUNCEMENT_ID)}&enabled=eq.true&limit=1`
    );
    const announcement = rows?.[0] ? normalizeAnnouncement(rows[0]) : null;
    return announcement?.message?.trim() ? announcement : null;
  } catch (error) {
    console.warn('[site announcement] public fetch failed:', error.message);
    return null;
  }
}

export async function getAdminAnnouncement(token) {
  const rows = await supabaseFetch(
    `/rest/v1/site_announcements?select=*&id=eq.${encodeURIComponent(ANNOUNCEMENT_ID)}&limit=1`,
    { token }
  );

  return normalizeAnnouncement(rows?.[0]);
}

export async function saveAdminAnnouncement(input, token) {
  const message = String(input.message || '').trim();
  const linkUrl = normalizeAnnouncementLink(input.linkUrl);

  const rows = await supabaseFetch('/rest/v1/site_announcements?on_conflict=id', {
    method: 'POST',
    token,
    headers: { Prefer: 'resolution=merge-duplicates,return=representation' },
    body: {
      id: ANNOUNCEMENT_ID,
      message,
      link_url: linkUrl || null,
      enabled: Boolean(input.enabled && message),
    },
  });

  return normalizeAnnouncement(requireReturnedRow(rows, 'saved announcement'));
}

export async function uploadBlogImage(blob, slug, token) {
  if (!blob || blob.type !== 'image/webp') {
    throw new Error('Blog image must be a WebP file.');
  }

  if (blob.size > BLOG_IMAGE_MAX_BYTES) {
    throw new Error('Blog image must be under 200 KB.');
  }

  const safeSlug = slugify(slug) || `blog-${Date.now()}`;
  const objectPath = `${safeSlug}-${Date.now()}.webp`;
  const response = await fetch(`${SUPABASE_URL}/storage/v1/object/${BLOG_IMAGE_BUCKET}/${objectPath}`, {
    method: 'POST',
    headers: {
      ...authHeaders(token),
      'Content-Type': 'image/webp',
      'x-upsert': 'false',
    },
    body: blob,
  });

  await readResponse(response);

  return {
    path: objectPath,
    url: `${SUPABASE_URL}/storage/v1/object/public/${BLOG_IMAGE_BUCKET}/${objectPath}`,
    size: blob.size,
  };
}

function loadImage(file) {
  return new Promise((resolve, reject) => {
    const url = URL.createObjectURL(file);
    const image = new Image();
    image.onload = () => {
      URL.revokeObjectURL(url);
      resolve(image);
    };
    image.onerror = () => {
      URL.revokeObjectURL(url);
      reject(new Error('Could not read this image file.'));
    };
    image.src = url;
  });
}

function canvasToWebp(canvas, quality) {
  return new Promise((resolve) => {
    canvas.toBlob((blob) => resolve(blob), 'image/webp', quality);
  });
}

export async function compressImageToWebp(file, maxBytes = BLOG_IMAGE_MAX_BYTES) {
  const image = await loadImage(file);
  let maxWidth = Math.min(1400, image.naturalWidth || image.width);
  let bestBlob = null;

  for (let sizeRound = 0; sizeRound < 7; sizeRound += 1) {
    const scale = Math.min(1, maxWidth / (image.naturalWidth || image.width));
    const width = Math.max(320, Math.round((image.naturalWidth || image.width) * scale));
    const height = Math.max(220, Math.round((image.naturalHeight || image.height) * scale));
    const canvas = document.createElement('canvas');
    canvas.width = width;
    canvas.height = height;
    canvas.getContext('2d').drawImage(image, 0, 0, width, height);

    for (const quality of [0.86, 0.78, 0.7, 0.62, 0.54, 0.46, 0.38]) {
      const blob = await canvasToWebp(canvas, quality);
      if (!blob) continue;
      bestBlob = blob;
      if (blob.size <= maxBytes) {
        return {
          blob,
          size: blob.size,
          previewUrl: URL.createObjectURL(blob),
        };
      }
    }

    maxWidth = Math.round(maxWidth * 0.78);
  }

  throw new Error(
    `Could not compress this image below 200 KB. Last attempt was ${Math.round((bestBlob?.size || 0) / 1024)} KB. Try a smaller image.`
  );
}
