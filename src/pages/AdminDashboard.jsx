import React, { useState, useEffect } from 'react';
import { blogsData as initialBlogs } from '../data/blogs_data';
import { FileText, Inbox, PlusCircle, Trash2 } from 'lucide-react';

export default function AdminDashboard() {
  const [activeTab, setActiveTab] = useState('submissions');
  const [submissions, setSubmissions] = useState([]);
  const [blogs, setBlogs] = useState([]);
  const [newBlog, setNewBlog] = useState({ title: '', slug: '', content: '', date: new Date().toISOString().split('T')[0] });
  const [blogSuccess, setBlogSuccess] = useState(false);

  useEffect(() => {
    const savedSubmissions = JSON.parse(localStorage.getItem('formSubmissions') || '[]');
    setSubmissions(savedSubmissions);
    const savedBlogs = localStorage.getItem('blogsList');
    if (savedBlogs) {
      setBlogs(JSON.parse(savedBlogs));
    } else {
      localStorage.setItem('blogsList', JSON.stringify(initialBlogs));
      setBlogs(initialBlogs);
    }
  }, []);

  const handleBlogChange = (e) => {
    const { name, value } = e.target;
    setNewBlog(prev => {
      const updated = { ...prev, [name]: value };
      if (name === 'title' && !prev.slug) {
        updated.slug = value.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-');
      }
      return updated;
    });
  };

  const handleBlogSubmit = (e) => {
    e.preventDefault();
    const blogToAdd = { id: Date.now().toString(), title: newBlog.title, slug: (newBlog.slug.startsWith('/') ? newBlog.slug.substring(1) : newBlog.slug), date: newBlog.date, content: newBlog.content };
    const updatedBlogs = [blogToAdd, ...blogs];
    setBlogs(updatedBlogs);
    localStorage.setItem('blogsList', JSON.stringify(updatedBlogs));
    setNewBlog({ title: '', slug: '', content: '', date: new Date().toISOString().split('T')[0] });
    setBlogSuccess(true);
    setTimeout(() => setBlogSuccess(false), 3000);
  };

  const handleDeleteSubmission = (id) => {
    const updated = submissions.filter(s => s.id !== id);
    setSubmissions(updated);
    localStorage.setItem('formSubmissions', JSON.stringify(updated));
  };

  const handleDeleteBlog = (slug) => {
    if (window.confirm("Are you sure you want to delete this blog post?")) {
      const updated = blogs.filter(b => b.slug !== slug);
      setBlogs(updated);
      localStorage.setItem('blogsList', JSON.stringify(updated));
    }
  };

  return (
    <div className="inner-page" style={{ background: 'var(--soft-blue)', paddingBottom: 80 }}>
      <div className="ra-container admin-layout" style={{ paddingTop: 40 }}>
        <div className="admin-sidebar-modern">
          <h2 style={{ fontSize: 22, fontWeight: 800, color: 'var(--deep-teal)', margin: '0 0 4px 0' }}>Admin Panel</h2>
          <p style={{ fontSize: 13, fontWeight: 500, color: 'var(--text-soft)', margin: '0 0 24px 0' }}>Manage site content & leads</p>
          <div className="admin-nav">
            <button onClick={() => setActiveTab('submissions')} className={`admin-nav-btn ${activeTab === 'submissions' ? 'active' : ''}`}>
              <Inbox size={18} /> <span>Inbox ({submissions.length})</span>
            </button>
            <button onClick={() => setActiveTab('new-blog')} className={`admin-nav-btn ${activeTab === 'new-blog' ? 'active' : ''}`}>
              <PlusCircle size={18} /> <span>Publish Blog</span>
            </button>
            <button onClick={() => setActiveTab('blogs')} className={`admin-nav-btn ${activeTab === 'blogs' ? 'active' : ''}`}>
              <FileText size={18} /> <span>Blogs ({blogs.length})</span>
            </button>
          </div>
        </div>

        <div className="admin-content-modern">
          {activeTab === 'submissions' && (
            <div>
              <h2 style={{ fontSize: 22, fontWeight: 800, color: 'var(--deep-teal)', marginBottom: 4 }}>Inbound Submissions</h2>
              <p style={{ fontSize: 14, color: 'var(--text-soft)', marginBottom: 24, fontWeight: 500 }}>Leads collected from forms across the website</p>
              {submissions.length === 0 ? (
                <div className="admin-empty">
                  <Inbox size={48} color="var(--text-soft)" style={{ marginBottom: 8 }} />
                  <h3 style={{ color: 'var(--deep-teal)', fontWeight: 800 }}>No submissions received yet</h3>
                  <p style={{ color: 'var(--text-soft)', fontSize: 14 }}>Inbound leads from contact forms or appointment schedulers will appear here.</p>
                </div>
              ) : (
                <div style={{ display: 'flex', flexDirection: 'column', gap: 20 }}>
                  {submissions.map((sub) => (
                    <div key={sub.id} className="admin-sub-card">
                      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 14 }}>
                        <span style={{ background: 'var(--blue-lt)', color: 'var(--deep-teal)', padding: '4px 12px', borderRadius: 999, fontSize: 11, fontWeight: 800, textTransform: 'uppercase', letterSpacing: '0.8px' }}>{sub.formName}</span>
                        <span style={{ fontSize: 12, color: 'var(--text-soft)', fontWeight: 600 }}>{sub.submittedAt}</span>
                      </div>
                      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(2, 1fr)', gap: '8px 20px', fontSize: 14, marginBottom: 8 }}>
                        {[{ label: 'Name', value: sub.data.name }, { label: 'Phone', value: sub.data.phone }, { label: 'Email', value: sub.data.email }, { label: 'Preferred Date', value: sub.data.date }].map((f, i) => (
                          <div key={i} style={{ display: 'flex', gap: 4, alignItems: 'center' }}>
                            <span style={{ color: 'var(--deep-teal)', fontWeight: 700 }}>{f.label}:</span>
                            <span style={{ color: 'var(--text-mid)', fontWeight: 500 }}>{f.value}</span>
                          </div>
                        ))}
                        {sub.data.timeSlot && (
                          <div style={{ display: 'flex', gap: 4, alignItems: 'center' }}>
                            <span style={{ color: 'var(--deep-teal)', fontWeight: 700 }}>Time:</span>
                            <span style={{ color: 'var(--text-mid)', fontWeight: 500 }}>{sub.data.timeSlot}</span>
                          </div>
                        )}
                      </div>
                      {sub.data.message && (
                        <div style={{ marginTop: 14, paddingTop: 14, borderTop: '1px dashed var(--border)' }}>
                          <strong style={{ color: 'var(--deep-teal)', fontSize: 13 }}>Medical Concerns / Notes:</strong>
                          <p style={{ marginTop: 6, fontStyle: 'italic', color: 'var(--text-mid)', fontSize: 14, lineHeight: 1.5 }}>"{sub.data.message}"</p>
                        </div>
                      )}
                      <button onClick={() => handleDeleteSubmission(sub.id)} style={{ position: 'absolute', bottom: 20, right: 20, background: 'none', border: 'none', color: '#EF4444', cursor: 'pointer', fontSize: 13, fontWeight: 700, display: 'flex', alignItems: 'center', gap: 4, padding: '6px 12px', borderRadius: 6 }}>
                        <Trash2 size={14} /> Delete
                      </button>
                    </div>
                  ))}
                </div>
              )}
            </div>
          )}

          {activeTab === 'new-blog' && (
            <div>
              <h2 style={{ fontSize: 22, fontWeight: 800, color: 'var(--deep-teal)', marginBottom: 4 }}>Publish a New Blog Post</h2>
              <p style={{ fontSize: 14, color: 'var(--text-soft)', marginBottom: 24, fontWeight: 500 }}>Write content to publish directly to the front-end blog list</p>
              {blogSuccess && <div style={{ background: '#D1FAE5', color: '#065F46', padding: '14px 20px', borderRadius: 12, marginBottom: 24, fontSize: 14, fontWeight: 700 }}>Blog post published successfully! It is now live.</div>}
              <form onSubmit={handleBlogSubmit} style={{ display: 'flex', flexDirection: 'column', gap: 20 }}>
                <div className="form-group">
                  <label className="form-label" htmlFor="title">Blog Title *</label>
                  <input type="text" id="title" name="title" required value={newBlog.title} onChange={handleBlogChange} className="form-control" placeholder="e.g. 5 Habits for Better Maternal Health" />
                </div>
                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 16 }}>
                  <div className="form-group">
                    <label className="form-label" htmlFor="slug">URL Slug *</label>
                    <input type="text" id="slug" name="slug" required value={newBlog.slug} onChange={handleBlogChange} className="form-control" placeholder="e.g. habits-for-better-maternal-health" />
                  </div>
                  <div className="form-group">
                    <label className="form-label" htmlFor="date">Publish Date *</label>
                    <input type="date" id="date" name="date" required value={newBlog.date} onChange={handleBlogChange} className="form-control" />
                  </div>
                </div>
                <div className="form-group">
                  <label className="form-label" htmlFor="content">Post Content (HTML Supported) *</label>
                  <textarea id="content" name="content" required rows="10" value={newBlog.content} onChange={handleBlogChange} className="form-control" placeholder="Type or paste your HTML blog content here..." style={{ resize: 'vertical' }} />
                </div>
                <button type="submit" className="ra-btn ra-btn-primary" style={{ alignSelf: 'flex-start', borderRadius: 12, padding: '0 24px', height: 46 }}>Publish Article</button>
              </form>
            </div>
          )}

          {activeTab === 'blogs' && (
            <div>
              <h2 style={{ fontSize: 22, fontWeight: 800, color: 'var(--deep-teal)', marginBottom: 4 }}>Manage Articles</h2>
              <p style={{ fontSize: 14, color: 'var(--text-soft)', marginBottom: 24, fontWeight: 500 }}>List and delete published articles</p>
              <div style={{ display: 'flex', flexDirection: 'column', gap: 12, maxHeight: 600, overflowY: 'auto', paddingRight: 8 }}>
                {blogs.map((blog) => (
                  <div key={blog.slug} style={{ display: 'flex', alignItems: 'center', padding: 18, border: '1px solid var(--border)', borderRadius: 12, background: 'var(--soft-blue)', justifyContent: 'space-between', gap: 16 }}>
                    <div style={{ flex: 1 }}>
                      <h4 style={{ fontSize: 15, fontWeight: 800, color: 'var(--deep-teal)', margin: 0 }}>{blog.title}</h4>
                      <div style={{ fontSize: 12, color: 'var(--text-soft)', marginTop: 4, display: 'flex', alignItems: 'center', gap: 8 }}>
                        <span>Slug: <code style={{ background: 'var(--soft-blue)', padding: '2px 6px', borderRadius: 4, color: 'var(--deep-teal)' }}>/{blog.slug}/</code></span>
                        <span style={{ color: 'var(--text-soft)' }}>•</span>
                        <span>Date: {blog.date}</span>
                      </div>
                    </div>
                    <button onClick={() => handleDeleteBlog(blog.slug)} style={{ background: 'none', border: 'none', color: '#EF4444', cursor: 'pointer', padding: 8, borderRadius: 6 }}>
                      <Trash2 size={16} />
                    </button>
                  </div>
                ))}
              </div>
            </div>
          )}
        </div>
      </div>
    </div>
  );
}
