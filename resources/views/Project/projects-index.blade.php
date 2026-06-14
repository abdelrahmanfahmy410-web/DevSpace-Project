@extends('layouts.app')

@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/projects-index.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@php
    $selectedTypes  = request('type', []);
    $selectedSpecs  = array_map('intval', request('specialization', []));
    $selectedSkills = array_map('intval', request('skill', []));
    $selectedSort   = request('sort', 'newest');
    $searchQuery    = request('search', '');
    $hasFilters     = !empty($selectedTypes) || !empty($selectedSpecs) || !empty($selectedSkills) || !empty($searchQuery);
@endphp

<div class="devspace-wrapper">
    <div class="pi-layout">

        {{-- ── Filter Sidebar ── --}}
        <aside class="filter-sidebar">
            <form method="GET" action="{{ route('projects.index') }}" id="filter-form" class="filter-form-inner">
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
                                <input type="checkbox" name="type[]" value="{{ $val }}" {{ in_array($val, $selectedTypes) ? 'checked' : '' }} onchange="this.form.submit()">
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
                                    <input type="checkbox" name="specialization[]" value="{{ $spec->id }}" {{ in_array($spec->id, $selectedSpecs) ? 'checked' : '' }} onchange="this.form.submit()">
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
                                    <input type="checkbox" name="skill[]" value="{{ $skill->id }}" {{ in_array($skill->id, $selectedSkills) ? 'checked' : '' }} onchange="this.form.submit()">
                                    <span class="filter-check-label">{{ $skill->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

            </form>
        </aside>

        {{-- ── Main Content Area ── --}}
        <section class="pi-main-content">
            <header class="pi-topbar">
                <div class="pi-topbar-left">
                    <h1 class="pi-topbar-title">All Projects</h1>
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
                <div class="pi-topbar-right">
                    <div class="pi-search-box">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        <input type="text" name="search" form="filter-form" placeholder="Search projects…" value="{{ request('search') }}" onkeypress="if(event.key === 'Enter') { event.preventDefault(); document.getElementById('filter-form').submit(); }">
                    </div>
                    <select name="sort" form="filter-form" class="topbar-sort-select" onchange="this.form.submit()">
                        <option value="newest" {{ $selectedSort === 'newest' ? 'selected' : '' }}>Newest first</option>
                        <option value="oldest" {{ $selectedSort === 'oldest' ? 'selected' : '' }}>Oldest first</option>
                        <option value="az"     {{ $selectedSort === 'az'     ? 'selected' : '' }}>A → Z</option>
                    </select>
                    <a href="{{ route('projects.create') }}" class="pi-btn-primary">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                        New Project
                    </a>
                </div>
            </header>

            <div class="pi-content-body">
                {{-- Dynamic Metrics Dashboard Row --}}
                <div class="pi-stats-row">
                    <div class="pi-stat-card">
                        <div class="pi-stat-label">Total Projects</div>
                        <div class="pi-stat-value">{{ $projects->total() }}</div>
                        <div class="pi-stat-sub">
                            <span class="pi-stat-dot" style="background:#1A7A4A"></span>
                            {{ $hasFilters ? 'Filtered results' : 'All time' }}
                        </div>
                    </div>
                    <div class="pi-stat-card">
                        <div class="pi-stat-label">Web Projects</div>
                        <div class="pi-stat-value">{{ $projects->getCollection()->where('type','web')->count() }}</div>
                        <div class="pi-stat-sub"><span class="pi-stat-dot" style="background:#1A7A4A"></span>Web / Full-stack</div>
                    </div>
                    <div class="pi-stat-card">
                        <div class="pi-stat-label">Mobile</div>
                        <div class="pi-stat-value">{{ $projects->getCollection()->where('type','mobile')->count() }}</div>
                        <div class="pi-stat-sub"><span class="pi-stat-dot" style="background:#2563EB"></span>iOS & Android</div>
                    </div>
                    <div class="pi-stat-card">
                        <div class="pi-stat-label">AI / Other</div>
                        <div class="pi-stat-value">{{ $projects->getCollection()->whereNotIn('type',['web','mobile'])->count() }}</div>
                        <div class="pi-stat-sub"><span class="pi-stat-dot" style="background:#7C3AED"></span>AI · Security · etc.</div>
                    </div>
                </div>

                <div class="sort-bar">
                    <span class="results-count">
                        Showing <strong>{{ $projects->firstItem() ?? 0 }}–{{ $projects->lastItem() ?? 0 }}</strong> of <strong>{{ $projects->total() }}</strong> projects
                    </span>
                </div>

                {{-- Projects Display --}}
                @if($projects->isEmpty())
                    <div class="pi-empty-state">
                        <div class="pi-empty-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                        </div>
                        <h2 class="pi-empty-title">No projects found</h2>
                        <p class="pi-empty-desc">
                            @if($hasFilters)
                                No projects match your current filters. Try adjusting or clearing them.
                            @else
                                Once graduates submit their projects, they'll show up here.
                            @endif
                        </p>
                        @if($hasFilters)
                            <a href="{{ route('projects.index') }}" class="pi-btn-primary">Clear Filters</a>
                        @else
                            <a href="{{ route('projects.create') }}" class="pi-btn-primary">
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

                                {{-- ── Top of card: thumbnail OR accent bar ── --}}
                                @if($project->media && $project->media->isNotEmpty())
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

                                <div class="pi-card-body">
                                    <div class="pi-card-header">
                                        @if($project->media && $project->media->isEmpty())
                                            <span class="type-badge {{ $type }}">{{ $project->type }}</span>
                                        @else
                                            <span></span>
                                        @endif
                                    </div>

                                    <h3 class="pi-card-title">{{ $project->title }}</h3>
                                    <p class="pi-card-desc">{{ $project->description }}</p>

                                    @if($project->specializations && $project->specializations->isNotEmpty())
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

                                    @if($project->skills && $project->skills->isNotEmpty())
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

                                <div class="pi-card-footer">
                                    <div class="footer-links">
                                        @if($project->repository_link)
                                            <a href="{{ $project->repository_link }}" target="_blank" class="link-btn">
                                                {{-- SVG موجود --}}
                                                Repo
                                            </a>
                                        @endif
                                        @if($project->live_demo_link)
                                            <a href="{{ $project->live_demo_link }}" target="_blank" class="link-btn">
                                                {{-- SVG موجود --}}
                                                Live
                                            </a>
                                        @endif
                                    </div>

                                    <div class="footer-actions">
                                        {{-- ✅ Heart Button --}}
                                        @auth
                                            <button
                                                class="wishlist-heart-btn {{ in_array($project->id, $wishlistedIds) ? 'active' : '' }}"
                                                data-id="{{ $project->id }}"
                                                title="{{ in_array($project->id, $wishlistedIds) ? 'Remove from wishlist' : 'Save to wishlist' }}"
                                            >
                                                <svg viewBox="0 0 24 24" fill="{{ in_array($project->id, $wishlistedIds) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2">
                                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                                </svg>
                                            </button>
                                        @endauth
    
                                        <a href="{{ route('projects.my_details', $project->id) }}" class="view-btn">
                                            View
                                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination Controls --}}
                    <nav class="pagination-wrapper" aria-label="Pagination">
                        {{ $projects->appends(request()->query())->links() }}
                    </nav>
                @endif
            </div>
        </section>
    </div>
</div>

<script>
    function toggleSection(id) {
        document.getElementById(id).classList.toggle('collapsed');
    }

    // Wishlist toggle
document.querySelectorAll('.wishlist-heart-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const id  = this.dataset.id;
        const btn = this;

        // Pop animation
        btn.classList.remove('popping');
        void btn.offsetWidth; // reflow
        btn.classList.add('popping');

        fetch(`/wishlist/toggle/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept':       'application/json',
                'Content-Type': 'application/json',
            }
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) return;

            const svg = btn.querySelector('svg');
            if (data.attached) {
                btn.classList.add('active');
                svg.setAttribute('fill', 'currentColor');
                btn.title = 'Remove from wishlist';
            } else {
                btn.classList.remove('active');
                svg.setAttribute('fill', 'none');
                btn.title = 'Save to wishlist';
            }
        })
        .catch(err => console.error('Wishlist error:', err));
    });
});

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
