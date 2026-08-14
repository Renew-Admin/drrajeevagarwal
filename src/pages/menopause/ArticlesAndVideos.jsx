import { useEffect, useMemo, useState } from 'react';
import { Link } from 'react-router-dom';
import { ArrowRight, CalendarDays, PlayCircle } from 'lucide-react';

import MenopauseLayout from '../../components/menopause/MenopauseLayout';
import MenopauseFaq from '../../components/menopause/MenopauseFaq';
import VideoCard from '../../components/menopause/VideoCard';
import BlogImage from '../../components/BlogImage';
import { MENOPAUSE_VIDEOS } from '../../data/menopauseCare';
import { blogsData } from '../../data/blogs_data';
import { liveBlogUpdates } from '../../data/live_blog_updates';
import { buildBlogPresentation } from '../../utils/blogPresentation';
import { listPublishedBlogs } from '../../lib/supabaseBlogAdmin';

const sideNav = [
  { id: 'videos', label: 'Video library' },
  { id: 'articles', label: 'Articles' },
  { id: 'coming-up', label: 'What is coming' },
  { id: 'faq', label: 'FAQ' },
];

// A post earns a place here if menopause is what it is *about*, not merely
// mentioned in passing — a title match, or the word used repeatedly in the body.
// A looser keyword filter pulled in fertility posts that name-check menopause
// once, which is exactly the thin, off-topic listing this page should not be.
const TITLE_PATTERN = /menopaus|perimenopaus|hot flash|hrt|hormone|osteoporo|midlife/i;
const BODY_PATTERN = /menopaus/gi;
const MIN_BODY_MENTIONS = 4;
const MAX_ARTICLES = 6;

const comingUp = [
  'What actually changed with the FDA’s 2025 decision on hormone therapy labelling',
  'Perimenopause versus thyroid disease: telling the difference',
  'Why South Asian women may need cardiovascular risk assessed differently',
];

function uniqueBySlug(posts) {
  const seen = new Set();
  return posts.filter((post) => {
    if (!post?.slug || seen.has(post.slug)) return false;
    seen.add(post.slug);
    return true;
  });
}

function selectMenopausePosts(posts) {
  return posts
    .map((post) => {
      const mentions = ((post.content || '').match(BODY_PATTERN) || []).length;
      const titleHit = TITLE_PATTERN.test(post.title || '') ? 1 : 0;
      return { post, score: titleHit * 10 + mentions, mentions, titleHit };
    })
    .filter((entry) => entry.titleHit || entry.mentions >= MIN_BODY_MENTIONS)
    .sort((a, b) => b.score - a.score)
    .slice(0, MAX_ARTICLES)
    .map((entry, index) => buildBlogPresentation(entry.post, index));
}

// Seeded from the bundled posts so the list is in the prerendered HTML rather
// than appearing only after hydration.
const STATIC_POSTS = uniqueBySlug([...liveBlogUpdates, ...blogsData]);

export default function ArticlesAndVideos({ onBookClick }) {
  const [posts, setPosts] = useState(STATIC_POSTS);

  useEffect(() => {
    let active = true;
    listPublishedBlogs()
      .then((remote) => {
        if (active && Array.isArray(remote) && remote.length > 0) {
          setPosts(uniqueBySlug([...remote, ...STATIC_POSTS]));
        }
      })
      .catch(() => {
        /* the bundled posts already render — a failed refresh changes nothing */
      });
    return () => {
      active = false;
    };
  }, []);

  const articles = useMemo(() => selectMenopausePosts(posts), [posts]);

  return (
    <MenopauseLayout
      pageKey="library"
      onBookClick={onBookClick}
      sideNav={sideNav}
      lede={
        <p>
          Dr. Agarwal's talks on perimenopause and hormone therapy, alongside the written articles that go
          deeper on each question. Start with whichever format you actually absorb.
        </p>
      }
      heroActions={
        <a
          className="mc-btn mc-btn-outline"
          href="https://www.youtube.com/@DrRajeevAgarwal"
          target="_blank"
          rel="noreferrer"
        >
          <PlayCircle size={17} /> Full YouTube channel
        </a>
      }
    >
      <h2 id="videos">Video library</h2>
      <div className="mc-video-grid">
        {MENOPAUSE_VIDEOS.map((video) => <VideoCard key={video.id} video={video} />)}
      </div>

      <h2 id="articles">Articles on menopause and midlife hormones</h2>
      {articles.length > 0 ? (
        <div className="mc-cards mc-cards-2">
          {articles.map((post) => (
            <article className="mc-article-card" key={post.slug}>
              <Link to={`/blog/${post.slug}`} className="mc-article-media" aria-hidden="true" tabIndex={-1}>
                <BlogImage src={post.image} alt="" loading="lazy" fitMode={post.imageFit} />
              </Link>
              <div className="mc-article-body">
                <span className="mc-tag is-sage">{post.category}</span>
                <h3><Link to={`/blog/${post.slug}`}>{post.title}</Link></h3>
                <p>{post.excerpt}</p>
                <div className="mc-article-meta">
                  {post.displayDate && <span><CalendarDays size={13} /> {post.displayDate}</span>}
                  {post.readingTime && <span>{post.readingTime}</span>}
                </div>
              </div>
            </article>
          ))}
        </div>
      ) : (
        <p className="mc-muted">Articles are being added — see the <Link to="/blog">full blog</Link> meanwhile.</p>
      )}
      <p className="mc-small">
        <Link to="/blog">Browse every article on the blog <ArrowRight size={14} /></Link>
      </p>

      <h2 id="coming-up">What is being written next</h2>
      <p className="mc-muted">
        Each of these answers a genuinely contested or commonly misunderstood question, and gets researched
        before it is written:
      </p>
      <ul className="mc-list">
        {comingUp.map((item) => <li key={item}>{item}</li>)}
      </ul>
      <p className="mc-small mc-muted">
        Have a question you keep hearing, or one nobody has answered for you? It is usually the best signal for
        what to write next — raise it at your consultation.
      </p>

      <MenopauseFaq pageKey="library" />
    </MenopauseLayout>
  );
}
