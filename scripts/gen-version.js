import fs from 'node:fs';

const version = Date.now().toString();

fs.mkdirSync('public', { recursive: true });
fs.writeFileSync(
  'public/version.json',
  `${JSON.stringify({ version })}\n`
);

console.log('Generated version.json:', version);
