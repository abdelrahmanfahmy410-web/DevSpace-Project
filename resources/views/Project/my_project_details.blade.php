@extends('layouts.app')

@section('content')
    {{-- إضافة CSS و JS الخاص بـ Flowbite لضمان عمل السلايدر --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/my_project_details.css') }}">

    <section class="project-page">

        {{-- ============================================================
             Page header: title and action buttons
        ============================================================ --}}
        <div class="project-header">
            <div>
                <div class="project-meta">
                    <span class="project-badge {{ strtolower($project->type) === 'other' ? 'other' : '' }}">
                        {{ $project->type ?: 'Other' }}
                    </span>
                </div>
                <h1 class="project-title">{{ $project->title }}</h1>
            </div>

            <div class="project-actions">
                <a href="{{ route('projects.index') }}" class="btn-secondary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to projects
                </a>

                @if ($project->repository_link)
                    <a href="{{ $project->repository_link }}" target="_blank" rel="noopener noreferrer" class="btn-secondary">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                        Repo
                    </a>
                @endif

                {{-- ✅ تم تعديله هنا ليصبح رابطًا مباشرًا لصفحة الـ Wishlist --}}
                <a href="{{ url('/wishlist') }}" class="btn-wishlist-header">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    Wishlist
                </a>

                @if ($project->live_demo_link)
                    <a href="{{ $project->live_demo_link }}" target="_blank" rel="noopener noreferrer" class="btn-view">
                        Open live demo
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                @endif
            </div>
        </div>

        <div class="content-grid">
            {{-- العمود الأيسر --}}
            <div>
                {{-- كارد الوصف --}}
                <div class="card">
                    <h2 class="section-title">
                        <svg width="20" height="20" fill="none" stroke="#10B981" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Project overview
                    </h2>
                    <div class="project-description">
                        {{ $project->description }}
                    </div>
                </div>

                {{-- قسم الميديا - Animation Carousel --}}
                <div class="card" style="margin-top: 1.5rem;">
                    <h2 class="section-title">
                        <svg width="20" height="20" fill="none" stroke="#10B981" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Project media
                    </h2>

                    @if ($project->media->isNotEmpty())
                        <div id="animation-carousel" class="relative w-full" data-carousel="static">
                            <div class="relative h-56 overflow-hidden rounded-base md:h-96">
                                @foreach ($project->media as $media)
                                    <div class="hidden duration-200 ease-linear" data-carousel-item="{{ $loop->first ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $media->file_path) }}" 
                                             class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" 
                                             alt="Media">
                                    </div>
                                @endforeach
                            </div>
                            
                            <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-base bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white focus:outline-none">
                                    <svg class="w-5 h-5 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"/></svg>
                                    <span class="sr-only">Previous</span>
                                </span>
                            </button>
                            <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-base bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white focus:outline-none">
                                    <svg class="w-5 h-5 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
                                    <span class="sr-only">Next</span>
                                </span>
                            </button>
                        </div>
                    @else
                        <p class="empty-state">No media uploaded for this project.</p>
                    @endif
                </div>
            </div>

            {{-- العمود الأيمن --}}
            <aside>
                <div class="card">
                    <div class="tags-title">Specializations</div>
                    @if ($project->specializations->isNotEmpty())
                        <div class="tags-row">
                            @foreach ($project->specializations as $specialization)
                                <span class="project-tag specialization">{{ $specialization->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="empty-state" style="margin-bottom: 1.5rem;">No specializations selected.</p>
                    @endif

                    <div class="tags-title" style="margin-top: 1.5rem;">Skills</div>
                    @if ($project->skills->isNotEmpty())
                        <div class="tags-row" style="margin-bottom: 0;">
                            @foreach ($project->skills as $skill)
                                <span class="project-tag skill">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="empty-state">No skills added.</p>
                    @endif
                </div>

                <div class="card" style="margin-top: 1.5rem;">
                    <h2 class="section-title">
                        <svg width="20" height="20" fill="none" stroke="#10B981" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Team members
                    </h2>
                    @if ($project->team_roles->isNotEmpty())
                        <div class="project-list">
                            @foreach ($project->team_roles as $member)
                                <div class="project-list-item">
                                    <div class="member-info">
                                        <strong>{{ $member->name ?? 'Team member' }}</strong>
                                        <span>{{ $member->email ?? '' }}</span>
                                    </div>
                                    <div class="member-actions">
                                        <div class="member-role">{{ $member->pivot->role ?? 'Member' }}</div>
                                        <a href="{{ route('member.profile', $member->id) }}" class="btn-member btn-profile">View Profile</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="empty-state">No team members assigned yet.</p>
                    @endif
                </div>
            </aside>
        </div>
    </section>

    {{-- السكربت داخل السكشن --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
@endsection