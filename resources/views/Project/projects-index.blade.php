@extends('layouts.app')

@section('content')
<style>
    /* ── Local Scoped Reset & Component Styling Override Layout Variables ── */
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

    .devspace-wrapper {
        font-family: 'DM Sans', sans-serif;
        background: var(--bg);
        color: var(--text-primary);
        min-height: 100vh;
    }

    .layout { display: flex; min-height: 100vh; }

    /* ── Filter Sidebar ── */
    .filter-sidebar {
        width: 260px;
        flex-shrink: 0;
        background: var(--surface);
        border-right: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        position: sticky;
        top: 0;
        height: 100vh;
        overflow-y: auto;
    }

    .filter-sidebar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.25rem 1rem;
        border-bottom: 1px solid var(--border);
        flex-shrink: 0;
    }
    .filter-sidebar-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .filter-sidebar-title svg { width: 16px; height: 16px; color: var(--green); }

    .clear-all-btn {
        font-size: 12px;
        font-weight: 500;
        color: var(--red);
        text-decoration: none;
        padding: 3px 8px;
        border-radius: 5px;
        border: 1px solid rgba(192,57,43,0.25);
        background: var(--red-light);
        transition: all var(--transition);
        white-space: nowrap;
    }
    .clear-all-btn:hover { background: #f5c6c2; }

    .filter-section {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--border);
    }
    .filter-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        cursor: pointer;
        user-select: none;
    }
    .filter-section-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--text-muted);
    }
    .filter-section-arrow {
        width: 14px; height: 14px;
        color: var(--text-muted);
        transition: transform var(--transition);
    }
    .filter-section.collapsed .filter-section-arrow {
        transform: rotate(-90deg);
    }
    .filter-section-body { display: flex; flex-direction: column; gap: 4px; }
    .filter-section.collapsed .filter-section-body { display: none; }

    .filter-check-item {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 5px 8px;
        border-radius: var(--radius-sm);
        cursor: pointer;
        transition: background var(--transition);
        user-select: none;
    }
    .filter-check-item:hover { background: var(--bg); }
    .filter-check-item input[type="checkbox"] {
        width: 15px; height: 15px;
        accent-color: var(--green);
        flex-shrink: 0;
        cursor: pointer;
    }
    .filter-check-label {
        font-size: 13.5px;
        color: var(--text-secondary);
        flex: 1;
        line-height: 1.3;
    }
    .filter-check-item:has(input:checked) .filter-check-label {
        color: var(--text-primary);
        font-weight: 500;
    }
    .filter-check-item:has(input:checked) {
        background: var(--green-light);
    }

    .type-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .filter-search {
        display: flex;
        align-items: center;
        gap: 7px;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 5px 10px;
        margin-bottom: 8px;
    }
    .filter-search svg { width: 13px; height: 13px; color: var(--text-muted); flex-shrink: 0; }
    .filter-search input {
        border: none; background: transparent;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px; color: var(--text-primary);
        outline: none; width: 100%;
    }
    .filter-search input::placeholder { color: var(--text-muted); }

    .sidebar-sort-select {
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        padding: 7px 10px;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        background: var(--bg);
        color: var(--text-secondary);
        cursor: pointer;
        width: 100%;
    }

    /* ── Main Layout View Containers ── */
    .main { flex: 1; display: flex; flex-direction: column; overflow-x: hidden; }

    .topbar {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 0 2rem;
        height: 60px;
        display: flex; align-items: center; justify-content: space-between;
        position: sticky; top: 0; z-index: 10;
    }
    .topbar-left { display: flex; align-items: center; gap: 12px; }
    .topbar-title { font-size: 17px; font-weight: 600; color: var(--text-primary); }
    .topbar-right { display: flex; align-items: center; gap: 12px; }

    .active-filters { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
    .active-pill {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 12px; font-weight: 500;
        padding: 3px 8px; border-radius: 20px;
        background: var(--green-light); color: var(--green);
        border: 1px solid rgba(26,122,74,0.2);
    }

    .search-box {
        display: flex; align-items: center; gap: 8px;
        background: var(--bg); border: 1px solid var(--border);
        border-radius: 8px; padding: 6px 12px;
        font-size: 13.5px; color: var(--text-secondary); width: 220px;
    }
    .search-box svg { width: 15px; height: 15px; flex-shrink: 0; color: var(--text-muted); }

    .btn-primary {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--green); color: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: 13.5px; font-weight: 600;
        padding: 7px 16px; border-radius: var(--radius-md);
        border: none; cursor: pointer; text-decoration: none;
        transition: background var(--transition);
    }
    .btn-primary:hover { background: var(--green-mid); }
    .btn-primary svg { width: 15px; height: 15px; }

    .content { padding: 2rem; flex: 1; }

    /* ── Dashboard Metric Cards ── */
    .stats-row {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 14px; margin-bottom: 2rem;
    }
    .stat-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius-lg); padding: 1.1rem 1.25rem;
        box-shadow: var(--shadow-sm);
    }
    .stat-label { font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 6px; }
    .stat-value { font-size: 26px; font-weight: 700; color: var(--text-primary); line-height: 1; margin-bottom: 4px; }
    .stat-sub { font-size: 12px; color: var(--text-secondary); }
    .stat-dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 5px; }

    .sort-bar {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.25rem;
    }
    .results-count { font-size: 13.5px; color: var(--text-secondary); }
    .results-count strong { color: var(--text-primary); font-weight: 600; }

    /* ── Showcase Directory Grid Layout ── */
    .projects-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 18px;
    }

    .project-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius-lg); box-shadow: var(--shadow-sm);
        display: flex; flex-direction: column; overflow: hidden;
        transition: box-shadow var(--transition), transform var(--transition);
    }
    .project-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }

    .card-thumbnail { position: relative; width: 100%; height: 160px; overflow: hidden; flex-shrink: 0; }
    .card-thumbnail img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.35s ease; }
    .project-card:hover .card-thumbnail img { transform: scale(1.05); }

    .type-badge-over {
        position: absolute; top: 10px; left: 12px;
        font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.07em;
        padding: 3px 9px; border-radius: 20px; border: 1px solid;
        backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
    }
    .type-badge-over.web      { background: rgba(232,245,238,0.92); color: var(--green);  border-color: rgba(26,122,74,0.25); }
    .type-badge-over.mobile   { background: rgba(239,246,255,0.92); color: #2563EB;       border-color: rgba(37,99,235,0.25); }
    .type-badge-over.ai       { background: rgba(245,243,255,0.92); color: #7C3AED;       border-color: rgba(124,58,237,0.25); }
    .type-badge-over.security { background: rgba(253,236,234,0.92); color: var(--red);    border-color: rgba(192,57,43,0.25); }
    .type-badge-over.other    { background: rgba(244,247,250,0.92); color: var(--text-secondary); border-color: var(--border-md); }

    .card-accent { height: 4px; background: var(--green); flex-shrink: 0; }
    .card-accent.web      { background: #1A7A4A; }
    .card-accent.mobile   { background: #2563EB; }
    .card-accent.ai       { background: #7C3AED; }
    .card-accent.security { background: #C0392B; }

    .card-body { padding: 1.1rem 1.25rem; flex: 1; }
    .card-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 0.75rem; }

    .type-badge { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.07em; padding: 3px 9px; border-radius: 20px; border: 1px solid; }
    .type-badge.web      { background: var(--green-light); color: var(--green);  border-color: rgba(26,122,74,0.2); }
    .type-badge.mobile   { background: #EFF6FF;            color: #2563EB;       border-color: rgba(37,99,235,0.2); }
    .type-badge.ai       { background: #F5F3FF;            color: #7C3AED;       border-color: rgba(124,58,237,0.2); }
    .type-badge.security { background: var(--red-light);   color: var(--red);    border-color: rgba(192,57,43,0.2); }

    .card-menu-btn { width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 6px; border: none; background: transparent; color: var(--text-muted); cursor: pointer; transition: background var(--transition); }
    .card-menu-btn:hover { background: var(--bg); }
    .card-menu-btn svg { width: 16px; height: 16px; }

    .card-title { font-size: 16px; font-weight: 700; color: var(--text-primary); margin-bottom: 0.4rem; line-height: 1.3; }
    .card-desc { font-size: 13.5px; color: var(--text-secondary); line-height: 1.55; margin-bottom: 1rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

    .tags-group { margin-bottom: 0.6rem; }
    .tags-row { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 5px; }
    .tags-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: var(--text-muted); }
    .tag { font-size: 11.5px; font-weight: 500; padding: 2px 8px; border-radius: 5px; border: 1px solid; }
    .tag.spec  { background: #EFF6FF; color: #2563EB; border-color: rgba(37,99,235,0.18); }
    .tag.skill { background: var(--green-light); color: var(--green); border-color: rgba(26,122,74,0.18); }

    .card-footer { padding: 0.75rem 1.25rem; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; background: rgba(244,247,250,0.5); }
    .footer-links { display: flex; gap: 10px; }
    .link-btn { display: inline-flex; align-items: center; gap: 5px; font-size: 12.5px; font-weight: 500; padding: 4px 10px; border-radius: 6px; border: 1px solid var(--border); background: var(--surface); color: var(--text-secondary); text-decoration: none; transition: all var(--transition); }
    .link-btn:hover { border-color: var(--green); color: var(--green); background: var(--green-light); }
    .link-btn svg { width: 13px; height: 13px; }

    .view-btn { display: inline-flex; align-items: center; gap: 5px; font-size: 12.5px; font-weight: 600; padding: 5px 12px; border-radius: 7px; border: none; background: var(--green-light); color: var(--green); text-decoration: none; cursor: pointer; transition: background var(--transition); }
    .view-btn:hover { background: #d1ead9; }
    .view-btn svg { width: 13px; height: 13px; }

    .empty-state { background: var(--surface); border: 1px dashed var(--border-md); border-radius: var(--radius-lg); padding: 4rem 2rem; text-align: center; }
    .empty-icon { width: 52px; height: 52px; background: var(--green-light); border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1rem; color: var(--green); }
    .empty-icon svg { width: 26px; height: 26px; }
    .empty-title { font-size: 18px; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem; }
    .empty-desc { font-size: 14px; color: var(--text-secondary); max-width: 360px; margin: 0 auto 1.5rem; line-height: 1.6; }

    /* Pagination Engine Formatting Rules */
    .pagination-wrapper { margin-top: 2.5rem; display: flex; justify-content: center; }

    @media (max-width: 1024px) {
        .filter-sidebar { width: 220px; }
        .stats-row { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .filter-sidebar { display: none; }
    }
    @media (max-width: 600px) {
        .content { padding: 1.25rem; }
        .stats-row { grid-template-columns: 1fr; }
        .projects-grid { grid-template-columns: 1fr; }
    }
</style>

@php
    $selectedTypes  = request('type', []);
    $selectedSpecs  = array_map('intval', request('specialization', []));
    $selectedSkills = array_map('intval', request('skill', []));
    $selectedSort   = request('sort', 'newest');
    $hasFilters     = !empty($selectedTypes) || !empty($selectedSpecs) || !empty($selectedSkills);
@endphp

<div class="devspace-wrapper">
    <div class="layout">

        {{-- ── Filter Sidebar Form ── --}}
        <form method="GET" action="{{ route('projects.index') }}" id="filter-form" style="display: contents;">
            <aside class="filter-sidebar">
                <div class="filter-sidebar-header">
                    <div class="filter-sidebar-title">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 6h18M7 12h10M11 18h2"/></svg>
                        Filters
                    </div>
                    @if($hasFilters)
                        <a href="{{ route('projects.index') }}" class="clear-all-btn">Clear all</a>
                    @endif
                </div>

                {{-- Project Type --}}
                <div class="filter-section" id="section-type">
                    <div class="filter-section-header" onclick="toggleSection('section-type')">
                        <span class="filter-section-label">Project Type</span>
                        <svg class="filter-section-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M19 9l-7 7-7-7"/></svg>
                    </div>
                    <div class="filter-section-body">
                        @foreach([
                            'web'      => ['label'=>'Web / Full-stack', 'color'=>'#1A7A4A'],
                            'mobile'   => ['label'=>'Mobile',           'color'=>'#2563EB'],
                            'ai'       => ['label'=>'AI / ML',          'color'=>'#7C3AED'],
                            'security' => ['label'=>'Security',         'color'=>'#C0392B'],
                        ] as $val => $meta)
                            <label class="filter-check-item">
                                <input
                                    type="checkbox"
                                    name="type[]"
                                    value="{{ $val }}"
                                    {{ in_array($val, $selectedTypes) ? 'checked' : '' }}
                                    onchange="this.form.submit()"
                                >
                                <span class="type-dot" style="background:{{ $meta['color'] }}"></span>
                                <span class="filter-check-label">{{ $meta['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Specializations --}}
                <div class="filter-section" id="section-spec">
                    <div class="filter-section-header" onclick="toggleSection('section-spec')">
                        <span class="filter-section-label">
                            Specialization
                            @if(count($selectedSpecs) > 0)
                                <span style="background:var(--green);color:#fff;font-size:10px;padding:1px 6px;border-radius:20px;margin-left:4px;">{{ count($selectedSpecs) }}</span>
                            @endif
                        </span>
                        <svg class="filter-section-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M19 9l-7 7-7-7"/></svg>
                    </div>
                    <div class="filter-section-body">
                        <div class="filter-search">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                            <input type="text" placeholder="Search…" oninput="filterList(this, 'spec-list')">
                        </div>
                        <div id="spec-list">
                            @foreach($specializations as $spec)
                                <label class="filter-check-item">
                                    <input
                                        type="checkbox"
                                        name="specialization[]"
                                        value="{{ $spec->id }}"
                                        {{ in_array($spec->id, $selectedSpecs) ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                    >
                                    <span class="filter-check-label">{{ $spec->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Skills --}}
                <div class="filter-section" id="section-skill">
                    <div class="filter-section-header" onclick="toggleSection('section-skill')">
                        <span class="filter-section-label">
                            Skills
                            @if(count($selectedSkills) > 0)
                                <span style="background:var(--green);color:#fff;font-size:10px;padding:1px 6px;border-radius:20px;margin-left:4px;">{{ count($selectedSkills) }}</span>
                            @endif
                        </span>
                        <svg class="filter-section-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M19 9l-7 7-7-7"/></svg>
                    </div>
                    <div class="filter-section-body">
                        <div class="filter-search">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                            <input type="text" placeholder="Search…" oninput="filterList(this, 'skill-list')">
                        </div>
                        <div id="skill-list">
                            @foreach($skills as $skill)
                                <label class="filter-check-item">
                                    <input
                                        type="checkbox"
                                        name="skill[]"
                                        value="{{ $skill->id }}"
                                        {{ in_array($skill->id, $selectedSkills) ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                    >
                                    <span class="filter-check-label">{{ $skill->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Sort Block Option --}}
                <div class="filter-section" style="border-bottom:none;">
                    <div class="filter-section-label" style="margin-bottom:0.6rem;display:block;">Sort By</div>
                    <select name="sort" class="sidebar-sort-select" onchange="this.form.submit()">
                        <option value="newest" {{ $selectedSort === 'newest' ? 'selected' : '' }}>Newest first</option>
                        <option value="oldest" {{ $selectedSort === 'oldest' ? 'selected' : '' }}>Oldest first</option>
                        <option value="az"     {{ $selectedSort === 'az'     ? 'selected' : '' }}>A → Z</option>
                    </select>
                </div>
            </aside>
        </form>

        {{-- ── Main Showcase Area ── --}}
        <div class="main">
            <header class="topbar">
                <div class="topbar-left">
                    <span class="topbar-title">All Projects</span>
                    @if($hasFilters)
                        <div class="active-filters">
                            @foreach($selectedTypes as $t)
                                <span class="active-pill">{{ ucfirst($t) }}</span>
                            @endforeach
                            @if(count($selectedSpecs) > 0)
                                <span class="active-pill">{{ count($selectedSpecs) }} Spec{{ count($selectedSpecs) > 1 ? 's' : '' }}</span>
                            @endif
                            @if(count($selectedSkills) > 0)
                                <span class="active-pill">{{ count($selectedSkills) }} Skill{{ count($selectedSkills) > 1 ? 's' : '' }}</span>
                            @endif
                        </div>
                    @endif
                </div>
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

            <div class="content">
                {{-- Dynamic Metrics Dashboard Row --}}
                <div class="stats-row">
                    <div class="stat-card">
                        <div class="stat-label">Total Projects</div>
                        <div class="stat-value">{{ $projects->total() }}</div>
                        <div class="stat-sub">
                            <span class="stat-dot" style="background:#1A7A4A"></span>
                            {{ $hasFilters ? 'Filtered results' : 'All time' }}
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Web Projects</div>
                        <div class="stat-value">{{ $projects->getCollection()->where('type','web')->count() }}</div>
                        <div class="stat-sub"><span class="stat-dot" style="background:#1A7A4A"></span>Web / Full-stack</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Mobile</div>
                        <div class="stat-value">{{ $projects->getCollection()->where('type','mobile')->count() }}</div>
                        <div class="stat-sub"><span class="stat-dot" style="background:#2563EB"></span>iOS & Android</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">AI / Other</div>
                        <div class="stat-value">{{ $projects->getCollection()->whereNotIn('type',['web','mobile'])->count() }}</div>
                        <div class="stat-sub"><span class="stat-dot" style="background:#7C3AED"></span>AI · Security · etc.</div>
                    </div>
                </div>

                <div class="sort-bar">
                    <span class="results-count">
                        Showing <strong>{{ $projects->firstItem() ?? 0 }}–{{ $projects->lastItem() ?? 0 }}</strong> of <strong>{{ $projects->total() }}</strong> projects
                    </span>
                </div>

                {{-- Empty Array vs Target Loops --}}
                @if($projects->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                        </div>
                        <div class="empty-title">No projects found</div>
                        <div class="empty-desc">
                            @if($hasFilters)
                                No projects match your current filters. Try adjusting or clearing them.
                            @else
                                Once graduates submit their projects, they'll show up here.
                            @endif
                        </div>
                        @if($hasFilters)
                            <a href="{{ route('projects.index') }}" class="btn-primary">Clear Filters</a>
                        @else
                            <a href="{{ route('projects.create') }}" class="btn-primary">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                                Add First Project
                            </a>
                        @endif
                    </div>
                @else
                    <div class="projects-grid">
                        @foreach($projects as $project)
                            @php $type = strtolower($project->type ?? 'web'); @endphp
                            <div class="project-card">
                                @if($project->media && $project->media->isNotEmpty())
                                    <div class="card-thumbnail">
                                        <img src="{{ asset('storage/' . $project->media->first()->file_path) }}" alt="{{ $project->title }}" loading="lazy">
                                        <span class="type-badge-over {{ $type }}">{{ $project->type }}</span>
                                    </div>
                                @else
                                    <div class="card-accent {{ $type }}"></div>
                                @endif

                                <div class="card-body">
                                    <div class="card-header">
                                        @if(!$project->media || $project->media->isEmpty())
                                            <span class="type-badge {{ $type }}">{{ $project->type }}</span>
                                        @else
                                            <span></span>
                                        @endif
                                        <button class="card-menu-btn" aria-label="Options">
                                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="5" r="1" fill="currentColor"/><circle cx="12" cy="12" r="1" fill="currentColor"/><circle cx="12" cy="19" r="1" fill="currentColor"/></svg>
                                        </button>
                                    </div>
                                    <h2 class="card-title">{{ $project->title }}</h2>
                                    <p class="card-desc">{{ $project->description }}</p>

                                    @if($project->specializations && $project->specializations->isNotEmpty())
                                        <div class="tags-group">
                                            <span class="tags-label">Specializations</span>
                                            <div class="tags-row">
                                                @foreach($project->specializations->take(4) as $spec)
                                                    <span class="tag spec">{{ $spec->name }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination Controls --}}
                    <div class="pagination-wrapper">
                        {{ $projects->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSection(id) {
        document.getElementById(id).classList.toggle('collapsed');
    }

    function filterList(input, listId) {
        let filter = input.value.toLowerCase();
        let container = document.getElementById(listId);
        let items = container.getElementsByClassName('filter-check-item');

        for (let i = 0; i < items.length; i++) {
            let label = items[i].getElementsByClassName('filter-check-label')[0];
            if (label) {
                let txtValue = label.textContent || label.innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    items[i].style.display = "";
                } else {
                    items[i].style.display = "none";
                }
            }
        }
    }
</script>
@endsection