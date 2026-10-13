import js from '@eslint/js'
import globals from 'globals'
import reactHooks from 'eslint-plugin-react-hooks'
import reactRefresh from 'eslint-plugin-react-refresh'
import { defineConfig, globalIgnores } from 'eslint/config'

export default defineConfig([
  // Build output and copied WordPress assets (public/assets holds ~18,700
  // third-party optimiser/plugin files) are not our code; linting them took
  // ~4 min and produced ~157,000 irrelevant problems. .prerender is the
  // transient SSR bundle written by scripts/prerender.mjs.
  globalIgnores(['dist', 'build', '.prerender', 'public/assets']),
  {
    files: ['**/*.{js,jsx}'],
    extends: [
      js.configs.recommended,
      reactHooks.configs.flat.recommended,
      reactRefresh.configs.vite,
    ],
    languageOptions: {
      globals: globals.browser,
      parserOptions: { ecmaFeatures: { jsx: true } },
    },
  },
])
