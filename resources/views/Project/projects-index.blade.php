@extends('layouts.app')
@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Directory — DevSpace</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green:      #1A7A4A;
            --green-light:#E8F5EE;
            --green-mid:  #2d9e63;
            --red:        #C0392B;
            --red-light:  #FDECEA;
            --bg:         #F4F7FA;
            --surface:    #FFFFFF;
            --border:     rgba(0,0,0,0.08);
            --border-md:  rgba(0,0,0,0.13);
            --text-primary:   #111827;
            --text-secondary: #6B7280;
            --text-muted:     #9CA3AF;
            --radius-sm:  6px;
            --radius-md:  10px;
            --radius-lg:  14px;
            --shadow-sm:  0 1px 3px rgba(0,0,0,0.07), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md:  0 4px 16px rgba(0,0,0,0.09);
            --transition: 0.18s ease;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text-primary);
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .layout { display: flex; min-height: 100vh; }

        .sidebar {
            width: 240px;
            flex-shrink: 0;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            padding: 0 0 1.5rem;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 1.25rem 1.25rem 1rem;
            border-bottom: 1px solid var(--border);
            margin-bottom: 0.75rem;
            text-decoration: none;
        }
        .sidebar-logo .logo-mark {
            width: 32px; height: 32px;
            background: var(--green);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 16px; letter-spacing: -0.5px;
        }
        .sidebar-logo span { font-weight: 700; font-size: 17px; color: var(--text-primary); }

        .sidebar-section {
            padding: 0 0.75rem;
            margin-bottom: 0.25rem;
        }
        .sidebar-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 0.5rem 0.5rem 0.25rem;
        }
        .nav-item {
            display: flex; align-items: center; gap: 9px;
            padding: 0.55rem 0.75rem;
            border-radius: var(--radius-sm);
            font-size: 14px; font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            transition: background var(--transition), color var(--transition);
            cursor: pointer;
        }
        .nav-item:hover { background: var(--bg); color: var(--text-primary); }
        .nav-item.active { background: var(--green-light); color: var(--green); }
        .nav-item svg { width: 17px; height: 17px; flex-shrink: 0; }

        /* ── Main ── */
        .main { flex: 1; display: flex; flex-direction: column; overflow-x: hidden; }

        /* ── Topbar ── */
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            height: 60px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 10;
        }
        .topbar-title { font-size: 17px; font-weight: 600; color: var(--text-primary); }
        .topbar-right { display: flex; align-items: center; gap: 12px; }

        .search-box {
            display: flex; align-items: center; gap: 8px;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 13.5px;
            color: var(--text-secondary);
            width: 220px;
        }
        .search-box svg { width: 15px; height: 15px; flex-shrink: 0; color: var(--text-muted); }

        .btn-primary {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--green);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px; font-weight: 600;
            padding: 7px 16px;
            border-radius: var(--radius-md);
            border: none; cursor: pointer;
            text-decoration: none;
            transition: background var(--transition);
        }
        .btn-primary:hover { background: var(--green-mid); }
        .btn-primary svg { width: 15px; height: 15px; }

        /* ── Content ── */
        .content { padding: 2rem; flex: 1; }

        /* ── Stats row ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 1.1rem 1.25rem;
            box-shadow: var(--shadow-sm);
        }
        .stat-label { font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 6px; }
        .stat-value { font-size: 26px; font-weight: 700; color: var(--text-primary); line-height: 1; margin-bottom: 4px; }
        .stat-sub { font-size: 12px; color: var(--text-secondary); }
        .stat-dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 5px; }

        /* ── Filter bar ── */
        .filter-bar {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.5rem; gap: 12px; flex-wrap: wrap;
        }
        .filter-tabs { display: flex; gap: 6px; }
        .filter-tab {
            font-size: 13px; font-weight: 500;
            padding: 6px 14px;
            border-radius: 20px;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all var(--transition);
        }
        .filter-tab.active { background: var(--green); color: #fff; border-color: var(--green); }
        .filter-tab:hover:not(.active) { border-color: var(--green); color: var(--green); }

        .sort-select {
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            padding: 6px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--surface);
            color: var(--text-secondary);
            cursor: pointer;
        }

        /* ── Grid ── */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 18px;
        }

        /* ── Project Card ── */
        .project-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            display: flex; flex-direction: column;
            overflow: hidden;
            transition: box-shadow var(--transition), transform var(--transition);
            position: relative;
        }
        .project-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        /* ── Card Thumbnail (when image exists) ── */
        .card-thumbnail {
            position: relative;
            width: 100%;
            height: 160px;
            overflow: hidden;
            flex-shrink: 0;
        }
        .card-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.35s ease;
        }
        .project-card:hover .card-thumbnail img {
            transform: scale(1.05);
        }
        .type-badge-over {
            position: absolute;
            top: 10px;
            left: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            padding: 3px 9px;
            border-radius: 20px;
            border: 1px solid;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        }
        .type-badge-over.web        { background: rgba(232,245,238,0.92); color: var(--green);  border-color: rgba(26,122,74,0.25); }
        .type-badge-over.mobile     { background: rgba(239,246,255,0.92); color: #2563EB;       border-color: rgba(37,99,235,0.25); }
        .type-badge-over.ai         { background: rgba(245,243,255,0.92); color: #7C3AED;       border-color: rgba(124,58,237,0.25); }
        .type-badge-over.security   { background: rgba(253,236,234,0.92); color: var(--red);    border-color: rgba(192,57,43,0.25); }
        /* fallback for any other type */
        .type-badge-over.other      { background: rgba(244,247,250,0.92); color: var(--text-secondary); border-color: var(--border-md); }

        /* ── Card Accent (no-image fallback) ── */
        .card-accent {
            height: 4px;
            background: var(--green);
            flex-shrink: 0;
        }
        .card-accent.web      { background: #1A7A4A; }
        .card-accent.mobile   { background: #2563EB; }
        .card-accent.ai       { background: #7C3AED; }
        .card-accent.security { background: #C0392B; }

        .card-body { padding: 1.1rem 1.25rem; flex: 1; }

        .card-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 0.75rem; }

        /* badge inside card-header (no-image cards only) */
        .type-badge {
            font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.07em;
            padding: 3px 9px;
            border-radius: 20px;
            border: 1px solid;
        }
        .type-badge.web      { background: var(--green-light); color: var(--green);  border-color: rgba(26,122,74,0.2); }
        .type-badge.mobile   { background: #EFF6FF;            color: #2563EB;       border-color: rgba(37,99,235,0.2); }
        .type-badge.ai       { background: #F5F3FF;            color: #7C3AED;       border-color: rgba(124,58,237,0.2); }
        .type-badge.security { background: var(--red-light);   color: var(--red);    border-color: rgba(192,57,43,0.2); }

        .card-menu-btn {
            width: 28px; height: 28px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 6px; border: none; background: transparent;
            color: var(--text-muted); cursor: pointer;
            transition: background var(--transition);
        }
        .card-menu-btn:hover { background: var(--bg); color: var(--text-secondary); }
        .card-menu-btn svg { width: 16px; height: 16px; }

        .card-title {
            font-size: 16px; font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.4rem;
            line-height: 1.3;
        }
        .card-desc {
            font-size: 13.5px;
            color: var(--text-secondary);
            line-height: 1.55;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .tags-group { margin-bottom: 0.6rem; }
        .tags-row { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 5px; }
        .tags-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: var(--text-muted); }
        .tag {
            font-size: 11.5px; font-weight: 500;
            padding: 2px 8px;
            border-radius: 5px;
            border: 1px solid;
        }
        .tag.spec  { background: #EFF6FF;         color: #2563EB;     border-color: rgba(37,99,235,0.18); }
        .tag.skill { background: var(--green-light); color: var(--green); border-color: rgba(26,122,74,0.18); }

        /* ── Card Footer ── */
        .card-footer {
            padding: 0.75rem 1.25rem;
            border-top: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            background: rgba(244,247,250,0.5);
        }
        .footer-links { display: flex; gap: 10px; }
        .link-btn {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 12.5px; font-weight: 500;
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text-secondary);
            text-decoration: none;
            transition: all var(--transition);
        }
        .link-btn:hover { border-color: var(--green); color: var(--green); background: var(--green-light); }
        .link-btn svg { width: 13px; height: 13px; }

        .view-btn {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 12.5px; font-weight: 600;
            padding: 5px 12px;
            border-radius: 7px;
            border: none;
            background: var(--green-light);
            color: var(--green);
            text-decoration: none;
            cursor: pointer;
            transition: background var(--transition);
        }
        .view-btn:hover { background: #d1ead9; }
        .view-btn svg { width: 13px; height: 13px; }

        /* ── Empty state ── */
        .empty-state {
            background: var(--surface);
            border: 1px dashed var(--border-md);
            border-radius: var(--radius-lg);
            padding: 4rem 2rem;
            text-align: center;
        }
        .empty-icon {
            width: 52px; height: 52px;
            background: var(--green-light);
            border-radius: 14px;
            display: inline-flex; align-items: center; justify-content: center;
            margin-bottom: 1rem;
            color: var(--green);
        }
        .empty-icon svg { width: 26px; height: 26px; }
        .empty-title { font-size: 18px; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem; }
        .empty-desc { font-size: 14px; color: var(--text-secondary); max-width: 360px; margin: 0 auto 1.5rem; line-height: 1.6; }

        /* ── Pagination ── */
        .pagination {
            display: flex; align-items: center; justify-content: center; gap: 6px;
            margin-top: 2.5rem;
        }
        .page-btn {
            width: 34px; height: 34px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--surface);
            font-size: 13.5px; font-weight: 500;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all var(--transition);
            text-decoration: none;
        }
        .page-btn:hover { border-color: var(--green); color: var(--green); }
        .page-btn.active { background: var(--green); color: #fff; border-color: var(--green); }
        .page-btn svg { width: 15px; height: 15px; }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .sidebar { display: none; }
            .stats-row { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 600px) {
            .content { padding: 1.25rem; }
            .stats-row { grid-template-columns: 1fr; }
            .projects-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="layout">

   

    {{-- ── Main ── --}}
    <div class="main">

        {{-- Topbar --}}
        <header class="topbar">
            <span class="topbar-title">Project Directory</span>
            <div class="topbar-right">
                <div class="search-box">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    Search projects…
                </div>
                <a href="{{ route('projects.create') }}" class="btn-primary">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                    New Project
                </a>
            </div>
        </header>

        {{-- Content --}}
        <div class="content">

            {{-- Stats --}}
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-label">Total Projects</div>
                    <div class="stat-value">{{ $projects->count() }}</div>
                    <div class="stat-sub"><span class="stat-dot" style="background:#1A7A4A"></span>All time</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Web Projects</div>
                    <div class="stat-value">{{ $projects->where('type','web')->count() }}</div>
                    <div class="stat-sub"><span class="stat-dot" style="background:#1A7A4A"></span>Web / Full-stack</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Mobile</div>
                    <div class="stat-value">{{ $projects->where('type','mobile')->count() }}</div>
                    <div class="stat-sub"><span class="stat-dot" style="background:#2563EB"></span>iOS & Android</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">AI / Other</div>
                    <div class="stat-value">{{ $projects->whereNotIn('type',['web','mobile'])->count() }}</div>
                    <div class="stat-sub"><span class="stat-dot" style="background:#7C3AED"></span>AI · Security · etc.</div>
                </div>
            </div>

           <form method="GET" action="{{ route('projects.index') }}" id="filter-form">
    <div class="filter-bar">

        {{-- Type tabs --}}
        <div class="filter-tabs">
            @foreach([''=>'All','web'=>'Web','mobile'=>'Mobile','ai'=>'AI','security'=>'Security'] as $val => $label)
                <button
                    type="submit"
                    name="type"
                    value="{{ $val }}"
                    class="filter-tab {{ request('type', '') === $val ? 'active' : '' }}"
                >{{ $label }}</button>
            @endforeach
        </div>

        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">

            {{-- Specialization --}}
            <select name="specialization" class="sort-select" onchange="this.form.submit()">
                <option value="">All Specializations</option>
                @foreach($specializations as $spec)
                    <option value="{{ $spec->id }}" {{ request('specialization') == $spec->id ? 'selected' : '' }}>
                        {{ $spec->name }}
                    </option>
                @endforeach
            </select>

            {{-- Skills --}}
            <select name="skill" class="sort-select" onchange="this.form.submit()">
                <option value="">All Skills</option>
                @foreach($skills as $skill)
                    <option value="{{ $skill->id }}" {{ request('skill') == $skill->id ? 'selected' : '' }}>
                        {{ $skill->name }}
                    </option>
                @endforeach
            </select>

            {{-- Sort --}}
            <select name="sort" class="sort-select" onchange="this.form.submit()">
                <option value="newest" {{ request('sort','newest') === 'newest' ? 'selected' : '' }}>Newest first</option>
                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest first</option>
                <option value="az"     {{ request('sort') === 'az'     ? 'selected' : '' }}>A → Z</option>
            </select>

        </div>
    </div>
</form>

            {{-- Grid --}}
            @if($projects->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>
                    <div class="empty-title">No projects yet</div>
                    <div class="empty-desc">Once graduates submit their projects, they'll show up here ready to be discovered by investors and mentors.</div>
                    <a href="{{ route('projects.create') }}" class="btn-primary">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                        Add First Project
                    </a>
                </div>
            @else
                <div class="projects-grid">
                    @foreach($projects as $project)
                        @php $type = strtolower($project->type ?? 'web'); @endphp
                        <div class="project-card">

                            {{-- ── Top of card: thumbnail OR accent bar ── --}}
                            @if($project->media->isNotEmpty())
                                <div class="card-thumbnail">
                                    <img
                                        src="{{ asset('storage/' . $project->media->first()->file_path) }}"
                                        alt="{{ $project->title }}"
                                        loading="lazy"
                                    >
                                    <span class="type-badge-over {{ $type }}">{{ $project->type }}</span>
                                </div>
                            @else
                                <div class="card-accent {{ $type }}"></div>
                            @endif

                            <div class="card-body">
                                <div class="card-header">
                                    {{-- badge only shown when there is NO thumbnail (thumbnail already has its own badge) --}}
                                    @if($project->media->isEmpty())
                                        <span class="type-badge {{ $type }}">{{ $project->type }}</span>
                                    @else
                                        <span></span>{{-- spacer so the menu button stays right-aligned --}}
                                    @endif
                                    <button class="card-menu-btn" aria-label="Options">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="5" r="1" fill="currentColor"/><circle cx="12" cy="12" r="1" fill="currentColor"/><circle cx="12" cy="19" r="1" fill="currentColor"/></svg>
                                    </button>
                                </div>

                                <h2 class="card-title">{{ $project->title }}</h2>
                                <p class="card-desc">{{ $project->description }}</p>

                                @if($project->specializations->isNotEmpty())
                                    <div class="tags-group">
                                        <span class="tags-label">Specializations</span>
                                        <div class="tags-row">
                                            @foreach($project->specializations->take(4) as $spec)
                                                <span class="tag spec">{{ $spec->name }}</span>
                                            @endforeach
                                            @if($project->specializations->count() > 4)
                                                <span class="tag spec">+{{ $project->specializations->count() - 4 }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if($project->skills->isNotEmpty())
                                    <div class="tags-group">
                                        <span class="tags-label">Skills</span>
                                        <div class="tags-row">
                                            @foreach($project->skills->take(4) as $skill)
                                                <span class="tag skill">{{ $skill->name }}</span>
                                            @endforeach
                                            @if($project->skills->count() > 4)
                                                <span class="tag skill">+{{ $project->skills->count() - 4 }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="card-footer">
                                <div class="footer-links">
                                    @if($project->repository_link)
                                        <a href="{{ $project->repository_link }}" target="_blank" class="link-btn">
                                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                                            Repo
                                        </a>
                                    @endif
                                    @if($project->live_demo_link)
                                        <a href="{{ $project->live_demo_link }}" target="_blank" class="link-btn">
                                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                            Live
                                        </a>
                                    @endif
                                </div>
                                <a href="{{ route('projects.show', $project->id) }}" class="view-btn">
                                    View
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if(method_exists($projects, 'hasPages') && $projects->hasPages())
                    <div class="pagination">
                        {{-- Previous --}}
                        @if($projects->onFirstPage())
                            <span class="page-btn" style="opacity:0.4; cursor:default;">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
                            </span>
                        @else
                            <a href="{{ $projects->previousPageUrl() }}" class="page-btn">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
                            </a>
                        @endif

                        @foreach($projects->getUrlRange(1, $projects->lastPage()) as $page => $url)
                            <a href="{{ $url }}" class="page-btn {{ $page == $projects->currentPage() ? 'active' : '' }}">
                                {{ $page }}
                            </a>
                        @endforeach

                        {{-- Next --}}
                        @if($projects->hasMorePages())
                            <a href="{{ $projects->nextPageUrl() }}" class="page-btn">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
                            </a>
                        @else
                            <span class="page-btn" style="opacity:0.4; cursor:default;">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
                            </span>
                        @endif
                    </div>
                @endif
            @endif

        </div>{{-- /content --}}
    </div>{{-- /main --}}
</div>{{-- /layout --}}

</body>
</html>
@endsection