import React, { useEffect, useMemo, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import { CalendarDays, ArrowLeft, AlertCircle, Clock, ArrowRight, Tags, PhoneCall } from 'lucide-react';
import { blogsData as initialBlogs } from '../data/blogs_data';
import { liveBlogUpdates } from '../data/live_blog_updates';
import useSeo from '../utils/useSeo';
import { getMetaForPath, getBlogPostMeta } from '../utils/seoMeta';
import { buildBlogPresentation, cleanBlogHtml } from '../utils/blogPresentation';
import { listPublishedBlogs } from '../lib/supabaseBlogAdmin';
import BlogImage from '../components/BlogImage';

function uniqueBlogs(list) {
  const seen = new Set();
  return list.filter((blog) => {
    if (seen.has(blog.slug)) return false;
    seen.add(blog.slug);
    return true;
  });
}

function readFallbackBlogs() {
  try {
    const savedBlogs = JSON.parse(localStorage.getItem('blogsList') || '[]');
    return savedBlogs.length > 0 ? savedBlogs : initialBlogs;
  } catch {
    return initialBlogs;
  }
}

export default function BlogPost() {
  const { slug } = useParams();
  const [blogs, setBlogs] = useState([]);
  const [loaded, setLoaded] = useState(false);

  useEffect(() => {
    let active = true;

    async function loadBlogs() {
      const fallback = readFallbackBlogs();
      const remoteBlogs = await listPublishedBlogs();

      if (active) {
        setBlogs(uniqueBlogs([...remoteBlogs, ...liveBlogUpdates, ...fallback]));
        setLoaded(true);
      }
    }

    loadBlogs();

    return () => {
      active = false;
    };
  }, []);

  const blogItems = useMemo(
    () => blogs.map((item, index) => buildBlogPresentation(item, index)),
    [blogs]
  );

  const cleanSlug = slug ? slug.trim().replace(/\/$/, '') : '';
  const blog = blogItems.find((item) => item.slug === cleanSlug);
  const latestArticles = blogItems.filter((item) => item.slug !== cleanSlug).slice(0, 5);
  const popularTags = Array.from(new Set((blogItems.flatMap((item) => item.tags)))).slice(0, 10);
  const blogSeo = blog
    ? getBlogPostMeta(blog.slug, blog.title, blog.excerpt)
    : getMetaForPath('/blog');
  useSeo(blogSeo);

  const articleHtml = blog
    ? cleanBlogHtml(blog.content, { removeFirstImage: true, removeFirstParagraph: !blog._remote })
    : '';

  if (loaded && !blog) {
    return (
      <div className="inner-page" style={{ display: 'flex', alignItems: 'center', minHeight: '60vh' }}>
        <div className="ra-container" style={{ textAlign: 'center', maxWidth: 600 }}>
          <AlertCircle size={48} color="#EF4444" style={{ marginBottom: 16 }} />
          <h2 style={{ fontWeight: 800, color: 'var(--deep-teal)' }}>Article Not Found</h2>
          <p style={{ color: 'var(--text-soft)' }}>We apologize, but the article you are looking for does not exist or has been deleted.</p>
          <Link to="/blog" className="ra-btn ra-btn-primary" style={{ marginTop: 16 }}>Back to Blog List</Link>
        </div>
      </div>
    );
  }

  if (!blog) {
    return null;
  }

  return (
    <div className="inner-page blog-post-page">
      <div className="ra-container blog-post-layout">
        <main className="blog-article-shell">
          <Link to="/blog" className="article-back"><ArrowLeft size={16} /> Back to Articles</Link>

          <article className="blog-article-card">
            <div className="blog-article-hero">
              <BlogImage src={blog.image} alt={blog.title} fitMode={blog.imageFit} />
            </div>

            <div className="blog-article-body">
              <div className="article-meta">
                <span><CalendarDays size={15} /> {blog.displayDate}</span>
                <span><Clock size={15} /> {blog.readingTime} min read</span>
              </div>
              <span className="blog-article-topic">{blog.category}</span>
              <h1 className="article-title">{blog.title}</h1>
              <p className="blog-article-lede">{blog.excerpt}</p>
              <div className="article-divider" />
              <article className="wordpress-blog-content" dangerouslySetInnerHTML={{ __html: articleHtml }} />
            </div>
          </article>
        </main>

        <aside className="blog-post-sidebar" aria-label="Related blog content">
          <div className="blog-sidebar-card blog-cta-card">
            <h2>Need personal guidance?</h2>
            <p>Book a consultation for fertility, preconception, pregnancy, or women's health concerns.</p>
            <Link to="/book-an-appointment" className="ra-btn ra-btn-primary">
              <PhoneCall size={17} />
              Book Appointment
            </Link>
          </div>

          <div className="blog-sidebar-card">
            <h2>Latest Articles</h2>
            <div className="blog-latest-list">
              {latestArticles.map((item) => (
                <Link to={`/blog/${item.slug}`} key={item.slug} className="blog-latest-item">
                  <BlogImage src={item.image} alt="" loading="lazy" fitMode={item.imageFit} />
                  <span>
                    <small>{item.displayDate}</small>
                    {item.title}
                  </span>
                </Link>
              ))}
            </div>
          </div>

          <div className="blog-sidebar-card">
            <h2><Tags size={19} /> Popular Topics</h2>
            <div className="blog-tag-cloud">
              {popularTags.map((tag) => (
                <Link to={`/blog?tag=${encodeURIComponent(tag)}`} key={tag}>{tag}</Link>
              ))}
            </div>
          </div>
        </aside>
      </div>
    </div>
  );
}
