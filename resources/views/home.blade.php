@extends('layouts.app')

@section('title', 'DevSpace — Where Developers Take Flight')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
    <div class="home-page">

        {{-- ══════════════════════════
     HERO
══════════════════════════ --}}
        <section class="site-hero">
            <div class="container">
                <div class="hero-inner">

                    <div class="hero-text">
                        <div class="hero-eyebrow">DevSpace Platform</div>
                        <h1 class="hero-heading">
                            Where Tech Ideas
                            <em>Take Flight</em>
                        </h1>
                        <p class="hero-sub">
                            A platform built for Egyptian developer-founders — connecting developers, mentors, and investors
                            to turn ideas into real products.
                        </p>
                        <div class="hero-actions">
                            <a href="{{ route('developer.register') }}" class="btn btn-primary"
                                style="padding:12px 28px; font-size:14px;">Join the Space 🚀</a>
                            <a href="{{ route('projects.index') }}" class="btn btn-ghost"
                                style="padding:12px 28px; font-size:14px;">Browse Projects</a>
                        </div>
                        <div class="hero-stats">
                            @foreach ($stats as $stat)
                                @php $raw = trim(str_replace('+', '', $stat['value'])); @endphp
                                @if (is_numeric($raw) && (int) $raw > 0)
                                    <div class="hero-stat">
                                        <div class="hero-stat-value">{{ $stat['value'] }}</div>
                                        <div class="hero-stat-label">{{ $stat['label'] }}</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="hero-visual">
                        <div class="hero-illustration">
                            <svg width="100%" viewBox="0 0 680 490" role="img" aria-hidden="true">
                                <defs>
                                    <marker id="arrow" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="6"
                                        markerHeight="6" orient="auto-start-reverse">
                                        <path d="M2 1L8 5L2 9" fill="none" stroke="context-stroke" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </marker>
                                </defs>
                                <style>
                                    .bg-shape {
                                        fill: #E3F3EA;
                                    }

                                    @media (prefers-color-scheme: dark) {
                                        .bg-shape {
                                            fill: #15301F;
                                        }
                                    }
                                </style>

                                <circle class="bg-shape" cx="420" cy="260" r="210" />
                                <line x1="60" y1="440" x2="620" y2="440" stroke="#CBD5E1"
                                    stroke-width="2" />

                                <g transform="translate(95,95) rotate(-15)">
                                    <path d="M-13 -32 C-13 -48 13 -48 13 -32 L13 22 L-13 22 Z"
                                        fill="var(--color-primary, #1A7A4A)" />
                                    <circle cx="0" cy="-10" r="6" fill="#FFFFFF" />
                                    <path d="M-13 5 L-26 22 L-13 22 Z" fill="#5FAE82" />
                                    <path d="M13 5 L26 22 L13 22 Z" fill="#5FAE82" />
                                    <path d="M-8 22 L8 22 L0 40 Z" fill="#F4A261" />
                                </g>

                                <rect x="110" y="135" width="110" height="165" rx="18" fill="#CBD5E1" />

                                <rect x="140" y="290" width="32" height="130" rx="10" fill="#1E293B" />
                                <rect x="185" y="290" width="32" height="130" rx="10" fill="#1E293B" />
                                <ellipse cx="156" cy="428" rx="24" ry="12" fill="#0F172A" />
                                <ellipse cx="201" cy="428" rx="24" ry="12" fill="#0F172A" />

                                <rect x="275" y="388" width="14" height="50" fill="#B5895E" />
                                <rect x="550" y="388" width="14" height="50" fill="#B5895E" />
                                <rect x="260" y="370" width="320" height="18" rx="4" fill="#D9B48F" />
                                <rect x="265" y="358" width="90" height="14" rx="2" fill="#4B5563" />
                                <rect x="372" y="348" width="18" height="20" rx="3" fill="#FFFFFF"
                                    stroke="#CBD5E1" stroke-width="1.5" />
                                <path d="M390 353 a6 6 0 0 1 0 12" stroke="#CBD5E1" stroke-width="2" fill="none" />

                                <rect x="130" y="180" width="90" height="110" rx="24"
                                    fill="var(--color-primary, #1A7A4A)" />

                                <path d="M205 200 Q260 230 290 358" stroke="var(--color-primary, #1A7A4A)"
                                    stroke-width="20" fill="none" stroke-linecap="round" />
                                <path d="M205 220 Q280 260 325 358" stroke="var(--color-primary, #1A7A4A)"
                                    stroke-width="20" fill="none" stroke-linecap="round" />
                                <circle cx="290" cy="360" r="12" fill="#F4B183" />
                                <circle cx="325" cy="360" r="12" fill="#F4B183" />

                                <circle cx="175" cy="150" r="30" fill="#F4B183" />
                                <path d="M145 148 C145 122 205 122 205 148 L205 132 C205 110 145 110 145 132 Z"
                                    fill="#3D2B1F" />

                                <rect x="400" y="350" width="50" height="10" rx="3" fill="#6B7280" />
                                <rect x="415" y="320" width="10" height="32" fill="#6B7280" />
                                <rect x="330" y="140" width="190" height="180" rx="10" fill="#1F2937" />
                                <rect x="342" y="152" width="166" height="140" rx="4" fill="#0F172A" />
                                <rect x="350" y="160" width="140" height="10" rx="2"
                                    fill="var(--color-primary, #1A7A4A)" />
                                <rect x="350" y="180" width="100" height="8" rx="2" fill="#475569" />
                                <rect x="350" y="195" width="120" height="8" rx="2" fill="#475569" />
                                <rect x="420" y="240" width="14" height="42"
                                    fill="var(--color-primary, #1A7A4A)" />
                                <rect x="440" y="225" width="14" height="57" fill="#5FAE82" />
                                <rect x="460" y="250" width="14" height="32"
                                    fill="var(--color-primary, #1A7A4A)" />
                                <rect x="480" y="232" width="14" height="50" fill="#5FAE82" />

                                <rect x="535" y="350" width="30" height="20" fill="#B5651D" rx="2" />
                                <ellipse cx="550" cy="328" rx="9" ry="24" fill="#2F9E5B"
                                    transform="rotate(-10 550 328)" />
                                <ellipse cx="538" cy="332" rx="8" ry="20" fill="#1A7A4A"
                                    transform="rotate(-30 538 332)" />
                                <ellipse cx="562" cy="332" rx="8" ry="20" fill="#5FAE82"
                                    transform="rotate(25 562 332)" />

                                <circle cx="580" cy="90" r="26" fill="#FFFFFF" stroke="#E2E8F0"
                                    stroke-width="1.5" />
                                <path d="M568 91 L577 100 L594 79" stroke="var(--color-primary, #1A7A4A)" stroke-width="5"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>

                </div>
            </div>

            <svg class="hero-wave" viewBox="0 0 1440 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,32 C360,0 1080,48 1440,16 L1440,40 L0,40 Z" fill="#F4F7FA" />
            </svg>
        </section>





        {{-- ══════════════════════════
     HOW IT WORKS
══════════════════════════ --}}
        <section class="section section--light">
            <div class="container">
                <div style="text-align:center; margin-bottom:var(--space-7);">
                    <div class="section-eyebrow">The Process</div>
                    <h2 class="section-title" style="margin-bottom:var(--space-2);">From Idea to Launch</h2>
                    <p style="color:var(--color-muted); max-width:520px; margin:0 auto; font-size:var(--font-size-body);">
                        Four simple steps to take your startup from concept to connected with the right mentors and
                        investors.</p>
                </div>
                <div class="steps-grid">
                    <div class="step-card">
                        <div class="step-connector"></div>
                        <div class="step-number"></div>
                        <div class="step-icon">🚀</div>
                        <div class="step-title">Submit Your Project</div>
                        <p class="step-desc">Upload your startup idea, prototype, or MVP with a problem statement,
                            solution, and team details.</p>
                    </div>
                    <div class="step-card">
                        <div class="step-connector"></div>
                        <div class="step-number"></div>
                        <div class="step-icon">🎯</div>
                        <div class="step-title">Get Matched</div>
                        <p class="step-desc">Our system connects you with mentors who have deep expertise in your tech
                            field and sector.</p>
                    </div>
                    <div class="step-card">
                        <div class="step-connector"></div>
                        <div class="step-number"></div>
                        <div class="step-icon">🌱</div>
                        <div class="step-title">Grow & Iterate</div>
                        <p class="step-desc">Work with mentors on product development, go-to-market strategy, and investor
                            readiness as you grow your project.</p>
                    </div>
                    <div class="step-card">
                        <div class="step-number"></div>
                        <div class="step-icon">🤝</div>
                        <div class="step-title">Connect to Investors</div>
                        <p class="step-desc">Gain visibility to active investors on the platform and get direct
                            introductions to those interested in your stage and sector.</p>
                    </div>
                </div>
            </div>
        </section>


        {{-- ══════════════════════════
     ABOUT US
══════════════════════════ --}}
        <section class="section about-section" id="about">
            <div class="container">

                {{-- Header --}}
                <div style="text-align:center; margin-bottom:var(--space-7);">
                    <div class="section-eyebrow">About Us</div>
                    <h2 class="section-title" style="margin-bottom:var(--space-3);">
                        Built for Egyptian Builders
                    </h2>
                    <p style="color:var(--color-muted); max-width:560px; margin:0 auto; font-size:var(--font-size-body);">
                        DevSpace was born from a simple observation: Egyptian developer graduates
                        build impressive things — but too often in isolation, without the right
                        connections to grow them into real products.
                    </p>
                </div>

                {{-- Mission / Vision split --}}
                <div class="about-mv-grid">
                    <div class="about-mv-card">
                        <div class="about-mv-icon">🎯</div>
                        <h3 class="about-mv-title">Our Mission</h3>
                        <p class="about-mv-desc">
                            To close the gap between technical talent and opportunity in Egypt —
                            by giving developer-founders a structured path from idea to funded product,
                            with mentors and investors alongside them every step.
                        </p>
                    </div>
                    <div class="about-mv-divider"></div>
                    <div class="about-mv-card">
                        <div class="about-mv-icon">🌍</div>
                        <h3 class="about-mv-title">Our Vision</h3>
                        <p class="about-mv-desc">
                            A thriving Egyptian tech ecosystem where the best ideas don't stay on
                            a laptop — they reach the market, find funding, and scale regionally.
                        </p>
                    </div>
                </div>

                {{-- The Problem we solve --}}
                <div class="about-problem">
                    <div class="about-problem__label">The Problem We Solve</div>
                    <div class="about-problem__grid">
                        <div class="about-problem__item">
                            <span class="about-problem__icon">🔒</span>
                            <div>
                                <strong>Talented developers working in isolation</strong>
                                <p>Great ideas stay in GitHub repos because there's no structured way to get feedback,
                                    guidance, or visibility.</p>
                            </div>
                        </div>
                        <div class="about-problem__item">
                            <span class="about-problem__icon">🔍</span>
                            <div>
                                <strong>Investors can't find quality local deal flow</strong>
                                <p>Early-stage Egyptian tech projects are scattered across platforms with no single, vetted
                                    source of discovery.</p>
                            </div>
                        </div>
                        <div class="about-problem__item">
                            <span class="about-problem__icon">🤷</span>
                            <div>
                                <strong>Mentors have no easy channel to give back</strong>
                                <p>Experienced engineers and founders want to help — but there's no lightweight, structured
                                    way to connect with founders who need them.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Values --}}
                <div class="about-values">
                    <div class="section-eyebrow" style="text-align:center; margin-bottom:var(--space-5);">What We Stand
                        For</div>
                    <div class="about-values__grid">
                        <div class="about-value-card">
                            <div class="about-value-card__bar"></div>
                            <div class="about-value-card__title">Builders First</div>
                            <p class="about-value-card__desc">Every feature we build starts with one question: does this
                                help a developer-founder move faster?</p>
                        </div>
                        <div class="about-value-card">
                            <div class="about-value-card__bar"></div>
                            <div class="about-value-card__title">Trust Through Transparency</div>
                            <p class="about-value-card__desc">Projects, mentors, and investors are real and verified. No
                                noise, no anonymity, no shortcuts.</p>
                        </div>
                        <div class="about-value-card">
                            <div class="about-value-card__bar"></div>
                            <div class="about-value-card__title">Local Context, Global Standards</div>
                            <p class="about-value-card__desc">We're built for Egypt — but the quality bar for products,
                                mentorship, and investment is global.</p>
                        </div>
                        <div class="about-value-card">
                            <div class="about-value-card__bar"></div>
                            <div class="about-value-card__title">Community Over Competition</div>
                            <p class="about-value-card__desc">The ecosystem grows when developers help each other. We
                                reward collaboration, not gatekeeping.</p>
                        </div>
                    </div>
                </div>

                {{-- CTA --}}
                <div class="about-cta">
                    <p class="about-cta__text">Ready to be part of building the Egyptian tech ecosystem?</p>
                    <div class="hero-actions" style="justify-content:center;">
                        <a href="{{ route('developer.register') }}" class="btn btn-primary"
                            style="padding:12px 28px; font-size:14px;">
                            Join DevSpace 🚀
                        </a>

                    </div>
                </div>

            </div>
        </section>
        {{-- ══════════════════════════
     FEATURED PROJECTS
══════════════════════════ --}}
        <section class="section section--light">
            <div class="container">
                <div class="section-header">
                    <div>
                        <div class="section-eyebrow">Spotlight</div>
                        <h2 class="section-title-left">Featured Projects</h2>
                    </div>
                    <a href="{{ route('projects.index') }}" class="btn btn-outline">View All Projects →</a>
                </div>

                <div class="filter-row">
                    <button class="btn-pill is-active" data-filter="all">All Specializations</button>
                    @foreach ($specializations as $spec)
                        <button class="btn-pill" data-filter="{{ $spec->id }}">{{ $spec->name }}</button>
                    @endforeach
                </div>

                @if ($featuredProjects->isEmpty())
                    <div style="text-align:center; padding:var(--space-8) 0; color:var(--color-muted);">
                        <p>No projects yet — <a href="{{ route('projects.create') }}">be the first to submit one</a>.</p>
                    </div>
                @else
                    <div class="project-grid">
                        @foreach ($featuredProjects as $project)
                            @php $type = strtolower($project['type'] ?? 'web'); @endphp

                            <div class="project-card" data-stage="{{ $project['badge'] }}"
                                data-specs="{{ implode(',', $project['specializationIds']) }}">

                                {{-- Thumbnail or accent bar --}}
                                @if (!empty($project['image']))
                                    <div class="card-thumbnail">
                                        <img src="{{ asset('storage/' . $project['image']) }}"
                                            alt="{{ $project['title'] }}" loading="lazy">
                                        <span class="type-badge-over {{ $type }}">{{ $project['stage'] }}</span>
                                    </div>
                                @else
                                    <div class="card-accent {{ $type }}"></div>
                                @endif

                                <div class="card-body">
                                    <div class="card-header">
                                        @if (empty($project['image']))
                                            <span class="type-badge {{ $type }}">{{ $project['stage'] }}</span>
                                        @else
                                            <span></span>
                                        @endif
                                        {{-- No edit/delete on public home page --}}
                                        <span></span>
                                    </div>

                                    <a href="{{ route('projects.show', ['project' => $project['id']]) }}"
                                        class="card-title" style="text-decoration:none; display:block; color:inherit;">
                                        {{ $project['title'] }}
                                    </a>
                                    <p class="card-desc">{{ Str::limit($project['tagline'], 120) }}</p>

                                    @if (!empty($project['sectors']))
                                        <div class="tags-group">
                                            <span class="tags-label">Sectors</span>
                                            <div class="tags-row">

                                                @if (!empty($project['sectors']))
                                                    <div class="tags-group">
                                                        <span class="tags-label">Sectors</span>
                                                        <div class="tags-row">
                                                            @foreach ($project['sectors'] as $sector)
                                                                <span class="tag spec">{{ $sector['name'] }}</span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-footer">
                                    <div class="project-team">
                                        @foreach ($project['team'] as $avatar)
                                            <div class="team-avatar">{{ $avatar }}</div>
                                        @endforeach
                                        <span class="team-count">{{ $project['members'] }} members</span>
                                    </div>
                                    <a href="{{ route('projects.show', ['project' => $project['id']]) }}"
                                        class="view-btn">
                                        View
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"
                                            style="width:13px;height:13px;">
                                            <path d="M5 12h14M12 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>


        {{-- ══════════════════════════
     IMPACT STATS
══════════════════════════ --}}
        <section class="section impact-section">
            <div class="container">
                <div class="impact-grid">
                    @foreach ($stats as $stat)
                        <div>
                            <div class="impact-value">{{ $stat['value'] }}</div>
                            <div class="impact-label">{{ $stat['label'] }}</div>

                        </div>
                    @endforeach
                </div>
            </div>
        </section>


        {{-- MEET OUR MENTORS --}}
        <section class="section section--light">
            <div class="container">
                <div class="section-header">
                    <div>
                        <div class="section-eyebrow">Expert Network</div>
                        <h2 class="section-title-left">Meet Our Mentors</h2>
                    </div>
                    <a href="{{ route('mentor.register') }}" class="btn btn-outline">Become a Mentor →</a>
                </div>

                @if ($mentors->isEmpty())
                    <p style="color:var(--color-muted); text-align:center; padding:var(--space-6) 0;">
                        No mentors yet. <a href="{{ route('mentor.register') }}">Be the first to join as a mentor.</a>
                    </p>
                @else
                    <div class="mentors-grid">
                        @foreach ($mentors as $mentor)
                            <div class="mentor-card">
                                <div class="mentor-avatar"
                                    @if ($mentor['style']) style="{{ $mentor['style'] }}" @endif>
                                    {{ $mentor['initials'] }}
                                </div>
                                <div class="mentor-name">{{ $mentor['name'] }}</div>
                                <div class="mentor-title">{{ $mentor['title'] }}</div>

                                @if (!empty($mentor['specializations']))
                                    <div class="mentor-skills">
                                        @foreach ($mentor['specializations'] as $spec)
                                            <span class="badge badge--grey">{{ $spec }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </section>


        {{-- ══════════════════════════
     EARLY ACCESS BETA
══════════════════════════ --}}
        <section class="section">
            <div class="container">
                <div style="text-align:center; margin-bottom:var(--space-7);">
                    <div class="section-eyebrow">Early Access</div>
                    <h2 class="section-title" style="margin-bottom:var(--space-3);">Be Part of What's Being Built</h2>
                    <p style="color:var(--color-muted); max-width:560px; margin:0 auto; font-size:var(--font-size-body);">
                        DevSpace is actively growing. Register now to be among the first developers, mentors, and investors
                        on the platform.
                    </p>
                </div>
                <div class="testimonials-grid">

                    <div class="testimonial-card"
                        style="text-align:center; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:var(--space-3);">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="var(--color-primary)" style="width:40px;height:40px;" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                        </svg>
                        <div class="testimonial-name" style="font-size:var(--font-size-h3);">Submit Your Project</div>
                        <p style="font-size:var(--font-size-small); color:var(--color-muted); line-height:1.6;">
                            Create a profile for your startup idea or prototype — visibility to mentors and investors from
                            day one.
                        </p>
                        <a href="{{ route('projects.create') }}" class="btn btn-outline" style="margin-top:auto;">Get
                            Started →</a>
                    </div>

                    <div class="testimonial-card"
                        style="text-align:center; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:var(--space-3);">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="var(--color-primary)" style="width:40px;height:40px;" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>
                        <div class="testimonial-name" style="font-size:var(--font-size-h3);">Join as a Mentor</div>
                        <p style="font-size:var(--font-size-small); color:var(--color-muted); line-height:1.6;">
                            Share your expertise with developer-founders and help shape the next wave of Egyptian tech
                            startups.
                        </p>
                        <a href="{{ route('mentor.register') }}" class="btn btn-outline"
                            style="margin-top:auto;">Register
                            as Mentor →</a>
                    </div>

                    <div class="testimonial-card"
                        style="text-align:center; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:var(--space-3);">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="var(--color-primary)" style="width:40px;height:40px;" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                        </svg>
                        <div class="testimonial-name" style="font-size:var(--font-size-h3);">Invest in Talent</div>
                        <p style="font-size:var(--font-size-small); color:var(--color-muted); line-height:1.6;">
                            Discover technically-vetted projects from top Egyptian developer graduates — filtered by stage
                            and sector.
                        </p>
                        <a href="/investor/register" class="btn btn-outline" style="margin-top:auto;">Join as Investor
                            →</a>
                    </div>

                </div>
            </div>
        </section>


        {{-- ══════════════════════════
     JOIN US
══════════════════════════ --}}
        {{-- JOIN US --}}
        <section class="section join-section" id="join">
            <div class="container">
                <div style="text-align:center; margin-bottom:var(--space-7);">
                    <div class="section-eyebrow">Join the Community</div>
                    <h2 class="section-title" style="margin-bottom:var(--space-2);">
                        One Platform. Every Role in the Tech Ecosystem.
                    </h2>
                    <p style="color:var(--color-muted); max-width:560px; margin:0 auto; font-size:var(--font-size-body);">
                        Whether you're shipping your first project, looking for funding, or offering expertise — DevSpace
                        connects the people who build with the people who grow them.
                    </p>
                </div>

                <div class="join-grid">

                    {{-- DEVELOPER — primary, large --}}
                    <div class="join-card join-card--dev">
                        <div class="join-card__deco"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="rgba(255,255,255,0.9)" style="width:48px;height:48px;margin-bottom:var(--space-3);"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                        </svg>
                        <div class="join-card__eyebrow">For Developers</div>
                        <h3 class="join-card__title" style="color:#ffffff;">Showcase Your Projects. Get Noticed.</h3>
                        <p class="join-card__desc">
                            Submit your project, connect with mentors who've been where you're going, and get in front of
                            investors actively looking for developer-led startups.
                        </p>

                        <div class="join-card__outcomes">
                            <div class="join-outcome">
                                <div class="join-outcome__val">{{ $stats[2]['value'] }}</div>
                                <div class="join-outcome__lbl">Investors browsing projects</div>
                            </div>
                            <div class="join-outcome">
                                <div class="join-outcome__val">{{ $stats[1]['value'] }}</div>
                                <div class="join-outcome__lbl">Mentors available to connect</div>
                            </div>
                        </div>

                        <a href="{{ route('developer.register') }}" class="btn join-card__btn-dev"
                            style="padding:12px 28px; font-size:14px; margin-top:auto;">
                            Join as Developer →
                        </a>
                    </div>

                    {{-- INVESTOR + MENTOR stacked on the right --}}
                    <div class="join-stack">

                        <div class="join-card join-card--investor" style="flex:1;">
                            <div class="join-card__deco"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="rgba(255,255,255,0.9)"
                                style="width:36px;height:36px;margin-bottom:var(--space-2);" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                            </svg>
                            <div class="join-card__eyebrow">For Investors</div>
                            <h3 class="join-card__title" style="font-size:1.1rem;color:#f0fdf4;">
                                Find Developer-Led Projects Worth Backing
                            </h3>
                            <p class="join-card__desc" style="font-size:13px;">
                                Browse a curated pipeline of real projects built by developers and recent graduates —
                                filterable by stage, specialization, and technology stack.
                            </p>
                            <a href="/investor/register" class="btn join-card__btn-inv"
                                style="padding:10px 22px; font-size:13px; margin-top:auto;">
                                Join as Investor →
                            </a>
                        </div>

                        <div class="join-card join-card--mentor" style="flex:1;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="var(--color-primary)"
                                style="width:36px;height:36px;margin-bottom:var(--space-2);" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                            </svg>
                            <div class="join-card__eyebrow">For Mentors</div>
                            <h3 class="join-card__title" style="font-size:1.1rem;">
                                Guide Developers Who Are Building Real Things
                            </h3>
                            <p class="join-card__desc" style="font-size:13px;">
                                Offer your expertise to developers actively working on projects. Set your own availability
                                and areas of focus.
                            </p>
                            <a href="{{ route('mentor.register') }}" class="btn join-card__btn-men"
                                style="padding:10px 22px; font-size:13px; margin-top:auto;">
                                Join as Mentor →
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        {{-- ══════════════════════════
     CTA STRIP
══════════════════════════ --}}
        <section class="section cta-section">
            <div class="container">
                <div class="cta-box">
                    <div class="cta-text">
                        <h2 class="cta-heading">Ready to build the next big thing?</h2>
                        <p class="cta-sub">Join a growing community of developers shipping real projects. {{ $stats[0]['value'] }} projects live and counting, submit yours NOW.</p>
                    </div>
                    <div class="cta-actions">
                        <a href="{{-- route('about') --}}" class="btn btn-ghost" style="padding:12px 24px;">Learn More</a>
                        <a href="{{ route('projects.create') }}" class="btn"
                            style="background:var(--color-white); color:var(--color-primary); border-color:var(--color-white); padding:12px 24px; font-weight:700;">Submit
                            Your Project →</a>
                    </div>
                </div>
            </div>
        </section>

    </div>{{-- .home-page --}}
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.btn-pill').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.btn-pill').forEach(b => b.classList.remove('is-active'));
                this.classList.add('is-active');

                const filter = this.dataset.filter;

                document.querySelectorAll('.project-card').forEach(card => {
                    if (filter === 'all') {
                        card.style.display = '';
                        return;
                    }
                    const specs = (card.dataset.specs ?? '').split(',').filter(Boolean);
                    card.style.display = specs.includes(filter) ? '' : 'none';
                });
            });
        });
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.project-card, .step-card, .mentor-card, .testimonial-card, .join-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            observer.observe(el);
        });
    </script>
@endpush
