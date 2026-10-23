import { useCallback, useEffect, useRef, useState } from 'react';
import { CalendarDays, Image as ImageIcon, MapPin, Trash2, UploadCloud } from 'lucide-react';
import {
  GMB_CAPTION_MAX,
  GMB_LOCATIONS,
  GMB_TIME_OPTIONS,
  convertImageToJpg,
  createGmbPost,
  deleteGmbImage,
  deleteGmbPost,
  fetchImageFromUrl,
  listGmbBlogOptions,
  listGmbPosts,
  notifyGmbWebhook,
  updateGmbPost,
  uploadGmbImage,
  validateGmbPost,
} from '../lib/gmb';

const todayKolkata = () => new Intl.DateTimeFormat('en-CA', { timeZone: 'Asia/Kolkata' }).format(new Date());

const emptyPost = () => ({
  PostDate: todayKolkata(),
  TimeSchedule: '10:00',
  Title: '',
  Caption: '',
  Location: 'Ballygunge',
  ImageURL: '',
  CTAUrl: '',
});

function sizeLabel(bytes) {
  return bytes >= 1024 * 1024 ? `${(bytes / 1024 / 1024).toFixed(2)} MB` : `${Math.round(bytes / 1024)} KB`;
}

function timeLabel(value) {
  return GMB_TIME_OPTIONS.find((option) => option.value === String(value).slice(0, 5))?.label || value;
}

