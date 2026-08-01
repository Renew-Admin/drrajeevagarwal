/**
 * Server entry used only at build time by scripts/prerender.mjs.
 *
 * It renders the app to an HTML string for a given route so the markup can be
 * baked into build/<route>/index.html. That is what makes real content — the
 * headings, copy, links and images — visible in "View page source" and to
 * crawlers/AI agents that do not execute JavaScript.
 *
 * Never imported by the browser bundle: the client entry is src/main.jsx.
 */

import { StrictMode } from 'react';
import { renderToString } from 'react-dom/server';
import { StaticRouter } from 'react-router-dom';

import { AppRoutes } from './App.jsx';

/**
 * @param {string} url  Route path to render, e.g. "/" or "/blog/some-slug".
 * @returns {string}    Inner HTML for <div id="root">.
 */
export function render(url) {
  return renderToString(
    <StrictMode>
      <StaticRouter location={url}>
        <AppRoutes />
      </StaticRouter>
    </StrictMode>,
  );
}
