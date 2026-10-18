// lazyPage — a React.lazy page that can also be loaded ahead of time.
//
// Heavy pages (service pages, articles, the blog list, policies, admin) live in
// their own chunks so the homepage does not download them (health report
// item 8). Two callers must never see a suspended page:
//   - the prerenderer (renderToString cannot wait), which calls preload() for
//     every page before rendering — see src/entry-server.jsx;
//   - hydration, which must match the prerendered HTML, so src/main.jsx awaits
//     preloadRoute() for the current URL before hydrateRoot().
// Once loaded, the page renders synchronously like a normal import.
import { lazy } from 'react';

export function lazyPage(loader) {
  let Loaded = null;
  let pending = null;
  const preload = () => {
    pending ||= loader().then((mod) => {
      Loaded = mod.default;
      return Loaded;
    });
    return pending;
  };
  const Lazy = lazy(() => preload().then((Component) => ({ default: Component })));

  function Page(props) {
    return Loaded ? <Loaded {...props} /> : <Lazy {...props} />;
  }
  Page.preload = preload;
  return Page;
}
