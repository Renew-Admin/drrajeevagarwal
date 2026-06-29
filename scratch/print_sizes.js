import { pagesData } from '../src/data/pages_data.js';

for (const [key, value] of Object.entries(pagesData)) {
  console.log(`Key: ${key}, Title: ${value.title}, ID: ${value.id}, Content Length: ${value.content ? value.content.length : 0}`);
}
