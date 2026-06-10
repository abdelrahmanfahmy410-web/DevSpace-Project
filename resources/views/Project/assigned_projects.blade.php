@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/assigned_projects.css') }}">

<div class="projects-container">
    
    <div class="project-directory-header">
        <h2>Project Directory</h2>
        <div class="search-container">
            <form action="{{ url()->current() }}" method="GET" id="searchForm">
                <input type="text" name="search" id="projectSearchInput" value="{{ request('search') }}" placeholder="Search projects..." class="search-input">
            </form>
        </div>
    </div>

    <div class="filter-section">
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="web">Web</button>
            <button class="filter-btn" data-filter="mobile">Mobile</button>
            <button class="filter-btn" data-filter="ai">AI</button>
            <button class="filter-btn" data-filter="security">Security</button>
        </div>
    </div>

    <div class="projects-grid">
        
        @forelse($projects as $project)
            @php
                $projectType = strtolower($project->type); 
                
                if ($project->media && $project->media->first() && !empty($project->media->first()->file_path)) {
                    $path = $project->media->first()->file_path;
                    
                    if (\Illuminate\Support\Str::startsWith($path, 'public/')) {
                        $path = \Illuminate\Support\Str::replaceFirst('public/', '', $path);
                    }
                    
                    if (\Illuminate\Support\Str::startsWith($path, ['storage/', 'http://', 'https://'])) {
                        $projectImage = asset($path);
                    } else {
                        $projectImage = asset('storage/' . ltrim($path, '/'));
                    }
                } else {
                    $projectImage = 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=500'; 
                }
            @endphp

            <div class="project-card" data-status="{{ $projectType }}">
                
                <div class="card-image-wrapper">
                    <img src="{{ $projectImage }}" alt="{{ $project->title }}" class="project-img">
                    <span class="type-badge">{{ strtoupper($project->type) }}</span>
                </div>

                <div class="card-body">
                    <div class="title-row">
                        <h3 class="project-title">{{ $project->title }}</h3>
                        <i class="fa-solid fa-ellipsis-vertical options-icon"></i>
                    </div>
                    
                    <p class="project-desc">{{ Str::limit($project->description, 90, '...') }}</p>
                    
                    <div class="meta-section">
                        <div class="meta-label">SPECIALIZATIONS</div>
                        <div class="tags-container">
                            @if($project->specializations)
                                @foreach($project->specializations as $spec)
                                    <span class="tag-spec">{{ $spec->name }}</span>
                                @endforeach
                            @endif
                        </div>

                        <div class="meta-label" style="margin-top: 10px;">SKILLS</div>
                        <div class="tags-container">
                            @if($project->skills)
                                @foreach($project->skills as $skill)
                                    <span class="tag-skill">{{ $skill->name }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                {{-- منطقة الـ الفوتر المحدثة والمقسمة لسطرين --}}
                <div class="card-footer">
                    
                    {{-- السطر العلوي: الروابط الأساسية --}}
                    <div class="footer-top-row">
                        <div class="left-links">
                            @if($project->repository_link)
                                <a href="{{ $project->repository_link }}" target="_blank" class="footer-link-btn">
                                    <i class="fa-regular fa-file-lines"></i> Repo
                                </a>
                            @endif
                            
                            @if($project->live_demo_link)
                                <a href="{{ $project->live_demo_link }}" target="_blank" class="footer-link-btn">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Live
                                </a>
                            @endif
                        </div>
                        
                        <a href="{{ route('projects.my_details', $project->id) }}" class="view-details-btn">
                            View Details &rarr;
                        </a>
                    </div>

                    {{-- السطر السفلي: أزرار التحكم جنب بعضها --}}
                    <div class="footer-buttons-row">
                        {{-- فورم Accept --}}
                        <form action="#" method="POST" style="display: inline; margin: 0;">
                            @csrf
                            <button type="submit" class="footer-link-btn-accept">
                                <i class="fa-solid fa-check"></i> Accept
                            </button>
                        </form>

                        {{-- فورم Reject --}}
                        <form action="#" method="POST" style="display: inline; margin: 0;">
                            @csrf
                            <button type="submit" class="footer-link-btn-reject">
                                <i class="fa-solid fa-xmark"></i> Reject
                            </button>
                        </form>
                    </div>

                </div> {{-- نهاية الفوتر --}}
            </div>

        @empty
            <div class="no-projects">
                <p>No assigned projects found in this directory.</p>
            </div>
        @endforelse

    </div>

    <div class="pagination-wrapper" style="margin-top: 30px; display: flex; justify-content: center;">
        {{ $projects->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterButtons = document.querySelectorAll('.filter-section .filter-btn');
        const projectCards = document.querySelectorAll('.projects-grid .project-card');
        const searchInput = document.getElementById('projectSearchInput');
        const searchForm = document.getElementById('searchForm');

        function filterProjects() {
            const activeBtn = document.querySelector('.filter-section .filter-btn.active');
            const filterValue = activeBtn ? activeBtn.getAttribute('data-filter').toLowerCase().trim() : 'all';
            const searchValue = searchInput ? searchInput.value.toLowerCase().trim() : '';

            projectCards.forEach(card => {
                const cardStatus = card.getAttribute('data-status') ? card.getAttribute('data-status').toLowerCase().trim() : '';
                
                const titleEl = card.querySelector('.project-title');
                const descEl = card.querySelector('.project-desc');
                
                const projectTitle = titleEl ? titleEl.textContent.toLowerCase() : '';
                const projectDesc = descEl ? descEl.textContent.toLowerCase() : '';

                const matchesFilter = (filterValue === 'all' || cardStatus === filterValue || cardStatus.includes(filterValue));
                const matchesSearch = (projectTitle.includes(searchValue) || projectDesc.includes(searchValue));

                if (matchesFilter && matchesSearch) {
                    card.style.setProperty('display', 'flex', 'important');
                } else {
                    card.style.setProperty('display', 'none', 'important');
                }
            });
        }

        filterButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); 
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                filterProjects();
            });
        });

        if (searchInput) {
            searchInput.addEventListener('input', filterProjects);
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    searchForm.submit();
                }
            });
        }
    });
</script>
@endsection