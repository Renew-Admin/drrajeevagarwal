import { existsSync, rmSync, statSync } from 'node:fs';
import { spawnSync } from 'node:child_process';
import { join } from 'node:path';

const rootDir = process.cwd();
const buildDir = join(rootDir, 'build');
const zipName = process.env.CPANEL_ZIP_NAME || 'drrajeevagarwal-cpanel-public_html.zip';
const zipPath = join(rootDir, zipName);

function formatBytes(bytes) {
  const units = ['B', 'KB', 'MB', 'GB'];
  let size = bytes;
  let unitIndex = 0;

  while (size >= 1024 && unitIndex < units.length - 1) {
    size /= 1024;
    unitIndex += 1;
  }

  return `${size.toFixed(unitIndex === 0 ? 0 : 1)} ${units[unitIndex]}`;
}

if (!existsSync(join(buildDir, 'index.html'))) {
  throw new Error('Missing build/index.html. Run npm run build:cpanel first.');
}

rmSync(zipPath, { force: true });

const result = spawnSync('zip', ['-r', '-q', zipPath, '.'], {
  cwd: buildDir,
  stdio: 'inherit',
});

if (result.error) {
  throw result.error;
}

if (result.status !== 0) {
  throw new Error(`zip failed with status ${result.status}`);
}

const size = statSync(zipPath).size;
console.log(`[cpanel] wrote ${zipName} (${formatBytes(size)})`);
