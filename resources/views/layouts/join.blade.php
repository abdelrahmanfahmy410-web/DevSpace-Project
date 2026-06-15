{{-- resources/views/auth/join.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="join-page">
    <div class="join-header">
        <p class="join-eyebrow">New to DevSpace?</p>
        <h1 class="join-title">How do you want to contribute?</h1>
        <p class="join-subtitle">Choose your role — you can always expand later.</p>
    </div>

    <div class="join-cards">

        {{-- Mentor Card --}}
        <a href="{{ route('mentor.register') }}" class="join-card join-card--mentor">
            <div class="join-card__icon">
                <i class="fas fa-chalkboard-user"></i>
            </div>
            <div class="join-card__badge">Guide & Teach</div>
            <h2 class="join-card__title">Join as a Mentor</h2>
            <p class="join-card__desc">
                Share your expertise with developers building their first real products.
                Review projects, give feedback, and open doors.
            </p>
            <ul class="join-card__perks">
                <li><i class="fas fa-check"></i> Mentor active developer projects</li>
                <li><i class="fas fa-check"></i> Build your mentorship profile</li>
                <li><i class="fas fa-check"></i> Connect with ambitious builders</li>
            </ul>
            <div class="join-card__cta">
                Get started as a Mentor <i class="fas fa-arrow-right"></i>
            </div>
        </a>

        {{-- Investor Card --}}
        <a href="{{ route('investor.register') }}" class="join-card join-card--investor">
            <div class="join-card__icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="join-card__badge">Fund & Discover</div>
            <h2 class="join-card__title">Join as an Investor</h2>
            <p class="join-card__desc">
                Discover early-stage developer projects before they go to market.
                Wishlist, track, and reach out to teams you believe in.
            </p>
            <ul class="join-card__perks">
                <li><i class="fas fa-check"></i> Browse curated developer projects</li>
                <li><i class="fas fa-check"></i> Wishlist and track opportunities</li>
                <li><i class="fas fa-check"></i> Connect directly with Project founders</li>
            </ul>
            <div class="join-card__cta">
                Get started as an Investor <i class="fas fa-arrow-right"></i>
            </div>
        </a>

    </div>

    <p class="join-footer-note">
        Already have an account? <a href="{{ route('login') }}">Sign in</a>
        &nbsp;·&nbsp;
        Want to build instead? <a href="/developer/register">Join as a Developer</a>
    </p>
</div>
@endsection

@push('styles')
<style>
/* ── Page Shell ─────────────────────────────────────────── */
.join-page {
    min-height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 64px 24px 80px;
    gap: 0;
}

/* ── Header ─────────────────────────────────────────────── */
.join-header {
    text-align: center;
    margin-bottom: 48px;
}

.join-eyebrow {
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--color-primary);
    margin: 0 0 12px;
}

.join-title {
    font-size: clamp(1.8rem, 4vw, 2.6rem);
    font-weight: 700;
    color: var(--color-text, #0f172a);
    margin: 0 0 12px;
    line-height: 1.15;
}

.join-subtitle {
    font-size: 1rem;
    color: var(--color-text-muted, #64748b);
    margin: 0;
}

/* ── Cards Grid ─────────────────────────────────────────── */
.join-cards {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
    width: 100%;
    max-width: 820px;
}

/* ── Card Base ──────────────────────────────────────────── */
.join-card {
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 16px;
    padding: 36px 32px 32px;
    border-radius: var(--radius-lg, 16px);
    border: 1.5px solid var(--color-border, #e2e8f0);
    background: var(--color-surface, #ffffff);
    text-decoration: none;
    color: inherit;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    overflow: hidden;
}

.join-card::before {
    content: '';
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 0.25s ease;
    border-radius: inherit;
}

.join-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.08);
}

/* Mentor accent */
.join-card--mentor:hover {
    border-color: var(--color-primary);
}
.join-card--mentor::before {
    background: linear-gradient(135deg, color-mix(in srgb, var(--color-primary) 6%, transparent), transparent 60%);
}
.join-card--mentor:hover::before { opacity: 1; }
.join-card--mentor .join-card__icon { color: var(--color-primary); }
.join-card--mentor .join-card__badge { background: color-mix(in srgb, var(--color-primary) 12%, transparent); color: var(--color-primary); }
.join-card--mentor .join-card__cta { color: var(--color-primary); }
.join-card--mentor .join-card__perks i { color: var(--color-primary); }

/* Investor accent — use a distinct warm amber/gold to differentiate */
.join-card--investor:hover {
    border-color: #d97706;
}
.join-card--investor::before {
    background: linear-gradient(135deg, rgba(217,119,6,0.06), transparent 60%);
}
.join-card--investor:hover::before { opacity: 1; }
.join-card--investor .join-card__icon { color: #d97706; }
.join-card--investor .join-card__badge { background: rgba(217,119,6,0.1); color: #b45309; }
.join-card--investor .join-card__cta { color: #d97706; }
.join-card--investor .join-card__perks i { color: #d97706; }

/* ── Card Inner Elements ────────────────────────────────── */
.join-card__icon {
    font-size: 1.75rem;
    line-height: 1;
}

.join-card__badge {
    display: inline-flex;
    align-self: flex-start;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 999px;
}

.join-card__title {
    font-size: 1.35rem;
    font-weight: 700;
    color: var(--color-text, #0f172a);
    margin: 0;
    line-height: 1.2;
}

.join-card__desc {
    font-size: 0.9rem;
    color: var(--color-text-muted, #64748b);
    line-height: 1.6;
    margin: 0;
}

.join-card__perks {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
    flex: 1;
}

.join-card__perks li {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
    color: var(--color-text, #0f172a);
}

.join-card__perks i {
    font-size: 0.7rem;
    flex-shrink: 0;
}

.join-card__cta {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-top: 4px;
    transition: gap 0.2s ease;
}

.join-card:hover .join-card__cta {
    gap: 12px;
}

/* ── Footer Note ────────────────────────────────────────── */
.join-footer-note {
    margin-top: 36px;
    font-size: 0.85rem;
    color: var(--color-text-muted, #64748b);
    text-align: center;
}

.join-footer-note a {
    color: var(--color-primary);
    font-weight: 500;
    text-decoration: none;
}

.join-footer-note a:hover {
    text-decoration: underline;
}

/* ── Responsive ─────────────────────────────────────────── */
@media (max-width: 620px) {
    .join-cards {
        grid-template-columns: 1fr;
        max-width: 420px;
    }

    .join-card {
        padding: 28px 24px;
    }
}
</style>
@endpush