import { rmSync } from 'node:fs';
import { join } from 'node:path';

const buildDir = join(process.cwd(), 'build');

const stalePaths = [
  '_redirects',
  'assets/al_opt_content',
  'assets/backup',
];

for (const relativePath of stalePaths) {
  rmSync(join(buildDir, relativePath), {
    force: true,
    recursive: true,
  });
}

console.log('[cloudflare] prepared Worker build output');
