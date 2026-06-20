@extends('layouts.app_dashboard')

@section('page-title', 'Wishlist Projects') 
@section('content')
<link rel="stylesheet" href="{{ asset('developer_reg_style.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .wishlist-full-layout { display: flex; width: 100%; min-height: calc(100vh - 70px); background-color: transparent; }
    .filter-sidebar { width: 290px; flex-shrink: 0; background: #fff; border-right: 1px solid #eef2f5; padding: 30px 24px; }
    .filter-group { margin-bottom: 16px; }
    .filter-group label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem; color: #333; }
    .form-control-custom { width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; }
    .wishlist-btn { background: none; border: none; cursor: pointer; font-size: 1.3rem; padding: 8px; transition: transform 0.2s ease; display: flex; align-items: center; }
    .wishlist-btn:hover { transform: scale(1.25); }
    .card__footer { display: flex; justify-content: space-between; align-items: center; padding: 16px; border-top: 1px solid #eee; }
    .card__actions-right { display: flex; gap: 8px; align-items: center; }
    .grid-cards { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }
</style>

<div class="wishlist-full-layout" id="wishlistPageRoot">
    <aside class="filter-sidebar">
        <h2 class="heading-3" style="margin-bottom: 4px;">My Wishlist</h2>
        <p class="text-muted" style="margin-bottom: 20px; font-size: 0.9rem;">
            {{ $projects->total() }} saved {{ Str::plural('project', $projects->total()) }}
        </p>
        <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">

        <form action="{{ route('wishlist.index') }}" method="GET">
            <div class="filter-group">
                <label for="search">Search Keywords</label>
                <input type="text" name="search" id="search" class="form-control-custom" placeholder="Project name..." value="{{ request('search') }}">
            </div>

            <div class="filter-group">
                <label for="type">Project Type</label>
                <select name="type" id="type" class="form-control-custom">
                    <option value="">All Types</option>
                    <option value="web" {{ request('type') == 'web' ? 'selected' : '' }}>Web Application</option>
                    <option value="mobile" {{ request('type') == 'mobile' ? 'selected' : '' }}>Mobile App</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="skill">Required Skill</label>
                <select name="skill" id="skill" class="form-control-custom">
                    <option value="">All Skills</option>
                    @foreach($skills ?? [] as $skill)
                        <option value="{{ $skill->id }}" {{ request('skill') == $skill->id ? 'selected' : '' }}>{{ $skill->name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-top: 20px; display: flex; flex-direction: column; gap: 8px;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px; font-weight: 600;">Apply Filters</button>
                @if(request()->hasAny(['search', 'type', 'skill']))
                    <a href="{{ route('wishlist.index') }}" class="btn btn-outline" style="width: 100%; padding: 10px; text-align: center;">Clear Filters</a>
                @endif
            </div>
        </form>
    </aside>

    <main class="main" style="flex-grow: 1; padding: 30px;">
        <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h1 class="heading-2"><i class="fa-solid fa-heart" style="color: #ff4757;"></i> Wishlist</h1>
            <a href="{{ route('projects.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Browse All</a>
        </header>

        <div class="grid-cards">
            @forelse($projects as $project)
                <div class="card" id="project-card-{{ $project->id }}">
                    <div class="card__body" style="padding: 16px;">
                        <h3 class="heading-4" style="margin-bottom: 8px;">{{ $project->title }}</h3>
                        <p class="text-muted" style="font-size: 0.88rem; margin-bottom: 12px;">
                            {{ Str::limit($project->description, 100) }}
                        </p>
                        @if($project->type)
                            <span class="badge" style="background: #e8f5ee; color: #1A7A4A; padding: 3px 10px; border-radius: 20px; font-size: 0.8rem;">
                                {{ ucfirst($project->type) }}
                            </span>
                        @endif
                    </div>
                    <div class="card__footer">
                        <div class="card__actions-right">
                            <a href="{{ route('projects.my_details', $project->id) }}" class="btn btn-primary" style="font-size: 13px; padding: 6px 14px;">
                                View Project
                            </a>

                            <!-- Wishlist Button -->
                            <button class="wishlist-btn" data-id="{{ $project->id }}" title="Remove from wishlist">
                                <i class="fa-solid fa-heart" style="color: var(--color-accent);"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <p>No projects in your wishlist.</p>
            @endforelse
        </div>

        <div style="margin-top: 30px;">
            {!! $projects->withQueryString()->links() !!}
        </div>
    </main>
</div>

<script>
document.querySelectorAll('.wishlist-btn').forEach(button => {
    button.addEventListener('click', function() {
        const projectId = this.getAttribute('data-id');
        const card = document.getElementById(`project-card-${projectId}`);
        fetch(`/wishlist/toggle/${projectId}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                card.style.opacity = '0';
                setTimeout(() => card.remove(), 300);
            }
        });
    });
});
</script>
@endsection