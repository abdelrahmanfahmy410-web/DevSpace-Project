@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist — DevSpace</title>
    
    <!-- الاستايل الجديد -->
    <link rel="stylesheet" href="{{ asset('developer_reg_style.css') }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* تعديلات إضافية خاصة بصفحة المفضلة */
        .wishlist-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            padding: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform var(--transition-fast);
            margin-left: auto;
        }
        
        .wishlist-btn:hover {
            transform: scale(1.2);
        }

        .card__footer {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding-top: var(--space-4);
            border-top: 1px solid var(--color-border);
            margin-top: auto;
        }

        .empty-state-box {
            background-color: var(--color-white);
            border: 1px dashed var(--color-border);
            border-radius: var(--radius-card);
            padding: var(--space-8) var(--space-6);
            text-align: center;
            max-width: 520px;
            margin: var(--space-8) auto;
        }

        .empty-icon {
            font-size: 52px;
            color: var(--color-accent);
            margin-bottom: var(--space-4);
        }

        .navbar {
            margin-bottom: var(--space-6);
        }

        /* Override the grid layout to give cards more width */
        .grid-cards {
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <header class="navbar" style="position: static;">
        <div class="navbar__logo">
            <h1 class="heading-2" style="margin: 0;">
                <i class="fa-solid fa-heart" style="color: var(--color-accent); margin-right: 10px;"></i>
                {{ auth()->user()->name ?? 'User' }}'s Wishlist
                <span style="font-size: 18px; color: var(--color-muted); font-weight: 500;">
                    ({{ $projects->total() }})
                </span>
            </h1>
        </div>
        
        <div class="navbar__links">
            <a href="{{ route('projects.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                Back to Project Directory
            </a>
        </div>
    </header>

    <div class="container">

        @if($projects->isEmpty())
            <div class="empty-state-box">
                <div class="empty-icon">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <h3 class="heading-2 mb-3">Your Wishlist is Empty</h3>
                <p class="card__description" style="max-width: 380px; margin: 0 auto 24px;">
                    You haven't saved any projects yet. Start exploring amazing projects from the community.
                </p>
                <a href="{{ route('projects.index') }}" class="btn btn-primary">
                    Browse All Projects
                </a>
            </div>
        @else
            <div class="grid-cards" id="projects-container">
                @foreach($projects as $project)
                    @php 
                        $type = strtolower($project->type ?? 'web'); 
                    @endphp
                    
                    <div class="card card--project" id="project-card-{{ $project->id }}">
                        
                        <!-- Thumbnail -->
                        @if($project->media->isNotEmpty())
                            <img 
                                src="{{ asset('storage/' . $project->media->first()->file_path) }}" 
                                alt="{{ $project->title }}" 
                                class="card__thumbnail">
                        @else
                            <div class="card__thumbnail" style="background: var(--color-dark-navy); display: flex; align-items: center; justify-content: center;">
                                <i class="fa-regular fa-image" style="font-size: 42px; color: rgba(255,255,255,0.15);"></i>
                            </div>
                        @endif

                        <div class="card__body">
                            <!-- Type Badge -->
                            <div class="mb-3">
                                <span class="badge badge--red">
                                    {{ strtoupper($project->type ?? 'PROJECT') }}
                                </span>
                            </div>

                            <h3 class="card__title">{{ $project->title }}</h3>
                            <p class="card__description">{{ Str::limit($project->description, 160) }}</p>

                            <!-- Specializations -->
                            @if($project->specializations->isNotEmpty())
                                <div class="card__sectors" style="margin-top: var(--space-4);">
                                    @foreach($project->specializations->take(3) as $spec)
                                        <span class="badge badge--grey">{{ $spec->name }}</span>
                                    @endforeach
                                    @if($project->specializations->count() > 3)
                                        <span class="badge badge--grey">+{{ $project->specializations->count() - 3 }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Footer -->
                        <div class="card__footer">
                            @if($project->repository_link)
                                <a href="{{ $project->repository_link }}" target="_blank" class="btn btn-outline" style="font-size: 13px; padding: 6px 14px;">
                                    <i class="fa-brands fa-github"></i> Repo
                                </a>
                            @endif

                            <a href="{{ route('projects.show', $project->id) }}" class="btn btn-primary" style="font-size: 13px; padding: 6px 14px;">
                                View Project
                            </a>

                            <!-- Wishlist Button -->
                            <button class="wishlist-btn" data-id="{{ $project->id }}" title="Remove from wishlist">
                                <i class="fa-solid fa-heart" style="color: var(--color-accent);"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($projects->hasPages())
                <div class="d-flex justify-center mt-7">
                    {{ $projects->links() }}
                </div>
            @endif
        @endif

    </div>

    <script>
    document.querySelectorAll('.wishlist-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const projectId = this.getAttribute('data-id');
            const card = document.getElementById(`project-card-${projectId}`);

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
                if (data && data.success && !data.attached) {
                    // Animation before remove
                    card.style.transition = 'all var(--transition-base)';
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(15px) scale(0.96)';

                    setTimeout(() => {
                        card.remove();

                        // Update count
                        const countEl = document.querySelector('h1 span');
                        if (countEl) {
                            let count = parseInt(countEl.innerText) || 0;
                            countEl.innerText = Math.max(0, count - 1);
                        }

                        // If no projects left → reload to show empty state
                        if (document.querySelectorAll('.card--project').length === 0) {
                            location.reload();
                        }
                    }, 280);
                }
            })
            .catch(err => console.error(err));
        });
    });
    </script>

</body>
</html>
@endsection