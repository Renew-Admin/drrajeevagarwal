import { pagesData } from '../src/data/pages_data.js';
import fs from 'fs';

const pagesToExtract = ['about-me', 'preconception', 'terms-conditions', 'privacy-policy', 'disclaimer-policy', 'cancellation-refund-policy'];

let output = '';

pagesToExtract.forEach(slug => {
  const page = pagesData[slug];
  if (page) {
    output += `=========================================\n`;
    output += `SLUG: ${slug}\n`;
    output += `TITLE: ${page.title}\n`;
    output += `ID: ${page.id}\n`;
    output += `CONTENT PREVIEW:\n`;
    
    // Strip HTML tags to see the text content easily
    const text = page.content ? page.content.replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').substring(0, 3000) : 'No content';
    output += `${text}...\n\n`;
  } else {
    output += `SLUG: ${slug} NOT FOUND\n\n`;
  }
});

fs.writeFileSync('scratch/page_summaries.txt', output);
console.log('Done!');
