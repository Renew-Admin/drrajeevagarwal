import { SUPABASE_ANON_KEY, SUPABASE_URL, authHeaders, listAdminBlogs, readResponse, supabaseFetch } from './supabaseBlogAdmin';
import { decodeHtml, getBlogExcerpt, getBlogImage } from '../utils/blogPresentation';
import { articlePath } from '../utils/blogRoutes';

export const GMB_BUCKET = 'gmb-posts';
export const GMB_IMAGE_MAX_BYTES = 5 * 1024 * 1024;
export const GMB_IMAGE_MAX_WIDTH = 1600;
export const GMB_CAPTION_MAX = 250;
export const GMB_LOCATIONS = ['Ballygunge'];
export const GMB_TIME_OPTIONS = [
  { value: '10:00', label: '10:00 AM (Asia/Kolkata)' },
  { value: '18:00', label: '6:00 PM (Asia/Kolkata)' },
];

const GMB_WEBHOOK_ENDPOINT = '/api/gmb-webhook';
const SITE_ORIGIN = 'https://drrajeevagarwal.co.in';
const PUBLIC_PREFIX = `/storage/v1/object/public/${GMB_BUCKET}/`;

export function locationFolder(location) {
  return String(location || 'ballygunge').toLowerCase().replace(/[^a-z0-9]+/g, '-');
}

export async function listGmbPosts(token) {
  const rows = await supabaseFetch('/rest/v1/gmb_posts?select=*&order=PostDate.desc,TimeSchedule.desc', { token });
  return rows || [];
}

function gmbRowBody(input) {
  return {
    PostDate: input.PostDate,
    TimeSchedule: input.TimeSchedule,
    Title: input.Title.trim(),
    Caption: input.Caption.trim(),
    ImageURL: input.ImageURL,
    CTAUrl: input.CTAUrl.trim(),
    Location: input.Location,
  };
}

export function validateGmbPost(input) {
  if (!input.PostDate) return 'Post date is required.';
  if (!GMB_TIME_OPTIONS.some((option) => option.value === input.TimeSchedule)) return 'Pick a time schedule.';
  if (!input.Title?.trim()) return 'Title is required.';
  if (!input.Caption?.trim()) return 'Caption is required.';
  if (input.Caption.trim().length > GMB_CAPTION_MAX) return `Caption must be ${GMB_CAPTION_MAX} characters or fewer.`;
  if (!GMB_LOCATIONS.includes(input.Location)) return 'Pick a clinic location.';
  if (!input.ImageURL) return 'Image is required.';
  const cta = input.CTAUrl?.trim();
  if (!cta) return 'CTA URL is required.';
  if (!/^https:\/\/\S+$/i.test(cta)) return 'CTA URL must start with https://';
  return null;
}

export async function createGmbPost(input, token) {
  const rows = await supabaseFetch('/rest/v1/gmb_posts', {
    method: 'POST',
    token,
    headers: { Prefer: 'return=representation' },
    body: { ...gmbRowBody(input), Status: 'Scheduled' },
  });
  if (!rows?.[0]) throw new Error('Supabase did not return the created GMB post.');
  return rows[0];
}

export async function updateGmbPost(id, input, token) {
  const rows = await supabaseFetch(`/rest/v1/gmb_posts?id=eq.${encodeURIComponent(id)}`, {
    method: 'PATCH',
    token,
    headers: { Prefer: 'return=representation' },
    body: gmbRowBody(input),
  });
  if (!rows?.[0]) throw new Error('Supabase did not return the updated GMB post.');
  return rows[0];
}

export async function deleteGmbPost(post, token) {
  const rows = await supabaseFetch(`/rest/v1/gmb_posts?id=eq.${encodeURIComponent(post.id)}`, {
    method: 'DELETE',
    token,
    headers: { Prefer: 'return=representation' },
  });
  if (!rows?.[0]) throw new Error('Supabase did not delete the GMB post.');
  await deleteGmbImage(post.ImageURL, token).catch((error) => {
    console.warn('[gmb] image delete failed:', error.message);
  });
}

export async function deleteGmbImage(imageUrl, token) {
  const marker = `${SUPABASE_URL}${PUBLIC_PREFIX}`;
  if (!imageUrl || !imageUrl.startsWith(marker)) return;
  const objectPath = imageUrl.slice(marker.length);
  const response = await fetch(`${SUPABASE_URL}/storage/v1/object/${GMB_BUCKET}`, {
    method: 'DELETE',
    headers: { ...authHeaders(token), 'Content-Type': 'application/json' },
    body: JSON.stringify({ prefixes: [objectPath] }),
  });
  await readResponse(response);
}

