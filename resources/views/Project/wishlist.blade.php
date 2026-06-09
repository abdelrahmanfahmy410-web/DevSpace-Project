@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('developer_reg_style.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>

    .wishlist-full-layout {
        display: flex;
        width: 100%;
        min-height: calc(100vh - 70px); 
        background-color: transparent;
    }

    .wishlist-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.3rem;
        padding: 8px;
        transition: transform 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .wishlist-btn:hover { transform: scale(1.25); }
    

    .filter-sidebar {
        width: 290px; 
        flex-shrink: 0; 
        background: var(--color-white, #fff); 
        border-right: 1px solid #eef2f5;
        padding: 30px 24px;
    }
    .filter-group {
        margin-bottom: var(--space-4, 16px);
    }
    .filter-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        font-size: 0.9rem;
        color: var(--color-dark, #333);
    }
    .form-control-custom {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: #fff;
        font-size: 0.9rem;
    }

  
    .card__footer {
        display: flex;
        justify-content: space-between; 
        align-items: center;
        padding: var(--space-4, 16px);
        border-top: 1px solid #eee;
    }
    .card__actions-right {
        display: flex;
        gap: 8px;
        align-items: center;
    }
</style>

<div class="wishlist-full-layout" id="wishlistPageRoot">

    <aside class="filter-sidebar">
        <h2 class="heading-3" style="margin-bottom: 4px;">My Wishlist</h2>
        <p class="text-muted" style="margin-bottom: var(--space-5); font-size: 0.9rem;">
            {{ $projects->total() }} saved {{ Str::plural('project', $projects->total()) }}
        </p>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: var(--space-5); margin-top: var(--space-4);">

        <form action="{{ url()->current() }}" method="GET">
            <div class="filter-group">
                <label for="search">Search Keywords</label>
                <input type="text" name="search" id="search" class="form-control-custom" placeholder="Project name or keyword..." value="{{ request('search') }}">
            </div>

            <div class="filter-group">
                <label for="type">Project Type</label>
                <select name="type" id="type" class="form-control-custom">
                    <option value="">All Types</option>
                    <option value="web" {{ request('type') == 'web' ? 'selected' : '' }}>Web Application</option>
                    <option value="mobile" {{ request('type') == 'mobile' ? 'selected' : '' }}>Mobile App</option>
                    <option value="desktop" {{ request('type') == 'desktop' ? 'selected' : '' }}>Desktop</option>
                    <option value="ai" {{ request('type') == 'ai' ? 'selected' : '' }}>AI / ML</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="specialization">Specialization</label>
                <select name="specialization" id="specialization" class="form-control-custom">
                    <option value="">All Specializations</option>
                    @foreach($specializations ?? [] as $spec)
                        <option value="{{ $spec->id }}" {{ request('specialization') == $spec->id ? 'selected' : '' }}>
                            {{ $spec->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="skill">Required Skill</label>
                <select name="skill" id="skill" class="form-control-custom">
                    <option value="">All Skills</option>
                    @foreach($skills ?? [] as $skill)
                        <option value="{{ $skill->id }}" {{ request('skill') == $skill->id ? 'selected' : '' }}>
                            {{ $skill->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-top: var(--space-5); display: flex; flex-direction: column; gap: 8px;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px; font-weight: 600;">
                    Apply Filters
                </button>
                @if(request()->hasAny(['search', 'type', 'specialization', 'skill']))
                    <a href="{{ url()->current() }}" class="btn btn-outline" style="width: 100%; padding: 10px; text-align: center; box-sizing: border-box;">
                        Clear Filters
                    </a>
                @endif
            </div>
        </form>
    </aside>

    <div class="main" style="flex-grow: 1; padding: 30px var(--space-5);">

        <header class="navbar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-6); background: transparent; padding: 0;">
            <div class="navbar__logo">
                <h1 class="heading-2" style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-heart" style="color: var(--color-accent, #ff4757);"></i>
                    My Wishlist
                </h1>
            </div>
            <div class="navbar__links">
                <a href="{{ route('projects.index') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Browse All Projects
                </a>
            </div>
        </header>

        <div class="container-fluid" style="padding: 0;">

            @if($projects->isEmpty())
                <div class="empty-state-box" style="margin-top: var(--space-8); text-align:center;">
                    <div style="font-size: 60px; margin-bottom: var(--space-4); color: var(--color-accent);">
                        <i class="fa-regular fa-heart"></i>
                    </div>
                    <h3 class="heading-3">No Results Match Your Criteria</h3>
                    <p class="card__description">Try changing your sidebar filters or spelling options.</p>
                    <a href="{{ url()->current() }}" class="btn btn-primary">Reset Filter View</a>
                </div>
            @else
                <div class="grid-cards">
                    @foreach($projects as $project)
                        <div class="card card--project" id="project-card-{{ $project->id }}">

                            @if($project->media && $project->media->isNotEmpty())
                                <img src="{{ asset('storage/' . $project->media->first()->file_path) }}" 
                                     class="card__thumbnail" alt="{{ $project->title }}">
                            @else
                                <div class="card__thumbnail" style="background:var(--color-dark-navy); display:flex; align-items:center; justify-content:center;">
                                    <i class="fa-regular fa-image fa-3x" style="color:rgba(255,255,255,0.15);"></i>
                                </div>
                            @endif

                            <div class="card__body">
                                <span class="badge badge--red">{{ strtoupper($project->type ?? 'PROJECT') }}</span>
                                <h3 class="card__title">{{ $project->title }}</h3>
                                <p class="card__description">{{ Str::limit($project->description, 130) }}</p>

                                @if($project->specializations && $project->specializations->isNotEmpty())
                                    <div class="card__sectors">
                                        @foreach($project->specializations->take(3) as $spec)
                                            <span class="badge badge--grey">{{ $spec->name }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="card__footer">
                                <button class="wishlist-btn" data-id="{{ $project->id }}">
                                    <i class="fa-solid fa-heart" style="color: var(--color-accent, #ff4757);"></i>
                                </button>

                                <div class="card__actions-right">
                                    @if($project->repository_link)
                                        <a href="{{ $project->repository_link }}" target="_blank" class="btn btn-outline">Repo</a>
                                    @endif
                                    <a href="{{ route('projects.show', $project->id) }}" class="btn btn-primary">View</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($projects->hasPages())
                    <div class="d-flex justify-center" style="margin-top: var(--space-7); display: flex; justify-content: center;">
                        {!! $projects->appends(request()->query())->links() !!}
                    </div>
                @endif
            @endif

        </div>
    </div>
</div>

<script>

document.addEventListener("DOMContentLoaded", function() {
    const pageRoot = document.getElementById('wishlistPageRoot');
    if (pageRoot) {
        const parentContainer = pageRoot.parentElement;
        if (parentContainer) {
          
            parentContainer.style.padding = '0';
            parentContainer.style.margin = '0';
            parentContainer.style.maxWidth = '100%';
            parentContainer.style.width = '100%';
        }
    }
});

// الأكشن الخاص بحذف العناصر من المفضلة
document.querySelectorAll('.wishlist-btn').forEach(button => {
    button.addEventListener('click', function() {
        const projectId = this.getAttribute('data-id');
        const card = document.getElementById(`project-card-${projectId}`);

        fetch(`/wishlist/toggle/${projectId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success && !data.attached) {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    card.remove();
                    if (document.querySelectorAll('.card--project').length === 0) {
                        location.reload();
                    }
                }, 300);
            }
        });
    });
});
</script>
@endsection