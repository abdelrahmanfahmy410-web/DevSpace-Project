@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Directory — DevSpace</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

        /* Layout */
        .layout { display: flex; min-height: 100vh; }

        /* Filter Sidebar */
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
        }

        .filter-sidebar-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .clear-all-btn {
            font-size: 12px;
            font-weight: 500;
            color: var(--red);
            padding: 3px 8px;
            border-radius: 5px;
            border: 1px solid rgba(192,57,43,0.25);
            background: var(--red-light);
            transition: all var(--transition);
        }

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

        .filter-section.collapsed .filter-section-arrow {
            transform: rotate(-90deg);
        }

        .filter-check-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 5px 8px;
            border-radius: var(--radius-sm);
            cursor: pointer;
        }

        .filter-check-item:hover { background: var(--bg); }

        .wishlist-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.15rem;
            padding: 4px 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s ease;
        }
        .wishlist-btn:hover { transform: scale(1.15); }

        /* Rest of your original styles (kept clean) */
        .main { flex: 1; display: flex; flex-direction: column; overflow-x: hidden; }
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            height: 60px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 10;
        }
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
        .card-thumbnail img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.35s ease; }
        .project-card:hover .card-thumbnail img { transform: scale(1.05); }

        .type-badge-over.web      { background: rgba(232,245,238,0.92); color: var(--green);  border-color: rgba(26,122,74,0.25); }
        .type-badge-over.mobile   { background: rgba(239,246,255,0.92); color: #2563EB;       border-color: rgba(37,99,235,0.25); }
        .type-badge-over.ai       { background: rgba(245,243,255,0.92); color: #7C3AED;       border-color: rgba(124,58,237,0.25); }
        .type-badge-over.security { background: rgba(253,236,234,0.92); color: var(--red);    border-color: rgba(192,57,43,0.25); }
        .type-badge-over.other    { background: rgba(244,247,250,0.92); color: var(--text-secondary); border-color: var(--border-md); }

        .card-footer { padding: 0.75rem 1.25rem; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; background: rgba(244,247,250,0.5); }
        .footer-links { display: flex; gap: 10px; }
        .link-btn { display: inline-flex; align-items: center; gap: 5px; font-size: 12.5px; font-weight: 500; padding: 4px 10px; border-radius: 6px; border: 1px solid var(--border); background: var(--surface); color: var(--text-secondary); text-decoration: none; transition: all var(--transition); }
        .link-btn:hover { border-color: var(--green); color: var(--green); background: var(--green-light); }

        .view-btn { display: inline-flex; align-items: center; gap: 5px; font-size: 12.5px; font-weight: 600; padding: 5px 12px; border-radius: 7px; border: none; background: var(--green-light); color: var(--green); text-decoration: none; cursor: pointer; transition: background var(--transition); }
        .view-btn:hover { background: #d1ead9; }

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
        .empty-title { font-size: 18px; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem; }
        .empty-desc { font-size: 14px; color: var(--text-secondary); max-width: 360px; margin: 0 auto 1.5rem; line-height: 1.6; }
    </style>
</head>
<body>

@php
    $selectedTypes  = request('type', []);
    $selectedSpecs  = array_map('intval', request('specialization', []));
    $selectedSkills = array_map('intval', request('skills', []));
    $selectedSort   = request('sort', 'newest');
    $hasFilters     = !empty($selectedTypes) || !empty($selectedSpecs) || !empty($selectedSkills);
@endphp

<div class="layout">

    {{-- Advanced Filter Sidebar --}}
    <form method="GET" action="{{ route('projects.index') }}" id="filter-form">
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
                    'web'      => ['label' => 'Web / Full-stack', 'color' => '#1A7A4A'],
                    'mobile'   => ['label' => 'Mobile',           'color' => '#2563EB'],
                    'ai'       => ['label' => 'AI / ML',          'color' => '#7C3AED'],
                    'security' => ['label' => 'Security',         'color' => '#C0392B'],
                ] as $val => $meta)
                    <label class="filter-check-item">
                        <input type="checkbox" name="type[]" value="{{ $val }}" 
                               {{ in_array($val, $selectedTypes) ? 'checked' : '' }} onchange="this.form.submit()">
                        <span class="type-dot" style="background:{{ $meta['color'] }}"></span>
                        <span class="filter-check-label">{{ $meta['label'] }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Specializations --}}
        <div class="filter-section" id="section-spec">
            <div class="filter-section-header" onclick="toggleSection('section-spec')">
                <span class="filter-section-label">Specialization</span>
                <svg class="filter-section-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M19 9l-7 7-7-7"/></svg>
            </div>
            <div class="filter-section-body">
                @foreach($specializations as $spec)
                    <label class="filter-check-item">
                        <input type="checkbox" name="specialization[]" value="{{ $spec->id }}" 
                               {{ in_array($spec->id, $selectedSpecs) ? 'checked' : '' }} onchange="this.form.submit()">
                        <span class="filter-check-label">{{ $spec->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Skills --}}
        <div class="filter-section" id="section-skill">
            <div class="filter-section-header" onclick="toggleSection('section-skill')">
                <span class="filter-section-label">Skills</span>
                <svg class="filter-section-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M19 9l-7 7-7-7"/></svg>
            </div>
            <div class="filter-section-body">
                @foreach($skills as $skill)
                    <label class="filter-check-item">
                        <input type="checkbox" name="skills[]" value="{{ $skill->id }}" 
                               {{ in_array($skill->id, $selectedSkills) ? 'checked' : '' }} onchange="this.form.submit()">
                        <span class="filter-check-label">{{ $skill->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Sort --}}
        <div class="filter-section" style="border-bottom:none;">
            <div class="filter-section-label" style="margin-bottom:0.6rem;">Sort By</div>
            <select name="sort" class="sidebar-sort-select" onchange="this.form.submit()">
                <option value="newest" {{ $selectedSort === 'newest' ? 'selected' : '' }}>Newest first</option>
                <option value="oldest" {{ $selectedSort === 'oldest' ? 'selected' : '' }}>Oldest first</option>
                <option value="az"     {{ $selectedSort === 'az'     ? 'selected' : '' }}>A → Z</option>
            </select>
        </div>

    </aside>
    </form>

    {{-- Main Content --}}
    <div class="main">

        <header class="topbar">
            <span class="topbar-title">Project Directory</span>
            <div class="topbar-right">
                <a href="{{ route('projects.create') }}" class="btn-primary">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                    New Project
                </a>
            </div>
        </header>

        <div class="content">

            {{-- Stats Row --}}
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-label">Total Projects</div>
                    <div class="stat-value">{{ $projects->total() }}</div>
                </div>
                <!-- Add more stats if needed -->
            </div>

            {{-- Projects Grid --}}
            @if($projects->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>
                    <div class="empty-title">No projects found</div>
                    <div class="empty-desc">Try adjusting your filters or add a new project.</div>
                </div>
            @else
                <div class="projects-grid">
                    @foreach($projects as $project)
                        @php $type = strtolower($project->type ?? 'web'); @endphp
                        <div class="project-card">
                            @if($project->media->isNotEmpty())
                                <div class="card-thumbnail">
                                    <img src="{{ asset('storage/' . $project->media->first()->file_path) }}" 
                                         alt="{{ $project->title }}" loading="lazy">
                                    <span class="type-badge-over {{ $type }}">{{ $project->type }}</span>
                                </div>
                            @else
                                <div class="card-accent {{ $type }}"></div>
                            @endif

                            <div class="card-body">
                                <h2 class="card-title">{{ $project->title }}</h2>
                                <p class="card-desc">{{ $project->description }}</p>

                                @if($project->specializations->isNotEmpty())
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

                            <div class="card-footer">
                                <div class="footer-links">
                                    @if($project->repository_link)
                                        <a href="{{ $project->repository_link }}" target="_blank" class="link-btn">Repo</a>
                                    @endif
                                    @if($project->live_demo_link)
                                        <a href="{{ $project->live_demo_link }}" target="_blank" class="link-btn">Live</a>
                                    @endif

                                    <button class="wishlist-btn" data-id="{{ $project->id }}">
                                        @if(auth()->check() && auth()->user()->wishlist->contains($project->id))
                                            <i class="fa-solid fa-heart" style="color: #ef4444;"></i>
                                        @else
                                            <i class="fa-regular fa-heart" style="color: #9ca3af;"></i>
                                        @endif
                                    </button>
                                </div>

                                <a href="{{ route('projects.show', $project->id) }}" class="view-btn">View</a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($projects->hasPages())
                    <div class="pagination">
                        {!! $projects->links() !!}
                    </div>
                @endif
            @endif

        </div>
    </div>
</div>

<script>
// Wishlist functionality
document.querySelectorAll('.wishlist-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const projectId = this.getAttribute('data-id');
        const icon = this.querySelector('i');

        fetch(`/wishlist/toggle/${projectId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.attached) {
                    icon.className = 'fa-solid fa-heart';
                    icon.style.color = '#ef4444';
                } else {
                    icon.className = 'fa-regular fa-heart';
                    icon.style.color = '#9ca3af';
                }
            }
        });
    });
});

// Toggle filter sections
function toggleSection(id) {
    document.getElementById(id).classList.toggle('collapsed');
}
</script>

</body>
</html>
@endsection