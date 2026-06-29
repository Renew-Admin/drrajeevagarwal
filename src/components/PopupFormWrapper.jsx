import React, { useEffect } from 'react';

export default function PopupFormWrapper({ isOpen, onClose, title, children }) {
  // Prevent background scrolling when open
  useEffect(() => {
    if (isOpen) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = 'unset';
    }
    return () => {
      document.body.style.overflow = 'unset';
    };
  }, [isOpen]);

  if (!isOpen) return null;

  return (
    <div style={styles.overlay} onClick={onClose}>
      <div style={styles.modal} onClick={e => e.stopPropagation()}>
        <div style={styles.header}>
          <h3 style={styles.title}>{title || 'Book an Appointment'}</h3>
          <button style={styles.closeBtn} onClick={onClose} aria-label="Close modal">
            &times;
          </button>
        </div>
        <div style={styles.body}>
          {children}
        </div>
      </div>
    </div>
  );
}

const styles = {
  overlay: {
    position: 'fixed',
    top: 0,
    left: 0,
    right: 0,
    bottom: 0,
    backgroundColor: 'rgba(22, 27, 66, 0.6)',
    backdropFilter: 'blur(4px)',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
    zIndex: 9999,
    animation: 'fadeIn 0.25s ease-out'
  },
  modal: {
    backgroundColor: 'var(--white)',
    borderRadius: 'var(--radius-lg)',
    width: '100%',
    maxWidth: '540px',
    boxShadow: 'var(--shadow-lg)',
    border: '1px solid var(--border)',
    overflow: 'hidden',
    position: 'relative',
    margin: '16px',
    animation: 'slideUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)'
  },
  header: {
    padding: '20px 24px',
    borderBottom: '1px solid var(--border)',
    display: 'flex',
    justifyContent: 'space-between',
    alignItems: 'center',
    background: 'var(--off-white)'
  },
  title: {
    fontFamily: 'var(--font-head)',
    fontSize: '20px',
    fontWeight: '800',
    color: 'var(--navy)'
  },
  closeBtn: {
    background: 'none',
    border: 'none',
    fontSize: '28px',
    lineHeight: '1',
    cursor: 'pointer',
    color: 'var(--text-soft)',
    transition: 'color 0.2s',
    '&:hover': {
      color: 'var(--primary)'
    }
  },
  body: {
    padding: '24px',
    maxHeight: 'calc(100vh - 120px)',
    overflowY: 'auto'
  }
};

// Add raw CSS keyframe animations for modals
if (typeof document !== 'undefined') {
  const styleSheet = document.createElement("style");
  styleSheet.innerText = `
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    @keyframes slideUp {
      from { transform: translateY(30px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
  `;
  document.head.appendChild(styleSheet);
}
