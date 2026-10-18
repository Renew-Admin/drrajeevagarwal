import { StrictMode } from 'react'
import { createRoot, hydrateRoot } from 'react-dom/client'
import './index.css'
import App from './App.jsx'
import { preloadOnLinkIntent, preloadRoute } from './lazyRoutes'

window.addEventListener('pageshow', (event) => {
  if (event.persisted) {
    window.location.reload()
  }
})

const container = document.getElementById('root')

const app = (
  <StrictMode>
    <App />
  </StrictMode>
)

const normalizePath = (path) => (path || '/').replace(/\/+$/, '') || '/'

// scripts/prerender.mjs stamps the route it rendered onto #root. Hydrate only
// when that markup belongs to the URL we are actually on — Cloudflare serves
// the prerendered homepage as the SPA fallback for routes that were not
// prerendered (/admin, 404s), and hydrating that would flash
// the wrong page. In dev there is no stamp at all, so we client-render.
const prerenderedPath = container.dataset.prerenderedPath

// Lazy page chunks (src/lib/lazyPage.jsx): load the one this URL renders
// before hydrating, so hydration matches the prerendered HTML instead of
// suspending; other pages load when the visitor points at or taps a link to them. A failed
// chunk load falls back to a client render rather than leaving the page inert.
preloadRoute(window.location.pathname)
  .catch(() => {})
  .then(() => {
    if (prerenderedPath && normalizePath(prerenderedPath) === normalizePath(window.location.pathname)) {
      hydrateRoot(container, app)
    } else {
      container.innerHTML = ''
      createRoot(container).render(app)
    }
    preloadOnLinkIntent()
  })
