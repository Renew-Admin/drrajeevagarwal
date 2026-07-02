import { useEffect, useRef } from 'react';
import { Bold, Heading2, Heading3, ListOrdered, List, Quote, Link2, Pilcrow, Italic } from 'lucide-react';

function sanitizePlainText(text) {
  return String(text || '')
    .replace(/\r\n/g, '\n')
    .split('\n')
    .map((line) => line.trim())
    .filter(Boolean)
    .map((line) => `<p>${line.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')}</p>`)
    .join('');
}

function normalizeHtml(html) {
  const value = String(html || '').trim();
  if (!value) return '';
  if (/<[a-z][\s\S]*>/i.test(value)) return value;
  return sanitizePlainText(value);
}

export default function RichTextEditor({ id, value, onChange, placeholder = 'Write the article here. Use the toolbar for headings, lists, links and formatted paste.' }) {
  const editorRef = useRef(null);

  useEffect(() => {
    const editor = editorRef.current;
    if (!editor) return;
    const nextValue = value || '';
    if (document.activeElement !== editor && editor.innerHTML !== nextValue) {
      editor.innerHTML = nextValue;
    }
  }, [value]);

  const emit = () => {
    onChange?.(editorRef.current?.innerHTML || '');
  };

  const exec = (command, arg = null) => {
    editorRef.current?.focus();
    document.execCommand(command, false, arg);
    emit();
  };

  const setBlock = (tag) => {
    editorRef.current?.focus();
    document.execCommand('formatBlock', false, tag);
    emit();
  };

  const addLink = () => {
    const url = window.prompt('Enter a link URL', 'https://');
    if (!url) return;
    exec('createLink', url);
  };

  const handlePaste = (event) => {
    event.preventDefault();
    const html = event.clipboardData?.getData('text/html');
    const text = event.clipboardData?.getData('text/plain');
    const fragment = normalizeHtml(html || text);
    document.execCommand('insertHTML', false, fragment || '<p><br></p>');
    emit();
  };

  return (
    <div className="rt-editor">
      <div className="rt-toolbar" role="toolbar" aria-label="Blog content toolbar">
        <button type="button" onClick={() => setBlock('<h2>')} title="Heading 2"><Heading2 size={16} /></button>
        <button type="button" onClick={() => setBlock('<h3>')} title="Heading 3"><Heading3 size={16} /></button>
        <button type="button" onClick={() => setBlock('<p>')} title="Paragraph"><Pilcrow size={16} /></button>
        <span className="rt-sep" />
        <button type="button" onClick={() => exec('bold')} title="Bold"><Bold size={16} /></button>
        <button type="button" onClick={() => exec('italic')} title="Italic"><Italic size={16} /></button>
        <span className="rt-sep" />
        <button type="button" onClick={() => exec('insertUnorderedList')} title="Bulleted list"><List size={16} /></button>
        <button type="button" onClick={() => exec('insertOrderedList')} title="Numbered list"><ListOrdered size={16} /></button>
        <button type="button" onClick={() => setBlock('<blockquote>')} title="Quote"><Quote size={16} /></button>
        <span className="rt-sep" />
        <button type="button" onClick={addLink} title="Insert link"><Link2 size={16} /></button>
      </div>

      <div
        ref={editorRef}
        id={id}
        className="rt-area"
        contentEditable
        suppressContentEditableWarning
        onInput={emit}
        onBlur={emit}
        onPaste={handlePaste}
        data-placeholder={placeholder}
        role="textbox"
        aria-multiline="true"
      />
    </div>
  );
}
