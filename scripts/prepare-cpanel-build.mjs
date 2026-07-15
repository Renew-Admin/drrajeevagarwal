import {
  chmodSync,
  copyFileSync,
  existsSync,
  mkdirSync,
  readdirSync,
  readFileSync,
  rmSync,
  statSync,
  writeFileSync,
} from 'node:fs';
import { join, relative, sep } from 'node:path';

const rootDir = process.cwd();
const buildDir = join(rootDir, 'build');
const envPath = join(rootDir, '.env');
const publicHtaccessPath = join(rootDir, 'public', '.htaccess');
const publicApiHtaccessPath = join(rootDir, 'public', 'api', '.htaccess');
const buildApiDir = join(buildDir, 'api');
const buildEnvPath = join(buildApiDir, '.env.php');

const requiredPublicEnv = ['VITE_SUPABASE_URL', 'VITE_SUPABASE_ANON_KEY'];
const requiredServerEnv = ['WEBHOOK_URL', 'WORKSHOP_WEBHOOK'];
const unsafeBuildPaths = [
  'assets/al_opt_content',
  'assets/backup',
  'assets/bookingpress_export_records',
  'assets/bookingpress_import_records',
  'assets/cfdb7_uploads',
  'assets/crm_perks_uploads',
  'assets/fw-backup',
  'assets/wc-logs',
  'assets/woocommerce_uploads',
  'assets/wpallexport',
  'assets/wpcf7_uploads',
];

function parseEnvValue(value) {
  const trimmed = value.trim();
  const quote = trimmed[0];

  if ((quote === '"' || quote === "'") && trimmed.endsWith(quote)) {
    return trimmed.slice(1, -1);
  }

  return trimmed;
}

function parseEnvFile(filePath) {
  if (!existsSync(filePath)) return {};

  const env = {};
  const content = readFileSync(filePath, 'utf8');

  for (const line of content.split(/\r?\n/)) {
    const trimmed = line.trim();
    if (!trimmed || trimmed.startsWith('#')) continue;

    const match = trimmed.match(/^([A-Za-z_][A-Za-z0-9_]*)=(.*)$/);
    if (!match) continue;

    env[match[1]] = parseEnvValue(match[2]);
  }

  return env;
}

function envValue(env, name) {
  return process.env[name] || env[name] || '';
}

function assertRequiredEnv(env, names) {
  const missing = names.filter((name) => envValue(env, name).trim() === '');

  if (missing.length > 0) {
    throw new Error(`Missing required cPanel build env: ${missing.join(', ')}`);
  }
}

function phpString(value) {
  return `'${String(value).replace(/\\/g, '\\\\').replace(/'/g, "\\'")}'`;
}

function writeServerEnvFile(env) {
  mkdirSync(buildApiDir, { recursive: true });

  const lines = [
    '<?php',
    'return [',
    ...requiredServerEnv.map((name) => `    ${phpString(name)} => ${phpString(envValue(env, name))},`),
    '];',
    '',
  ];

  writeFileSync(buildEnvPath, lines.join('\n'), { mode: 0o600 });
  chmodSync(buildEnvPath, 0o600);
}

function listFiles(dir) {
  const files = [];

  if (!existsSync(dir)) return files;

  for (const entry of readdirSync(dir)) {
    const filePath = join(dir, entry);
    const stat = statSync(filePath);

    if (stat.isDirectory()) {
      files.push(...listFiles(filePath));
    } else if (stat.isFile()) {
      files.push(filePath);
    }
  }

  return files;
}

function removeUnsafeAssetFiles() {
  for (const unsafePath of unsafeBuildPaths) {
    rmSync(join(buildDir, unsafePath), { force: true, recursive: true });
  }

  for (const filePath of listFiles(join(buildDir, 'assets'))) {
    const name = filePath.split(sep).pop() || '';

    if (name === '.htaccess' || name.endsWith('.php')) {
      rmSync(filePath, { force: true });
    }
  }
}

function copyHtaccessFiles() {
  copyFileSync(publicHtaccessPath, join(buildDir, '.htaccess'));
  mkdirSync(buildApiDir, { recursive: true });
  copyFileSync(publicApiHtaccessPath, join(buildApiDir, '.htaccess'));
}

function assertBuildFiles() {
  const expectedFiles = [
    'index.html',
    '.htaccess',
    'api/.htaccess',
    'api/lead-webhook.php',
    'api/workshop-webhook.php',
    'api/webhook-proxy.php',
    'api/.env.php',
  ];

  const missing = expectedFiles.filter((file) => !existsSync(join(buildDir, file)));

  if (missing.length > 0) {
    throw new Error(`Missing cPanel build files: ${missing.join(', ')}`);
  }
}

function assertServerSecretsNotInFrontend(env) {
  const secrets = requiredServerEnv
    .map((name) => [name, envValue(env, name)])
    .filter(([, value]) => value && value.length >= 8);

  const frontendFiles = listFiles(buildDir).filter((filePath) => {
    const buildRelativePath = relative(buildDir, filePath);
    return buildRelativePath !== join('api', '.env.php');
  });

  for (const filePath of frontendFiles) {
    const content = readFileSync(filePath);

    for (const [name, value] of secrets) {
      if (content.includes(Buffer.from(value))) {
        const buildRelativePath = relative(buildDir, filePath);
        throw new Error(`${name} leaked into frontend build file: ${buildRelativePath}`);
      }
    }
  }
}

if (!existsSync(join(buildDir, 'index.html'))) {
  throw new Error('Run vite build before preparing the cPanel build.');
}

const fileEnv = parseEnvFile(envPath);
assertRequiredEnv(fileEnv, [...requiredPublicEnv, ...requiredServerEnv]);
removeUnsafeAssetFiles();
copyHtaccessFiles();
writeServerEnvFile(fileEnv);
assertBuildFiles();
assertServerSecretsNotInFrontend(fileEnv);

console.log('[cpanel] prepared build output');
