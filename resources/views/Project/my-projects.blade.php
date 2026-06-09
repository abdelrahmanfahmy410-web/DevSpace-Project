<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Projects — DevSpace</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green:      #1A7A4A;
            --green-light:#E8F5EE;
            --green-mid:  #2d9e63;
            --red:        #C0392B;
            --red-light:  #FDECEA;
            --bg:          #F4F7FA;
            --surface:    #FFFFFF;
            --border:      rgba(0,0,0,0.08);
            --border-md:  rgba(0,0,0,0.13);
            --text-primary:   #111827;
            --text-secondary: #6B7280;
            --text-muted:      #9CA3AF;
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
            grid-template-columns: repeat(3, 1fr);
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

        /* ── Modern Filter Bar ── */
        .filter-wrapper-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 1.25rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
        }
        .filter-main-row {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .filter-search-container {
            position: relative;
            flex: 1;
            min-width: 240px;
        }
        .filter-search-container svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: var(--text-muted);
        }
        .filter-input-search {
            width: 100%;
            padding: 8px 12px 8px 36px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            border: 1px solid var(--border-md);
            border-radius: 8px;
            background: var(--bg);
            color: var(--text-primary);
            outline: none;
            transition: border-color var(--transition);
        }
        .filter-input-search:focus {
            border-color: var(--green);
        }
        .filter-select {
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 500;
            padding: 8px 12px;
            border: 1px solid var(--border-md);
            border-radius: 8px;
            background: var(--surface);
            color: var(--text-secondary);
            cursor: pointer;
            min-width: 150px;
            outline: none;
        }
        .filter-select:focus {
            border-color: var(--green);
        }
        .btn-filter-submit {
            background: var(--green);
            color: #fff;
            border: none;
            padding: 8px 16px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: background var(--transition);
        }
        .btn-filter-submit:hover { background: var(--green-mid); }
        
        .btn-filter-clear {
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border-md);
            padding: 8px 14px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            transition: all var(--transition);
        }
        .btn-filter-clear:hover { background: var(--bg); color: var(--text-primary); }

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

        /* ── Card Thumbnail ── */
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
        .type-badge-over.web      { background: rgba(232,245,238,0.92); color: var(--green);  border-color: rgba(26,122,74,0.25); }
        .type-badge-over.mobile   { background: rgba(239,246,255,0.92); color: #2563EB;       border-color: rgba(37,99,235,0.25); }
        .type-badge-over.ai        { background: rgba(245,243,255,0.92); color: #7C3AED;       border-color: rgba(124,58,237,0.25); }
        .type-badge-over.security { background: rgba(253,236,234,0.92); color: var(--red);    border-color: rgba(192,57,43,0.25); }
        .type-badge-over.other    { background: rgba(244,247,250,0.92); color: var(--text-secondary); border-color: var(--border-md); }

        /* ── Card Accent ── */
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

        .action-buttons { display: flex; gap: 8px; }
        .btn-edit, .btn-delete {
            border: none; background: transparent; padding: 4px 8px; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; transition: background var(--transition);
        }
        .btn-edit { color: #D97706; }
        .btn-edit:hover { background: #FEF3C7; }
        .btn-delete { color: var(--red); }
        .btn-delete:hover { background: var(--red-light); }
        .btn-edit svg, .btn-delete svg { width: 16px; height: 16px; }

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
            grid-column: 1 / -1;
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
            text-decoration: none;
            cursor: pointer;
            transition: all var(--transition);
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

    {{-- ── Sidebar ── --}}
    <aside class="sidebar">
        <a href="/" class="sidebar-logo">
            <div class="logo-mark">D</div>
            <span>DevSpace</span>
        </a>

        <div class="sidebar-section">
            <div class="sidebar-label">Main</div>
            <a href="#" class="nav-item">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a href="{{ route('projects.index') }}" class="nav-item">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M3 7h18M3 12h18M3 17h18"/><rect x="2" y="5" width="20" height="14" rx="2"/></svg>
                All Projects
            </a>
            <a href="{{ route('projects.my') }}" class="nav-item active">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2zM12 11v4M10 13h4"/></svg>
                My Projects
            </a>
            <a href="#" class="nav-item">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                Graduates
            </a>
            <a href="#" class="nav-item">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Investors
            </a>
            <a href="#" class="nav-item">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                Mentors
            </a>
        </div>

        <div class="sidebar-section" style="margin-top: auto;">
            <a href="#" class="nav-item">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                Settings
            </a>
        </div>
    </aside>

    {{-- ── Main ── --}}
    <div class="main">

        {{-- Topbar --}}
        <header class="topbar">
            <span class="topbar-title">My Projects Dashboard</span>
            <div class="topbar-right">
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
                    <div class="stat-label">MY TOTAL PROJECTS</div>
                    <div class="stat-value">{{ $totalProjectsCount ?? 0 }}</div>
                    <div class="stat-sub"><span class="stat-dot" style="background:#9CA3AF"></span>All time</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-label">MY ASSIGNED PROJECTS</div>
                    <div class="stat-value">{{ $assignedProjectsCount ?? 0 }}</div>
                    <div class="stat-sub"><span class="stat-dot" style="background:#1A7A4A"></span>Assigned to me</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-label">MY CREATED PROJECTS</div>
                    <div class="stat-value">{{ $createdProjectsCount ?? 0 }}</div>
                    <div class="stat-sub"><span class="stat-dot" style="background:#2563EB"></span>Created by me</div>
                </div>
            </div>

            {{-- شريط الفلترة العلوي المتكامل --}}
            <div class="filter-wrapper-card">
                <form action="{{ url()->current() }}" method="GET" class="filter-main-row">
                    
                    {{-- 1. حقل البحث الكلي --}}
                    <div class="filter-search-container">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        <input type="text" name="search" class="filter-input-search" placeholder="Search by project name or keywords..." value="{{ request('search') }}">
                    </div>

                    {{-- 2. فلتر النوع (Project Type) --}}
                    <select name="type" class="filter-select">
                        <option value="">All Types</option>
                        <option value="web" {{ request('type') == 'web' ? 'selected' : '' }}>Web Application</option>
                        <option value="mobile" {{ request('type') == 'mobile' ? 'selected' : '' }}>Mobile App</option>
                        <option value="ai" {{ request('type') == 'ai' ? 'selected' : '' }}>AI / ML</option>
                        <option value="security" {{ request('type') == 'security' ? 'selected' : '' }}>Cybersecurity</option>
                    </select>

                    <button type="submit" class="btn-filter-submit">Filter</button>
                    @if(request()->has('search') || request()->has('type'))
                        <a href="{{ url()->current() }}" class="btn-filter-clear">Clear</a>
                    @endif
                </form>
            </div>

            {{-- Grid Projects --}}
            <div class="projects-grid">
                @forelse($projects as $project)
                    <div class="project-card">
                        {{-- Thumbnail & Badge Over --}}
                        <div class="card-thumbnail">
                            <img src="{{ $project->image_url ?? 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=600' }}" alt="{{ $project->title }}">
                            <span class="type-badge-over {{ $project->type ?? 'other' }}">{{ $project->type ?? 'Project' }}</span>
                        </div>

                        {{-- Dynamic Top Accent Line --}}
                        <div class="card-accent {{ $project->type ?? 'web' }}"></div>

                        <div class="card-body">
                            <div class="card-header">
                                <h3 class="card-title">{{ $project->title }}</h3>
                                
                                {{-- Actions --}}
                                <div class="action-buttons">
                                    <a href="{{ route('projects.edit', $project->id) }}" class="btn-edit" title="Edit">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this project?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" title="Delete">
                                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <p class="card-desc">{{ $project->description }}</p>

                            {{-- Tags --}}
                            @if(!empty($project->tags))
                                <div class="tags-group">
                                    <div class="tags-row">
                                        @foreach($project->tags as $tag)
                                            <span class="tag skill">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Card Footer --}}
                        <div class="card-footer">
                            <div class="footer-links">
                                @if($project->github_url)
                                    <a href="{{ $project->github_url }}" target="_blank" class="link-btn" title="GitHub Repository">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                                        Code
                                    </a>
                                @endif
                                @if($project->demo_url)
                                    <a href="{{ $project->demo_url }}" target="_blank" class="link-btn" title="Live Preview">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M10 6H6a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        Live
                                    </a>
                                @endif
                            </div>
                            <a href="{{ route('projects.show', $project->id) }}" class="view-btn">
                                View Details
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    {{-- Empty State Card --}}
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path d="M20 13V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7m16 0a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2m16 0v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5M9 11l3 3 3-3"/></svg>
                        </div>
                        <h4 class="empty-title">No projects found</h4>
                        <p class="empty-desc">You haven't uploaded or been assigned any projects that match your current filters.</p>
                        <a href="{{ route('projects.create') }}" class="btn-primary">Create Your First Project</a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination Row --}}
            @if($projects->hasPages())
                <div class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($projects->onFirstPage())
                        <span class="page-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M15 19l-7-7 7-7"/></svg></span>
                    @else
                        <a href="{{ $projects->previousPageUrl() }}" class="page-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M15 19l-7-7 7-7"/></svg></a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="page-btn">{{ $element }}</span>
                        @endif
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $projects->currentPage())
                                    <span class="page-btn active">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($projects->hasMorePages())
                        <a href="{{ $projects->nextPageUrl() }}" class="page-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M9 5l7 7-7 7"/></svg></a>
                    @else
                        <span class="page-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M9 5l7 7-7 7"/></svg></span>
                    @endif
                </div>
            @endif

        </div>
    </div>
</div>

</body>
</html>