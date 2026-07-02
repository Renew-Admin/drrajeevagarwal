import React from 'react';
import { Link } from 'react-router-dom';
import { ArrowLeft, Home, SearchX, Stethoscope } from 'lucide-react';

export default function NotFound() {
  return (
    <div className="not-found-page">
      <section className="not-found-hero">
        <div className="ra-container not-found-layout">
          <div className="not-found-copy">
            <span className="not-found-code"><SearchX size={18} /> 404</span>
            <h1>This page does not exist. Bold choice by the URL.</h1>
            <p>
              The page may have moved, retired quietly, or never had an appointment here in the first place.
              Try heading back to the main care pathways.
            </p>
            <div className="not-found-actions">
              <Link className="ra-btn ra-btn-primary" to="/">
                <Home size={18} /> Go Home
              </Link>
              <Link className="ra-btn ra-btn-soft" to="/all-services">
                <Stethoscope size={18} /> View Services
              </Link>
            </div>
            <Link className="not-found-back" to="/blog">
              <ArrowLeft size={16} /> Browse articles instead
            </Link>
          </div>
          <div className="not-found-card" aria-hidden="true">
            <div className="not-found-card-top">
              <span />
              <span />
              <span />
            </div>
            <div className="not-found-card-body">
              <strong>Page diagnosis</strong>
              <div className="not-found-line long" />
              <div className="not-found-line" />
              <div className="not-found-status">Not found, but recoverable.</div>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}
