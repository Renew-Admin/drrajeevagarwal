import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import { renameSync, readdirSync, statSync } from 'fs'
import { join, dirname } from 'path'

function cleanAssetFilenames() {
  return {
    name: 'clean-asset-filenames',
    closeBundle() {
      const dir = join(process.cwd(), 'dist/assets')
      const fix = (p) => {
        const files = readdirSync(p)
        for (const f of files) {
          const fp = join(p, f)
          if (statSync(fp).isDirectory()) { fix(fp); continue }
          if (f.includes('#') || f.includes('?')) {
            const clean = f.replace(/[#?].*$/, '')
            renameSync(fp, join(dirname(fp), clean))
          }
        }
      }
      try { fix(dir) } catch {}
    }
  }
}

// https://vite.dev/config/
export default defineConfig({
  plugins: [react(), cleanAssetFilenames()],
})
