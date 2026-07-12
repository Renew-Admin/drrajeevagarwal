import { useEffect, useMemo, useState } from 'react';
import { CalendarDays, FileText, Image as ImageIcon, Inbox, LogOut, PlusCircle, Star, Trash2, UploadCloud } from 'lucide-react';
import {
  BLOG_IMAGE_MAX_BYTES,
  clearAdminSession,
  compressImageToWebp,
  createBlogPost,
  deleteBlogPost,
  deleteLead,
  estimateReadMins,
  getStoredAdminSession,
  getValidAdminSession,
  listAdminBlogs,
  listLeads,
  signInAdmin,
  slugify,
  updateBlogPost,
  uploadBlogImage,
} from '../lib/supabaseBlogAdmin';
import RichTextEditor from '../components/RichTextEditor';

const today = () => new Date().toISOString().slice(0, 10);

const emptyBlog = {
  title: '',
  slug: '',
  date: today(),
  category: 'Fertility Care',
  excerpt: '',
  tags: '',
  content: '',
  published: true,
  isFeatured: false,
};

function kb(bytes) {
  return `${Math.round(bytes / 1024)} KB`;
}

export default function AdminDashboard() {
  const [activeTab, setActiveTab] = useState('leads');
  const [blogFilter, setBlogFilter] = useState('all');
  const [session, setSession] = useState(() => getStoredAdminSession());
  const [login, setLogin] = useState({ email: '', password: '' });
  const [loginError, setLoginError] = useState('');
  const [loginLoading, setLoginLoading] = useState(false);
  const [leads, setLeads] = useState([]);
  const [leadsLoading, setLeadsLoading] = useState(false);
  const [blogs, setBlogs] = useState([]);
  const [blogsLoading, setBlogsLoading] = useState(false);
  const [adminError, setAdminError] = useState('');
  const [newBlog, setNewBlog] = useState(emptyBlog);
  const [editingBlogId, setEditingBlogId] = useState('');
  const [existingCoverImage, setExistingCoverImage] = useState('');
  const [imageState, setImageState] = useState({ blob: null, previewUrl: '', size: 0, message: '' });
  const [publishing, setPublishing] = useState(false);
  const [blogSuccess, setBlogSuccess] = useState('');
  const [deletingLeadId, setDeletingLeadId] = useState('');
  const [deletingBlogId, setDeletingBlogId] = useState('');

  useEffect(() => {
    if (!session) return;
    loadAdminData();
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [session?.access_token]);

  const publishedCount = useMemo(() => blogs.filter((blog) => blog.published).length, [blogs]);
  const featuredBlogs = useMemo(() => blogs.filter((blog) => blog.isFeatured), [blogs]);
  const visibleAdminBlogs = useMemo(() => {
    if (blogFilter === 'featured') return featuredBlogs;
    if (blogFilter === 'drafts') return blogs.filter((blog) => !blog.published);
    return blogs;
  }, [blogFilter, blogs, featuredBlogs]);

  async function requireAdminSession() {
    const validSession = await getValidAdminSession();
    if (!validSession) {
      setSession(null);
      throw new Error('Your admin session expired. Please log in again.');
    }

    setSession(validSession);
    return validSession;
  }

  async function loadAdminData() {
    setAdminError('');

    try {
      const validSession = await requireAdminSession();
      await Promise.all([loadBlogs(validSession), loadLeads(validSession)]);
    } catch (error) {
      setAdminError(error.message || 'Could not load admin data.');
    }
  }

  async function loadBlogs(activeSession) {
    setBlogsLoading(true);
    setAdminError('');
    setBlogSuccess('');

    try {
      const validSession = activeSession || await requireAdminSession();
      const rows = await listAdminBlogs(validSession.access_token);
      setBlogs(rows);
    } catch (error) {
      setAdminError(error.message || 'Could not load Supabase blogs.');
    } finally {
      setBlogsLoading(false);
    }
  }

  async function loadLeads(activeSession) {
    setLeadsLoading(true);
    setAdminError('');
    setBlogSuccess('');

    try {
      const validSession = activeSession || await requireAdminSession();
      const rows = await listLeads(validSession.access_token);
      setLeads(rows);
    } catch (error) {
      setAdminError(error.message || 'Could not load Supabase leads.');
    } finally {
      setLeadsLoading(false);
    }
  }

  const handleLoginSubmit = async (event) => {
    event.preventDefault();
    setLoginLoading(true);
    setLoginError('');

    try {
      const nextSession = await signInAdmin(login.email.trim(), login.password);
      setSession(nextSession);
      setLogin({ email: '', password: '' });
    } catch (error) {
      clearAdminSession();
      setLoginError(error.message || 'Login failed. Check the email and password.');
    } finally {
      setLoginLoading(false);
    }
  };

  const handleLogout = () => {
    clearAdminSession();
    setSession(null);
    setBlogs([]);
    setLeads([]);
    setActiveTab('leads');
    setBlogFilter('all');
  };

  const handleBlogChange = (event) => {
    const { name, value, type, checked } = event.target;

    setNewBlog((prev) => {
      const nextValue = type === 'checkbox' ? checked : value;
      const updated = { ...prev, [name]: nextValue };

      if (name === 'title' && !prev.slug) {
        updated.slug = slugify(value);
      }

      if (name === 'slug') {
        updated.slug = slugify(value);
      }

      return updated;
    });
  };

  const handleImageChange = async (event) => {
    const file = event.target.files?.[0];
    if (!file) return;

    if (imageState.previewUrl) {
      URL.revokeObjectURL(imageState.previewUrl);
    }

    setImageState({ blob: null, previewUrl: '', size: 0, message: 'Compressing to WebP under 200 KB...' });

    try {
      const compressed = await compressImageToWebp(file, BLOG_IMAGE_MAX_BYTES);
      setImageState({
        blob: compressed.blob,
        previewUrl: compressed.previewUrl,
        size: compressed.size,
        message: `Ready: WebP cover image compressed to ${kb(compressed.size)}.`,
      });
    } catch (error) {
      setImageState({ blob: null, previewUrl: '', size: 0, message: error.message });
      event.target.value = '';
    }
  };

  const handleBlogSubmit = async (event) => {
    event.preventDefault();
    setPublishing(true);
    setAdminError('');
    setBlogSuccess('');

    try {
      const validSession = await requireAdminSession();

      const slug = slugify(newBlog.slug || newBlog.title);
      if (!slug) throw new Error('Please add a valid title or slug.');
      if (!newBlog.content || !String(newBlog.content).replace(/<[^>]+>/g, '').trim()) {
        throw new Error('Please add article content before publishing.');
      }

      let coverImage = existingCoverImage;
      if (imageState.blob) {
        const upload = await uploadBlogImage(imageState.blob, slug, validSession.access_token);
        coverImage = upload.url;
      }

      const tags = newBlog.tags
        .split(',')
        .map((tag) => tag.trim())
        .filter(Boolean);

      const payload = {
        slug,
        title: newBlog.title.trim(),
        category: newBlog.category.trim() || 'Fertility Care',
        excerpt: newBlog.excerpt.trim(),
        content: newBlog.content,
        cover_image: coverImage,
        read_mins: estimateReadMins(newBlog.content),
        tags,
        published: newBlog.published,
        is_featured: newBlog.isFeatured,
        published_at: new Date(`${newBlog.date}T00:00:00`).toISOString(),
      };

      const wasEditing = Boolean(editingBlogId);
      const post = wasEditing
        ? await updateBlogPost(editingBlogId, payload, validSession.access_token)
        : await createBlogPost(payload, validSession.access_token);

      setBlogs((prev) => [post, ...prev.filter((item) => item.id !== post.id && item.slug !== post.slug)]);
      setNewBlog(emptyBlog);
      setEditingBlogId('');
      setExistingCoverImage('');
      setImageState({ blob: null, previewUrl: '', size: 0, message: '' });
      setBlogSuccess(wasEditing ? 'Blog post updated in Supabase.' : (newBlog.published ? 'Blog post published and visible on the public blog.' : 'Draft saved in Supabase.'));
      setActiveTab('blogs');
    } catch (error) {
      setAdminError(error.message || 'Could not publish this blog.');
    } finally {
      setPublishing(false);
    }
  };

  const handleDeleteLead = async (id) => {
    if (!window.confirm('Delete this lead from Supabase?')) return;

    setDeletingLeadId(id);
    setAdminError('');
    setBlogSuccess('');

    try {
      const validSession = await requireAdminSession();

      await deleteLead(id, validSession.access_token);
      setLeads((prev) => prev.filter((lead) => lead.id !== id));
    } catch (error) {
      setAdminError(error.message || 'Could not delete this lead.');
    } finally {
      setDeletingLeadId('');
    }
  };

  const handleEditBlog = (blog) => {
    if (!blog) return;
    if (!blog.id) {
      setAdminError('This blog is missing its Supabase id. Refresh the blog list and try again.');
      return;
    }

    setEditingBlogId(blog.id);
    setExistingCoverImage(blog.image || '');
    setNewBlog({
      title: blog.title || '',
      slug: blog.slug || '',
      date: blog.date || today(),
      category: blog.category || 'Fertility Care',
      excerpt: blog.excerpt || '',
      tags: Array.isArray(blog.tags) ? blog.tags.join(', ') : '',
      content: blog.content || '',
      published: Boolean(blog.published),
      isFeatured: Boolean(blog.isFeatured),
    });
    setImageState({ blob: null, previewUrl: '', size: 0, message: blog.image ? 'Current cover image will be kept unless you upload a new one.' : '' });
    setBlogSuccess('');
    setAdminError('');
    document.querySelector('.admin-content-modern')?.scrollTo?.({ top: 0, behavior: 'smooth' });
    setActiveTab('new-blog');
  };

  const openFeaturedBlogs = () => {
    setBlogFilter('featured');
    setActiveTab('blogs');
  };

  const cancelEditBlog = () => {
    setEditingBlogId('');
    setExistingCoverImage('');
    setNewBlog(emptyBlog);
    setImageState({ blob: null, previewUrl: '', size: 0, message: '' });
  };

  const handleDeleteBlog = async (blog) => {
    if (!blog?.id) {
      setAdminError('This blog is missing its Supabase id. Refresh the blog list and try again.');
      return;
    }

    if (!window.confirm(`Delete "${blog.title}" from Supabase?`)) return;

    setDeletingBlogId(blog.id);
    setAdminError('');
    setBlogSuccess('');

    try {
      const validSession = await requireAdminSession();

      await deleteBlogPost(blog.id, validSession.access_token);
      setBlogs((prev) => prev.filter((item) => item.id !== blog.id));
    } catch (error) {
      setAdminError(error.message || 'Could not delete this blog.');
    } finally {
      setDeletingBlogId('');
    }
  };

  if (!session) {
    return (
      <div className="inner-page admin-login-page">
        <div className="ra-container admin-login-wrap">
          <form className="admin-login-card" onSubmit={handleLoginSubmit}>
            <span className="ra-label">Secure Admin</span>
            <h1>Login to manage blogs and leads</h1>

            {loginError && <div className="admin-alert error">{loginError}</div>}

            <div className="form-group">
              <label className="form-label" htmlFor="admin-email">Email</label>
              <input
                type="email"
                id="admin-email"
                required
                value={login.email}
                onChange={(event) => setLogin((prev) => ({ ...prev, email: event.target.value }))}
                className="form-control"
                autoComplete="email"
              />
            </div>

            <div className="form-group">
              <label className="form-label" htmlFor="admin-password">Password</label>
              <input
                type="password"
                id="admin-password"
                required
                value={login.password}
                onChange={(event) => setLogin((prev) => ({ ...prev, password: event.target.value }))}
                className="form-control"
                autoComplete="current-password"
              />
            </div>

            <button type="submit" className="ra-btn ra-btn-primary admin-login-submit" disabled={loginLoading}>
              {loginLoading ? 'Checking...' : 'Login'}
            </button>
          </form>
        </div>
      </div>
    );
  }

  return (
    <div className="inner-page admin-page-shell">
      <div className="ra-container admin-layout">
        <aside className="admin-sidebar-modern">
          <div className="admin-user-block">
            <h2>Admin Panel</h2>
            <p>{session.user?.email}</p>
          </div>

          <div className="admin-nav">
            <button type="button" onClick={() => setActiveTab('leads')} className={`admin-nav-btn ${activeTab === 'leads' ? 'active' : ''}`}>
              <Inbox size={18} /> <span>Leads ({leads.length})</span>
            </button>
            <button type="button" onClick={() => setActiveTab('new-blog')} className={`admin-nav-btn ${activeTab === 'new-blog' ? 'active' : ''}`}>
              <PlusCircle size={18} /> <span>Publish Blog</span>
            </button>
            <button type="button" onClick={() => { setActiveTab('blogs'); setBlogFilter('all'); }} className={`admin-nav-btn ${activeTab === 'blogs' ? 'active' : ''}`}>
              <FileText size={18} /> <span>Blogs ({blogs.length})</span>
            </button>
            <button type="button" onClick={openFeaturedBlogs} className={`admin-nav-btn ${activeTab === 'blogs' && blogFilter === 'featured' ? 'active' : ''}`}>
              <Star size={18} /> <span>Featured ({featuredBlogs.length})</span>
            </button>
          </div>

          <div className="admin-side-stats">
            <span><strong>{leads.length}</strong> leads</span>
            <span><strong>{publishedCount}</strong> live posts</span>
            <span><strong>{blogs.filter((blog) => blog.isFeatured).length}</strong> featured</span>
          </div>

          <button type="button" className="admin-logout-btn" onClick={handleLogout}>
            <LogOut size={16} />
            Logout
          </button>
        </aside>

        <section className="admin-content-modern">
          {adminError && <div className="admin-alert error">{adminError}</div>}
          {blogSuccess && <div className="admin-alert success">{blogSuccess}</div>}

          {activeTab === 'leads' && (
            <div>
              <div className="admin-list-head">
                <div>
                  <h2 className="admin-section-title">Inbound Leads</h2>
                  <p className="admin-section-copy">Leads collected from appointment, callback, and course forms.</p>
                </div>
                <button type="button" className="ra-btn ra-btn-soft" onClick={loadLeads} disabled={leadsLoading}>
                  {leadsLoading ? 'Refreshing...' : 'Refresh'}
                </button>
              </div>

              {leadsLoading && <p className="admin-section-copy">Loading Supabase leads...</p>}

              {!leadsLoading && leads.length === 0 ? (
                <div className="admin-empty">
                  <Inbox size={48} color="var(--text-soft)" />
                  <h3>No leads received yet</h3>
                  <p>Inbound leads from contact, appointment, callback, and course forms will appear here.</p>
                </div>
              ) : (
                <div className="admin-stack">
                  {leads.map((sub) => (
                    <div key={sub.id} className="admin-sub-card">
                      <div className="admin-sub-head">
                        <span>{sub.formName}</span>
                        <small>{sub.submittedAt}</small>
                      </div>
                      <div className="admin-sub-grid">
                        {[
                          { label: 'Name', value: sub.data.name },
                          { label: 'Contact Number', value: sub.data.contact_number || sub.data.phone },
                          { label: 'WhatsApp Number', value: sub.data.whatsapp_number || sub.data.phone },
                          { label: 'Purpose of Visit', value: sub.data.purpose_of_visit || sub.data.service || sub.data.concern },
                          { label: 'Lead Date', value: sub.data.lead_date },
                        ].filter((field) => field.value).map((field) => (
                          <div key={field.label}>
                            <strong>{field.label}:</strong> {field.value || '-'}
                          </div>
                        ))}
                      </div>
                      <button
                        type="button"
                        onClick={() => handleDeleteLead(sub.id)}
                        className="admin-icon-danger"
                        disabled={deletingLeadId === sub.id}
                      >
                        <Trash2 size={14} /> {deletingLeadId === sub.id ? 'Deleting...' : 'Delete'}
                      </button>
                    </div>
                  ))}
                </div>
              )}
            </div>
          )}

          {activeTab === 'new-blog' && (
            <div>
              <div className="admin-list-head">
                <div>
                  <h2 className="admin-section-title">{editingBlogId ? 'Edit Blog Post' : 'Publish a New Blog Post'}</h2>
                  <p className="admin-section-copy">
                    {editingBlogId ? 'Update the selected Supabase article.' : 'Content saves to Supabase and published rows appear on the public blog.'}
                  </p>
                </div>
                {editingBlogId && (
                  <button type="button" className="ra-btn ra-btn-soft" onClick={cancelEditBlog}>
                    Cancel Edit
                  </button>
                )}
              </div>

              <form onSubmit={handleBlogSubmit} className="admin-blog-form">
                <div className="form-group">
                  <label className="form-label" htmlFor="title">Blog Title *</label>
                  <input type="text" id="title" name="title" required value={newBlog.title} onChange={handleBlogChange} className="form-control" placeholder="e.g. PCOS care and fertility planning" />
                </div>

                <div className="admin-form-grid">
                  <div className="form-group">
                    <label className="form-label" htmlFor="slug">URL Slug *</label>
                    <input type="text" id="slug" name="slug" required value={newBlog.slug} onChange={handleBlogChange} className="form-control" placeholder="pcos-care-fertility-planning" />
                  </div>
                  <div className="form-group">
                    <label className="form-label" htmlFor="date">Publish Date *</label>
                    <input type="date" id="date" name="date" required value={newBlog.date} onChange={handleBlogChange} className="form-control" />
                  </div>
                </div>

                <div className="admin-form-grid">
                  <div className="form-group">
                    <label className="form-label" htmlFor="category">Category</label>
                    <input type="text" id="category" name="category" value={newBlog.category} onChange={handleBlogChange} className="form-control" />
                  </div>
                  <div className="form-group">
                    <label className="form-label" htmlFor="tags">Tags</label>
                    <input type="text" id="tags" name="tags" value={newBlog.tags} onChange={handleBlogChange} className="form-control" placeholder="IVF, PCOS, Fertility" />
                  </div>
                </div>

                <div className="form-group">
                  <label className="form-label" htmlFor="excerpt">Short Excerpt *</label>
                  <textarea id="excerpt" name="excerpt" required rows="3" value={newBlog.excerpt} onChange={handleBlogChange} className="form-control" placeholder="A concise summary for the blog listing." />
                </div>

                <div className="form-group">
                  <label className="form-label" htmlFor="cover-image">Cover Image</label>
                  <label className="admin-image-upload" htmlFor="cover-image">
                    <UploadCloud size={24} />
                    <span>Upload any image. It will be converted to WebP under 200 KB.</span>
                    <strong>{imageState.message || 'No cover image selected'}</strong>
                  </label>
                  <input id="cover-image" type="file" accept="image/*" onChange={handleImageChange} hidden />
                  {imageState.previewUrl && (
                    <div className="admin-image-preview">
                      <img src={imageState.previewUrl} alt="Compressed cover preview" />
                      <span><ImageIcon size={14} /> WebP {kb(imageState.size)}</span>
                    </div>
                  )}
                </div>

                <div className="form-group">
                  <label className="form-label" htmlFor="content">Post Content (HTML Supported) *</label>
                  <RichTextEditor
                    value={newBlog.content}
                    onChange={(content) => setNewBlog((prev) => ({ ...prev, content }))}
                  />
                </div>

                <div className="admin-publish-controls">
                  <label>
                    <input type="checkbox" name="published" checked={newBlog.published} onChange={handleBlogChange} />
                    Publish now
                  </label>
                  <label>
                    <input type="checkbox" name="isFeatured" checked={newBlog.isFeatured} onChange={handleBlogChange} />
                    <Star size={15} />
                    Featured
                  </label>
                </div>

                <button type="submit" className="ra-btn ra-btn-primary" disabled={publishing}>
                  {publishing ? 'Saving...' : (editingBlogId ? 'Update Article' : 'Publish Article')}
                </button>
              </form>
            </div>
          )}

          {activeTab === 'blogs' && (
            <div>
              <div className="admin-list-head">
                <div>
                  <h2 className="admin-section-title">Manage Supabase Articles</h2>
                  <p className="admin-section-copy">Published posts show on <code>/blog</code>; drafts stay in the admin panel.</p>
                </div>
                <div className="admin-filter-toggle" role="tablist" aria-label="Blog filters">
                  <button type="button" className={blogFilter === 'all' ? 'is-active' : ''} onClick={() => setBlogFilter('all')}>All</button>
                  <button type="button" className={blogFilter === 'featured' ? 'is-active' : ''} onClick={() => setBlogFilter('featured')}>Featured</button>
                  <button type="button" className={blogFilter === 'drafts' ? 'is-active' : ''} onClick={() => setBlogFilter('drafts')}>Drafts</button>
                  <button type="button" className="ra-btn ra-btn-soft" onClick={loadBlogs} disabled={blogsLoading}>
                    {blogsLoading ? 'Refreshing...' : 'Refresh'}
                  </button>
                </div>
              </div>

              {blogsLoading && <p className="admin-section-copy">Loading Supabase posts...</p>}

              {!blogsLoading && visibleAdminBlogs.length === 0 ? (
                <div className="admin-empty">
                  <FileText size={48} color="var(--text-soft)" />
                  <h3>No Supabase blogs yet</h3>
                  <p>Publish the first article from the admin form.</p>
                </div>
              ) : (
                <div className="admin-blog-list">
                  {visibleAdminBlogs.map((blog) => (
                    <article key={blog.id} className="admin-blog-row">
                      {blog.image ? <img src={blog.image} alt="" /> : <div className="admin-blog-placeholder"><ImageIcon size={18} /></div>}
                      <div>
                        <h3>{blog.title}</h3>
                        <p>
                          <span><CalendarDays size={14} /> {blog.date}</span>
                          <span>{blog.category}</span>
                          <span>{blog.published ? 'Published' : 'Draft'}</span>
                          {blog.isFeatured && <span><Star size={14} /> Featured</span>}
                        </p>
                        <code>/{blog.slug}</code>
                      </div>
                      <div className="admin-blog-actions">
                        <button type="button" onClick={() => handleEditBlog(blog)} disabled={deletingBlogId === blog.id}>
                          Edit
                        </button>
                        <button type="button" onClick={() => handleDeleteBlog(blog)} className="admin-icon-danger" aria-label={`Delete ${blog.title}`} disabled={deletingBlogId === blog.id}>
                          <Trash2 size={16} />
                        </button>
                      </div>
                    </article>
                  ))}
                </div>
              )}
            </div>
          )}
        </section>
      </div>
    </div>
  );
}
