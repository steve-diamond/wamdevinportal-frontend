import React, { useState, useEffect, useRef } from 'react';
import '../styles/dashboard.css';

const STEPS = [
  {
    icon: '🎉',
    title: 'Welcome to WAMDIN Portal!',
    body: 'This portal keeps you connected with the alumni community — browse events, resources, members, and messages all in one place.',
  },
  {
    icon: '🔭',
    title: 'Navigate with the Sidebar',
    body: 'Use the left sidebar to switch between Dashboard, Alumni Directory, Events, Messages and Resources. Collapse it with the ☰ button in the top bar.',
  },
  {
    icon: '📅',
    title: 'Stay Up-to-Date with Events',
    body: 'Register for upcoming events, view calendars, and get reminders — all from the Events section.',
  },
  {
    icon: '🔔',
    title: 'Notifications & Alerts',
    body: 'Toast notifications appear in the top-right for actions. Check the Notifications tab on your Dashboard for your full activity feed.',
  },
  {
    icon: '⬇',
    title: 'Export & Reports',
    body: 'Admins can export tables as CSV or print PDF reports directly from any management panel using the Export buttons.',
  },
  {
    icon: '♿',
    title: 'Accessibility First',
    body: 'Use Tab / Shift+Tab to navigate, Enter/Space to activate buttons. A skip-to-content link is available for screen readers. Press Escape to close this guide.',
  },
];

export default function OnboardingGuide({ onComplete, onSkip }) {
  const [step, setStep] = useState(0);
  const closeRef = useRef(null);
  const total = STEPS.length;
  const current = STEPS[step];

  // Trap focus and handle keyboard
  useEffect(() => {
    const handleKey = (e) => {
      if (e.key === 'Escape') onSkip?.();
      if (e.key === 'ArrowRight' || e.key === 'ArrowDown') next();
      if (e.key === 'ArrowLeft'  || e.key === 'ArrowUp')   prev();
    };
    document.addEventListener('keydown', handleKey);
    return () => document.removeEventListener('keydown', handleKey);
  });

  // Focus the close button on mount for keyboard users
  useEffect(() => { closeRef.current?.focus(); }, []);

  const next = () => { if (step < total - 1) setStep(s => s + 1); else onComplete?.(); };
  const prev = () => { if (step > 0) setStep(s => s - 1); };

  return (
    <div className="onboarding-overlay" role="dialog" aria-modal="true" aria-labelledby="ob-title" aria-describedby="ob-body">
      <div className="onboarding-card">
        {/* Header */}
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: 20 }}>
          <div style={{ fontSize: 36 }} aria-hidden="true">{current.icon}</div>
          <button
            ref={closeRef}
            onClick={onSkip}
            aria-label="Skip guide"
            style={{
              background: 'none', border: 'none', cursor: 'pointer',
              color: 'var(--text-muted)', fontSize: 22, lineHeight: 1, padding: 4,
            }}
          >
            ×
          </button>
        </div>

        {/* Step indicators */}
        <div className="onboarding-step-indicator" aria-label={`Step ${step + 1} of ${total}`}>
          {STEPS.map((_, i) => (
            <button
              key={i}
              className={`onboarding-dot${i === step ? ' active' : ''}`}
              onClick={() => setStep(i)}
              aria-label={`Go to step ${i + 1}`}
              aria-current={i === step ? 'step' : undefined}
              style={{ border: 'none', cursor: 'pointer', padding: 0 }}
            />
          ))}
        </div>

        {/* Content */}
        <h2 id="ob-title" style={{ fontSize: 19, fontWeight: 800, color: 'var(--text-primary)', marginBottom: 10 }}>
          {current.title}
        </h2>
        <p id="ob-body" style={{ fontSize: 14, color: 'var(--text-secondary)', lineHeight: 1.65, marginBottom: 24 }}>
          {current.body}
        </p>

        {/* Navigation */}
        <div style={{ display: 'flex', gap: 10, alignItems: 'center' }}>
          <button
            className="btn btn-ghost btn-sm"
            onClick={onSkip}
            style={{ marginRight: 'auto' }}
          >
            Skip
          </button>
          {step > 0 && (
            <button className="btn btn-secondary btn-sm" onClick={prev} aria-label="Previous step">
              ← Back
            </button>
          )}
          <button
            className="btn btn-primary btn-sm"
            onClick={next}
            aria-label={step === total - 1 ? 'Finish guide' : 'Next step'}
          >
            {step === total - 1 ? '🎉 Get Started' : 'Next →'}
          </button>
        </div>

        {/* Keyboard hint */}
        <p style={{ fontSize: 11, color: 'var(--text-muted)', marginTop: 14, textAlign: 'center' }}>
          Use ← → arrow keys to navigate · Esc to close
        </p>
      </div>
    </div>
  );
}
