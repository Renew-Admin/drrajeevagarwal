import { pagesData } from '../src/data/pages_data.js';
const p = pagesData['preconception-care'];
console.log(p.content.substring(0, 1500).replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' '));