export async function uploadGmbImage(blob, location, token) {
  if (!blob || blob.type !== 'image/jpeg') throw new Error('GMB image must be converted to JPG before upload.');
  if (blob.size > GMB_IMAGE_MAX_BYTES) throw new Error('GMB image must be under 5 MB.');

  const objectPath = `${locationFolder(location)}/gmb-${Date.now()}.jpg`;
  const response = await fetch(`${SUPABASE_URL}/storage/v1/object/${GMB_BUCKET}/${objectPath}`, {
    method: 'POST',
    headers: { ...authHeaders(token), 'Content-Type': 'image/jpeg', 'x-upsert': 'false' },
    body: blob,
  });
  await readResponse(response);
  return `${SUPABASE_URL}${PUBLIC_PREFIX}${objectPath}`;
}

function loadImageBlob(blob) {
  return new Promise((resolve, reject) => {
    const url = URL.createObjectURL(blob);
    const image = new Image();
    image.onload = () => {
      URL.revokeObjectURL(url);
      resolve(image);
    };
    image.onerror = () => {
      URL.revokeObjectURL(url);
      reject(new Error('Could not read this image.'));
    };
    image.src = url;
  });
}

export async function fetchImageFromUrl(url) {
  let response;
  try {
    response = await fetch(url);
  } catch {
    throw new Error('Could not download that image link (the site may block it). Download it and upload the file instead.');
  }
  if (!response.ok) throw new Error(`Image link returned ${response.status}.`);
  const blob = await response.blob();
  if (!blob.type.startsWith('image/')) throw new Error('That link is not an image.');
  return blob;
}

// Any input (PNG, WebP, AVIF, JPG…) → JPG, max 1600px wide, under 5 MB,
// transparency flattened onto white.
export async function convertImageToJpg(blob) {
  const image = await loadImageBlob(blob);
  const naturalWidth = image.naturalWidth || image.width;
  const naturalHeight = image.naturalHeight || image.height;
  let maxWidth = Math.min(GMB_IMAGE_MAX_WIDTH, naturalWidth);

  for (let round = 0; round < 6; round += 1) {
    const scale = Math.min(1, maxWidth / naturalWidth);
    const width = Math.round(naturalWidth * scale);
    const height = Math.round(naturalHeight * scale);
    const canvas = document.createElement('canvas');
    canvas.width = width;
    canvas.height = height;
    const context = canvas.getContext('2d');
    context.fillStyle = '#ffffff';
    context.fillRect(0, 0, width, height);
    context.drawImage(image, 0, 0, width, height);

    for (const quality of [0.9, 0.82, 0.74, 0.66]) {
      const jpg = await new Promise((resolve) => canvas.toBlob(resolve, 'image/jpeg', quality));
      if (jpg && jpg.size <= GMB_IMAGE_MAX_BYTES) return jpg;
    }
    maxWidth = Math.round(maxWidth * 0.8);
  }

  throw new Error('Could not get this image under 5 MB. Try a smaller image.');
}

// Sends the saved post to Make.com via the server-side proxy (GMB_WEBHOOK_URL).
export async function notifyGmbWebhook(id, token) {
  const response = await fetch(GMB_WEBHOOK_ENDPOINT, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      apikey: SUPABASE_ANON_KEY,
      Authorization: `Bearer ${token}`,
    },
    body: JSON.stringify({ id }),
  });
  if (!response.ok) {
    const payload = await response.json().catch(() => null);
    throw new Error(payload?.error || 'GMB webhook delivery failed.');
  }
}

function fitCaption(text) {
  const clean = String(text || '').replace(/\s+/g, ' ').trim();
  if (clean.length <= GMB_CAPTION_MAX) return clean;
  const cut = clean.slice(0, GMB_CAPTION_MAX - 3);
  return `${cut.slice(0, cut.lastIndexOf(' ') > 0 ? cut.lastIndexOf(' ') : cut.length)}...`;
}

function absoluteImageUrl(src) {
  if (!src) return '';
  if (/^https?:\/\//i.test(src)) return src;
  return new URL(src, typeof window === 'undefined' ? SITE_ORIGIN : window.location.origin).href;
}

// Blogs for the "fill from blog" picker: Supabase posts plus the bundled
// articles (loaded on demand so the admin chunk stays small), newest first.
export async function listGmbBlogOptions(token) {
  const [{ blogsData }, { liveBlogUpdates }, remote] = await Promise.all([
    import('../data/blogs_data'),
    import('../data/live_blog_updates'),
    listAdminBlogs(token).catch(() => []),
  ]);

  const seen = new Set();
  return [...remote.filter((blog) => blog.published), ...liveBlogUpdates, ...blogsData]
    .filter((blog) => blog?.slug && !seen.has(blog.slug) && seen.add(blog.slug))
    .map((blog, index) => ({
      slug: blog.slug,
      date: String(blog.date || blog.published_at || '').slice(0, 10),
      title: decodeHtml(blog.title || blog.slug),
      caption: fitCaption(getBlogExcerpt(blog, GMB_CAPTION_MAX)),
      image: absoluteImageUrl(getBlogImage(blog, index)),
      cta: `${SITE_ORIGIN}${articlePath(blog.slug)}`,
    }))
    .sort((a, b) => b.date.localeCompare(a.date));
}