export default function AdminGmb({ getToken }) {
  const [posts, setPosts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [showForm, setShowForm] = useState(false);
  const [editingId, setEditingId] = useState(null);
  const [form, setForm] = useState(emptyPost);
  const [imageLink, setImageLink] = useState('');
  const [image, setImage] = useState({ blob: null, previewUrl: '', message: '' });
  const [saving, setSaving] = useState(false);
  const [deletingId, setDeletingId] = useState(null);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const [blogOptions, setBlogOptions] = useState([]);
  const [blogOptionsLoading, setBlogOptionsLoading] = useState(false);
  const [selectedBlog, setSelectedBlog] = useState('');
  // The dashboard recreates getToken every render; keep the latest in a ref
  // so loading runs once per mount instead of on every parent render.
  const getTokenRef = useRef(getToken);
  useEffect(() => {
    getTokenRef.current = getToken;
  }, [getToken]);
  const tokenNow = () => getTokenRef.current();

  const loadPosts = useCallback(async () => {
    setLoading(true);
    setError('');
    try {
      setPosts(await listGmbPosts(await getTokenRef.current()));
    } catch (loadError) {
      setError(`Could not load GMB posts: ${loadError.message}`);
    } finally {
      setLoading(false);
    }
  }, []);

  useEffect(() => {
    getTokenRef.current()
      .then(listGmbPosts)
      .then(setPosts)
      .catch((loadError) => setError(`Could not load GMB posts: ${loadError.message}`))
      .finally(() => setLoading(false));
  }, []);

  const resetImage = () => {
    if (image.previewUrl) URL.revokeObjectURL(image.previewUrl);
    setImage({ blob: null, previewUrl: '', message: '' });
    setImageLink('');
  };

  const loadBlogOptions = async () => {
    if (blogOptions.length || blogOptionsLoading) return;
    setBlogOptionsLoading(true);
    try {
      setBlogOptions(await listGmbBlogOptions(await tokenNow()));
    } catch (optionsError) {
      setError(`Could not load blogs: ${optionsError.message}`);
    } finally {
      setBlogOptionsLoading(false);
    }
  };

  const handleBlogSelect = async (event) => {
    const slug = event.target.value;
    setSelectedBlog(slug);
    const blog = blogOptions.find((option) => option.slug === slug);
    if (!blog) return;
    setError('');
    setForm((current) => ({ ...current, Title: blog.title, Caption: blog.caption, CTAUrl: blog.cta }));
    setImageLink(blog.image);
    if (!blog.image) return;
    try {
      await applyImageBlob(await fetchImageFromUrl(blog.image));
    } catch (imageError) {
      setError(`Blog details filled, but the image could not be loaded: ${imageError.message} Upload it manually.`);
    }
  };

  const openNew = () => {
    loadBlogOptions();
    setSelectedBlog('');
    resetImage();
    setForm(emptyPost());
    setEditingId(null);
    setShowForm(true);
    setSuccess('');
    setError('');
  };

  const openEdit = (post) => {
    loadBlogOptions();
    setSelectedBlog('');
    resetImage();
    setForm({
      PostDate: String(post.PostDate).slice(0, 10),
      TimeSchedule: String(post.TimeSchedule).slice(0, 5),
      Title: post.Title || '',
      Caption: post.Caption || '',
      Location: post.Location || 'Ballygunge',
      ImageURL: post.ImageURL || '',
      CTAUrl: post.CTAUrl || '',
    });
    setEditingId(post.id);
    setShowForm(true);
    setSuccess('');
    setError('');
  };

  const closeForm = () => {
    resetImage();
    setShowForm(false);
    setEditingId(null);
  };

  const handleChange = (event) => {
    const { name, value } = event.target;
    setForm((current) => ({ ...current, [name]: value }));
  };

  const applyImageBlob = async (source) => {
    setImage((current) => ({ ...current, message: 'Converting to JPG...' }));
    try {
      const jpg = await convertImageToJpg(source);
      if (image.previewUrl) URL.revokeObjectURL(image.previewUrl);
      setImage({ blob: jpg, previewUrl: URL.createObjectURL(jpg), message: `Saved as JPG — ${sizeLabel(jpg.size)}` });
    } catch (convertError) {
      setImage({ blob: null, previewUrl: '', message: '' });
      setError(convertError.message);
    }
  };

  const handleFileChange = async (event) => {
    const file = event.target.files?.[0];
    event.target.value = '';
    if (!file) return;
    setError('');
    await applyImageBlob(file);
  };

  const handleImageLink = async () => {
    const link = imageLink.trim();
    if (!/^https?:\/\//i.test(link)) {
      setError('Image link must start with http:// or https://');
      return;
    }
    setError('');
    try {
      await applyImageBlob(await fetchImageFromUrl(link));
    } catch (linkError) {
      setError(linkError.message);
    }
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    setError('');
    setSuccess('');

    const draft = { ...form, ImageURL: image.blob ? 'pending' : form.ImageURL };
    const invalid = validateGmbPost(draft);
    if (invalid) {
      setError(invalid);
      return;
    }

    setSaving(true);
    let uploadedUrl = '';
    try {
      const token = await tokenNow();
      if (image.blob) uploadedUrl = await uploadGmbImage(image.blob, form.Location, token);
      const input = { ...form, ImageURL: uploadedUrl || form.ImageURL };

      if (editingId) {
        const previous = posts.find((post) => post.id === editingId);
        await updateGmbPost(editingId, input, token);
        if (uploadedUrl && previous?.ImageURL && previous.ImageURL !== uploadedUrl) {
          await deleteGmbImage(previous.ImageURL, token).catch(() => {});
        }
        setSuccess('GMB post updated. (Edits are not re-sent to Make.com.)');
      } else {
        const row = await createGmbPost(input, token);
        try {
          await notifyGmbWebhook(row.id, token);
          setSuccess('GMB post saved and sent to Make.com.');
        } catch (webhookError) {
          console.warn('[gmb webhook] delivery failed:', webhookError.message);
          setSuccess(`GMB post saved, but the webhook failed: ${webhookError.message}`);
        }
      }

      closeForm();
      await loadPosts();
    } catch (saveError) {
      if (uploadedUrl) await deleteGmbImage(uploadedUrl, await tokenNow()).catch(() => {});
      setError(`Could not save GMB post: ${saveError.message}`);
    } finally {
      setSaving(false);
    }
  };

  const handleDelete = async (post) => {
    if (!window.confirm(`Delete "${post.Title}"? Its image will also be removed.`)) return;
    setDeletingId(post.id);
    setError('');
    setSuccess('');
    try {
      await deleteGmbPost(post, await tokenNow());
      setPosts((current) => current.filter((item) => item.id !== post.id));
      setSuccess('GMB post deleted.');
    } catch (deleteError) {
      setError(`Could not delete GMB post: ${deleteError.message}`);
    } finally {
      setDeletingId(null);
    }
  };

  const previewSrc = image.previewUrl || form.ImageURL;

  return (
    <div>
      <div className="admin-list-head">
        <div>
          <h2 className="admin-section-title">Google Business Profile</h2>
          <p className="admin-section-copy">Schedule GMB posts for the Ballygunge clinic. New posts are sent to Make.com.</p>
        </div>
        {showForm ? (
          <button type="button" className="ra-btn ra-btn-soft" onClick={closeForm}>Cancel</button>
        ) : (
          <button type="button" className="ra-btn ra-btn-primary" onClick={openNew}>+ Add GMB Post</button>
        )}
      </div>

      <div className="admin-gmb-guide">
        <ol>
          <li>Schedule posts in date order (today, then tomorrow, and so on).</li>
          <li>The webhook gets the date as <code>YYYY-MM-DD</code> and the time as <code>10:00</code> or <code>18:00</code>.</li>
        </ol>
      </div>

      {error && <div className="admin-alert error">{error}</div>}
      {success && <div className="admin-alert success">{success}</div>}

      {showForm && (
        <form className="admin-blog-form" onSubmit={handleSubmit}>
          <h3 className="admin-gmb-form-title">{editingId ? 'Edit GMB Post' : 'New GMB Post'}</h3>
          <div className="form-group admin-gmb-blog-pick">
            <label className="form-label" htmlFor="gmb-blog">Fill from a blog <small>(optional — you can still edit everything below)</small></label>
            <select className="form-control" id="gmb-blog" value={selectedBlog} onChange={handleBlogSelect} disabled={blogOptionsLoading}>
              <option value="">{blogOptionsLoading ? 'Loading blogs...' : '— Select a blog to auto-fill title, caption, image & CTA —'}</option>
              {blogOptions.map((blog) => (
                <option key={blog.slug} value={blog.slug}>{blog.date ? `${blog.date} · ` : ''}{blog.title}</option>
              ))}
            </select>
          </div>

          <div className="admin-form-grid">
            <div className="form-group">
              <label className="form-label" htmlFor="gmb-date">Post Date *</label>
              <input className="form-control" id="gmb-date" name="PostDate" type="date" value={form.PostDate} onChange={handleChange} required />
            </div>
            <div className="form-group">
              <label className="form-label" htmlFor="gmb-time">Time Schedule *</label>
              <select className="form-control" id="gmb-time" name="TimeSchedule" value={form.TimeSchedule} onChange={handleChange} required>
                {GMB_TIME_OPTIONS.map((option) => (
                  <option key={option.value} value={option.value}>{option.label}</option>
                ))}
              </select>
            </div>
          </div>

          <div className="form-group">
            <label className="form-label" htmlFor="gmb-title">Title * <small>(internal name only, not shown on Google)</small></label>
            <input className="form-control" id="gmb-title" name="Title" value={form.Title} onChange={handleChange} required />
          </div>

          <div className="form-group">
            <label className="form-label" htmlFor="gmb-caption">Caption *</label>
            <textarea className="form-control" id="gmb-caption" name="Caption" rows={4} maxLength={GMB_CAPTION_MAX} value={form.Caption} onChange={handleChange} required />
            <small className={`admin-upload-note ${form.Caption.length >= GMB_CAPTION_MAX ? 'is-limit' : ''}`}>
              {form.Caption.length} / {GMB_CAPTION_MAX}
            </small>
          </div>

          <div className="admin-form-grid">
            <div className="form-group">
              <label className="form-label" htmlFor="gmb-location">Location *</label>
              <select className="form-control" id="gmb-location" name="Location" value={form.Location} onChange={handleChange} required>
                {GMB_LOCATIONS.map((location) => (
                  <option key={location} value={location}>{location}</option>
                ))}
              </select>
            </div>
            <div className="form-group">
              <label className="form-label" htmlFor="gmb-cta">CTA URL *</label>
              <input className="form-control" id="gmb-cta" name="CTAUrl" type="url" placeholder="https://" value={form.CTAUrl} onChange={handleChange} required />
            </div>
          </div>

          <div className="form-group">
            <span className="form-label">Image *</span>
            <label className="admin-image-upload" htmlFor="gmb-image-upload">
              <UploadCloud size={18} />
              <span>Upload image (PNG, WebP, AVIF, JPG)</span>
              <input id="gmb-image-upload" type="file" accept="image/*" onChange={handleFileChange} />
            </label>
            <div className="admin-gmb-link-row">
              <input className="form-control" type="url" placeholder="…or paste an image link" value={imageLink} onChange={(event) => setImageLink(event.target.value)} />
              <button type="button" className="ra-btn ra-btn-soft" onClick={handleImageLink} disabled={!imageLink.trim()}>Use link</button>
            </div>
            {image.message && <small className="admin-upload-note">{image.message}</small>}
            {previewSrc && (
              <div className="admin-image-preview">
                <img src={previewSrc} alt="GMB post preview" />
              </div>
            )}
          </div>

          <button type="submit" className="ra-btn ra-btn-primary" disabled={saving}>
            {saving ? 'Saving...' : editingId ? 'Update GMB Post' : 'Save & Schedule'}
          </button>
        </form>
      )}

      {loading && <p className="admin-section-copy">Loading GMB posts...</p>}

      {!loading && !showForm && posts.length === 0 && (
        <div className="admin-empty">
          <MapPin size={48} color="var(--text-soft)" />
          <h3>No GMB posts yet</h3>
          <p>Click “+ Add GMB Post” to schedule the first one.</p>
        </div>
      )}

      {!showForm && posts.length > 0 && (
        <div className="admin-gmb-table-wrap">
          <table className="admin-gmb-table">
            <thead>
              <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Clinic Location</th>
                <th>Publish Date</th>
                <th>Status</th>
                <th aria-label="Actions" />
              </tr>
            </thead>
            <tbody>
              {posts.map((post) => (
                <tr key={post.id}>
                  <td>
                    {post.ImageURL ? <img src={post.ImageURL} alt="" /> : <div className="admin-blog-placeholder"><ImageIcon size={18} /></div>}
                  </td>
                  <td>{post.Title}</td>
                  <td>{post.Location}</td>
                  <td>
                    <span className="admin-gmb-date"><CalendarDays size={14} /> {String(post.PostDate).slice(0, 10)}</span>
                    <small>{timeLabel(post.TimeSchedule)}</small>
                  </td>
                  <td><span className={`admin-gmb-status is-${String(post.Status).toLowerCase()}`}>{post.Status}</span></td>
                  <td>
                    <div className="admin-blog-actions">
                      <button type="button" onClick={() => openEdit(post)} disabled={deletingId === post.id}>Edit</button>
                      <button type="button" className="admin-icon-danger" aria-label={`Delete ${post.Title}`} onClick={() => handleDelete(post)} disabled={deletingId === post.id}>
                        <Trash2 size={16} />
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </div>
  );
}
