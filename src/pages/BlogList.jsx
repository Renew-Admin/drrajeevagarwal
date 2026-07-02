import React, { useMemo, useState, useEffect } from 'react';
import { Link, useSearchParams } from 'react-router-dom';
import { blogsData as initialBlogs } from '../data/blogs_data';
import { liveBlogUpdates } from '../data/live_blog_updates';
import { Search, CalendarDays, ArrowRight, FolderOpen, Tag, RotateCcw } from 'lucide-react';
import { buildBlogPresentation } from '../utils/blogPresentation';
import { listPublishedBlogs } from '../lib/supabaseBlogAdmin';

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
    const saved = localStorage.getItem('blogsList');
    return saved ? JSON.parse(saved) : initialBlogs;
  } catch {
    return initialBlogs;
  }
}

export default function BlogList() {
  const [blogs, setBlogs] = useState([]);
  const [searchTerm, setSearchTerm] = useState('');
  const [activeCategory, setActiveCategory] = useState('All Articles');
  const [activeTag, setActiveTag] = useState('');
  const [searchParams] = useSearchParams();

  useEffect(() => {
    let active = true;
    const fallback = readFallbackBlogs();
    setBlogs(uniqueBlogs([...liveBlogUpdates, ...fallback]));

    listPublishedBlogs().then((remoteBlogs) => {
      if (active) {
        setBlogs(uniqueBlogs([...remoteBlogs, ...liveBlogUpdates, ...fallback]));
      }
    });

    return () => {
      active = false;
    };
  }, []);

  useEffect(() => {
    const tagParam = searchParams.get('tag');
    if (tagParam) {
      setActiveTag(tagParam);
    }
  }, [searchParams]);

  const blogItems = useMemo(
    () => blogs.map((blog, index) => buildBlogPresentation(blog, index)),
    [blogs]
  );

  const categoryRows = useMemo(() => {
    const counts = blogItems.reduce((acc, blog) => {
      acc[blog.category] = (acc[blog.category] || 0) + 1;
      return acc;
    }, {});

    const preferredOrder = [
      'Preconception Care',
      'Fertility',
      'Safe Pregnancy',
      'Women\'s Health',
      'PCOS',
      'Male Fertility',
      'Endometriosis',
      'Women\'s Wellness'
    ];

    const rows = preferredOrder
      .filter((name) => counts[name])
      .map((name) => ({ name, count: counts[name] }));
    const included = new Set(rows.map((row) => row.name));
    const remainingRows = Object.keys(counts)
      .filter((name) => !included.has(name))
      .sort((a, b) => a.localeCompare(b))
      .map((name) => ({ name, count: counts[name] }));

    return [{ name: 'All Articles', count: blogItems.length }, ...rows, ...remainingRows];
  }, [blogItems]);

  const tagRows = useMemo(() => {
    const counts = blogItems.reduce((acc, blog) => {
      blog.tags.forEach((tagName) => {
        acc[tagName] = (acc[tagName] || 0) + 1;
      });
      return acc;
    }, {});

    return Object.entries(counts)
      .map(([name, count]) => ({ name, count }))
      .sort((a, b) => b.count - a.count || a.name.localeCompare(b.name))
      .slice(0, 18);
  }, [blogItems]);

  const filteredBlogs = useMemo(() => {
    const query = searchTerm.trim().toLowerCase();

    return blogItems.filter((blog) => {
      const matchesSearch = !query || blog.searchText.includes(query);
      const matchesCategory = activeCategory === 'All Articles' || blog.category === activeCategory;
      const matchesTag = !activeTag || blog.tags.includes(activeTag);
      return matchesSearch && matchesCategory && matchesTag;
    });
  }, [activeCategory, activeTag, blogItems, searchTerm]);

  const resetFilters = () => {
    setSearchTerm('');
    setActiveCategory('All Articles');
    setActiveTag('');
  };

  return (
    <div className="inner-page blog-page-modern">
      <section className="blog-page-intro">
        <div className="ra-container blog-page-intro-inner">
          <span className="ra-label">Blog</span>
          <h1>Latest fertility and wellness <em>articles</em></h1>
          <p>
            Evidence-based guides on fertility, pregnancy planning, IVF, PCOS, and women's wellness from Dr. Rajeev Agarwal.
          </p>
        </div>
      </section>

      <section className="blog-page-content">
        <div className="ra-container blog-layout">
          <main className="blog-feed" aria-label="Blog articles">
            <div className="blog-feed-topline">
              <span>{filteredBlogs.length} articles</span>
              {(searchTerm || activeTag || activeCategory !== 'All Articles') && (
                <button type="button" onClick={resetFilters}>
                  <RotateCcw size={14} />
                  Reset filters
                </button>
              )}
            </div>

            {filteredBlogs.length === 0 ? (
              <div className="blog-empty-panel">
                <h2>No articles found</h2>
                <p>Try a different search term or reset the filters.</p>
                <button type="button" onClick={resetFilters} className="ra-btn ra-btn-primary">Reset filters</button>
              </div>
            ) : (
              filteredBlogs.map((blog) => (
                <article key={blog.slug} className="blog-list-card">
                  <Link to={`/blog/${blog.slug}`} className="blog-list-image" aria-label={blog.title}>
                    <img src={blog.image} alt={blog.title} loading="lazy" />
                  </Link>
                  <div className="blog-list-body">
                    <span className="blog-list-badge">{blog.category}</span>
                    <Link to={`/blog/${blog.slug}`} className="blog-list-title">{blog.title}</Link>
                    <p>{blog.excerpt}</p>
                    <div className="blog-list-meta">
                      <span><CalendarDays size={15} /> {blog.displayDate}</span>
                      <span>{blog.readingTime} min read</span>
                    </div>
                    <div className="blog-list-footer">
                      <Link to={`/blog/${blog.slug}`} className="blog-read-link">
                        Read More <ArrowRight size={15} />
                      </Link>
                    </div>
                  </div>
                </article>
              ))
            )}
          </main>

          <aside className="blog-sidebar" aria-label="Blog filters">
            <div className="blog-sidebar-card">
              <h2>Search</h2>
              <div className="blog-filter-search">
                <input
                  type="search"
                  placeholder="Search articles..."
                  value={searchTerm}
                  onChange={(event) => setSearchTerm(event.target.value)}
                />
                <button type="button" aria-label="Search articles">
                  <Search size={19} />
                </button>
              </div>
            </div>

            <div className="blog-sidebar-card">
              <h2><FolderOpen size={19} /> Categories</h2>
              <div className="blog-category-list">
                {categoryRows.map((category) => (
                  <button
                    type="button"
                    key={category.name}
                    className={activeCategory === category.name ? 'is-active' : ''}
                    onClick={() => setActiveCategory(category.name)}
                  >
                    <span>{category.name}</span>
                    <strong>{category.count}</strong>
                  </button>
                ))}
              </div>
            </div>

            <div className="blog-sidebar-card">
              <h2><Tag size={19} /> Tags</h2>
              <div className="blog-tag-cloud">
                {tagRows.map((tagItem) => (
                  <button
                    type="button"
                    key={tagItem.name}
                    className={activeTag === tagItem.name ? 'is-active' : ''}
                    onClick={() => setActiveTag(activeTag === tagItem.name ? '' : tagItem.name)}
                  >
                    {tagItem.name}
                  </button>
                ))}
              </div>
            </div>
          </aside>
        </div>
      </section>
    </div>
  );
}
