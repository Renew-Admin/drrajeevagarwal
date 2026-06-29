import { pagesData } from '../src/data/pages_data.js';

for (const [key, value] of Object.entries(pagesData)) {
  const text = value.content ? value.content.replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').substring(0, 100) : 'None';
  console.log(`Slug: ${key} -> Title: ${value.title} -> Preview: ${text}`);
}
