@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

{{-- Mobile sidebar overlay --}}
<div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>

<aside class="sidebar" id="sidebar" role="navigation" aria-label="Main navigation">

    <div class="sidebar-brand">
        <div class="brand-icon">DS</div>
        <span class="brand-name">DevSpace</span>
    </div>

    <nav class="sidebar-menu" aria-label="Workspace navigation">

        <p class="menu-title" role="heading" aria-level="3">MY WORKSPACE</p>
        <a href="#" class="menu-link active" aria-current="page">
            <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>
        <a href="#" class="menu-link">
            <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7h18M3 12h18M3 17h12"/></svg>
            My Projects
        </a>
        <a href="#" class="menu-link">
            <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            Feedback Queue
        </a>
        <a href="#" class="menu-link">
            <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            Progress Tracking
        </a>

        <p class="menu-title" role="heading" aria-level="3">DISCOVER</p>
        <a href="#" class="menu-link">
            <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Browse Projects
        </a>
        <a href="#" class="menu-link">
            <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Find Teams
        </a>

        <p class="menu-title" role="heading" aria-level="3">ACCOUNT</p>
        <a href="#" class="menu-link">
            <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Profile & Settings
        </a>

    </nav>

    <div class="sidebar-footer">
        <div class="avatar avatar--sm" aria-hidden="true">
            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
        </div>
        <div class="sidebar-user">
            <strong>{{ auth()->user()->name }}</strong>
            <span class="sidebar-user-role">
                {{ ucfirst(auth()->user()->roles->first()->name ?? 'Member') }}
            </span>
        </div>
    </div>

</aside>

<div class="main-content">

    <header class="topbar">
        <button class="hamburger" id="hamburgerBtn" aria-label="Toggle navigation" aria-expanded="false" aria-controls="sidebar">
            <span></span><span></span><span></span>
        </button>

        <h1 class="topbar-title">Dashboard</h1>

        <div class="topbar-actions">
            <div class="search-wrap" role="search">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <label for="globalSearch" class="sr-only">Search</label>
                <input type="text" id="globalSearch" placeholder="Search..." class="search-box">
            </div>
        </div>
    </header>

    <div class="page-body">

        <section class="profile-banner" aria-label="Profile overview">
            <div class="avatar avatar--lg profile-avatar" aria-hidden="true">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
            </div>

            <div class="profile-info">
                <h2 class="profile-name">{{ auth()->user()->name }}</h2>

                <div class="role-list" aria-label="Roles">
                    @forelse(auth()->user()->roles as $role)
                        <span class="role-badge">{{ ucfirst($role->name) }}</span>
                    @empty
                        <span class="role-badge">User</span>
                    @endforelse
                </div>
            </div>

            <div class="banner-actions">
                <a href="#" class="btn btn-outline">Edit Profile</a>
                <a href="#" class="btn btn-primary">Browse Projects</a>
            </div>
        </section>

        <section class="stats-grid" aria-label="Stats overview">

            <div class="stat-card">
                <div class="stat-icon stat-icon--blue" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7h18M3 12h18M3 17h12"/></svg>
                </div>
                <div class="stat-body">
                    <h3 class="stat-number">{{ $stats['my_projects'] ?? 0 }}</h3>
                    <p class="stat-label">My Projects</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-icon--yellow" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <div class="stat-body">
                    <h3 class="stat-number">{{ $stats['pending_messages'] ?? 0 }}</h3>
                    <p class="stat-label">Pending Messages</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-icon--green" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/></svg>
                </div>
                <div class="stat-body">
                    <h3 class="stat-number">{{ $stats['followers'] ?? 0 }}</h3>
                    <p class="stat-label">Followers</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-icon--purple" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
                <div class="stat-body">
                    <h3 class="stat-number">{{ $stats['following'] ?? 0 }}</h3>
                    <p class="stat-label">Following</p>
                </div>
            </div>

        </section>

        <section class="content-grid">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Projects</h3>
                    <a href="{{ route('projects.index') }}" class="card-link">View All</a>
                </div>

                @forelse($projects as $project)
                    <div class="project-item">
                        <div class="project-left">
                            <div class="project-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                            </div>
                            <div class="project-content">
                                <h4 class="project-name">{{ $project->name }}</h4>
                                <p class="project-desc">{{ Str::limit($project->description, 120) }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M3 7h18M3 12h18M3 17h12"/></svg>
                        <p>No active projects yet.</p>
                        <a href="#" class="btn btn-primary btn--sm">Start a Project</a>
                    </div>
                @endforelse
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Expertise</h3>
                </div>

                <div class="skills">
                    @forelse($profile->expertise ?? [] as $skill)
                        <span class="skill">{{ $skill }}</span>
                    @empty
                        <div class="empty-state empty-state--sm">
                            <p>No skills added yet.</p>
                            <a href="#" class="btn btn-outline btn--sm">Add Skills</a>
                        </div>
                    @endforelse
                </div>
            </div>

        </section>

    </div>
</div>

<script>
    const hamburger = document.getElementById('hamburgerBtn');
    const sidebar   = document.getElementById('sidebar');
    const overlay   = document.getElementById('sidebarOverlay');

    function openSidebar() {
        sidebar.classList.add('is-open');
        overlay.classList.add('is-visible');
        hamburger.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-visible');
        hamburger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    hamburger.addEventListener('click', () => {
        sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar();
    });

    overlay.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeSidebar();
    });
</script>

@endsection