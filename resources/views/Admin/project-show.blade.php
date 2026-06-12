@extends('admin.layouts.admin')

@php
    $pageTitle    = $project->title;
    $pageSubtitle = 'Project details';
@endphp

@section('content')

    {{-- Back button --}}
    <div class="admin-project-show__back">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Back to Projects
        </a>
    </div>

    {{-- Header Card --}}
    <div class="card admin-project-show__header">
        <div class="admin-project-show__meta">
            <span class="badge badge--prototype">{{ ucfirst($project->type) }}</span>
            <span class="text-muted admin-project-show__id">#{{ $project->id }}</span>
        </div>
        <h1 class="heading-1 admin-project-show__title">{{ $project->title }}</h1>
        <div class="admin-project-show__stats">
            <div class="admin-project-show__stat">
                <i class="fas fa-eye"></i>
                {{ number_format($project->views) }} views
            </div>
            <div class="admin-project-show__stat">
                <i class="fas fa-users"></i>
                {{ $project->team_roles->count() }} team members
            </div>
            <div class="admin-project-show__stat">
                <i class="fas fa-calendar"></i>
                Created {{ $project->created_at->format('M d, Y') }}
            </div>
        </div>
        <div class="admin-project-show__links">
            @if($project->repository_link)
                <a href="{{ $project->repository_link }}"
                   target="_blank"
                   class="btn btn-outline">
                    <i class="fas fa-code-branch"></i> Repository
                </a>
            @endif
            @if($project->live_demo_link)
                <a href="{{ $project->live_demo_link }}"
                   target="_blank"
                   class="btn btn-primary">
                    <i class="fas fa-arrow-up-right-from-square"></i> Live Demo
                </a>
            @endif
        </div>
    </div>

    {{-- Two Column Grid --}}
    <div class="admin-project-show__grid">

        {{-- Left Column --}}
        <div class="admin-project-show__main">

            {{-- Description --}}
            <div class="card admin-project-show__card">
                <h2 class="heading-3 admin-project-show__card-title">
                    <i class="fas fa-align-left"></i> Description
                </h2>
                <p class="admin-project-show__description">{{ $project->description }}</p>
            </div>

            {{-- Links --}}
            @if($project->repository_link || $project->live_demo_link)
            <div class="card admin-project-show__card">
                <h2 class="heading-3 admin-project-show__card-title">
                    <i class="fas fa-link"></i> Links
                </h2>
                <dl class="admin-project-show__dl">
                    <dt>Repository</dt>
                    <dd>
                        @if($project->repository_link)
                            <a href="{{ $project->repository_link }}" target="_blank">
                                {{ $project->repository_link }}
                            </a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </dd>
                    <dt>Live Demo</dt>
                    <dd>
                        @if($project->live_demo_link)
                            <a href="{{ $project->live_demo_link }}" target="_blank">
                                {{ $project->live_demo_link }}
                            </a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </dd>
                </dl>
            </div>
            @endif

            {{-- Media --}}
            <div class="card admin-project-show__card">
                <h2 class="heading-3 admin-project-show__card-title">
                    <i class="fas fa-images"></i> Media
                    <span class="badge badge--grey" style="margin-left:auto;">
                        {{ $project->media->count() }} files
                    </span>
                </h2>
                @if($project->media->isNotEmpty())
                    <div class="admin-project-show__media-grid">
                        @foreach($project->media as $media)
                            <div class="admin-project-show__media-item">
                                <img src="{{ asset('storage/' . $media->file_path) }}"
                                     alt="{{ $media->medianame }}"
                                     loading="lazy">
                                <div class="admin-project-show__media-name">
                                    {{ $media->medianame }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No media uploaded for this project.</p>
                @endif
            </div>

        </div>

        {{-- Right Sidebar --}}
        <aside class="admin-project-show__aside">

            {{-- Specializations --}}
            <div class="card admin-project-show__card">
                <h2 class="heading-3 admin-project-show__card-title">
                    <i class="fas fa-layer-group"></i> Specializations
                </h2>
                @if($project->specializations->isNotEmpty())
                    <div class="admin-project-show__tags">
                        @foreach($project->specializations as $spec)
                            <span class="badge badge--idea">{{ $spec->name }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No specializations selected.</p>
                @endif
            </div>

            {{-- Skills --}}
            <div class="card admin-project-show__card">
                <h2 class="heading-3 admin-project-show__card-title">
                    <i class="fas fa-tags"></i> Skills
                </h2>
                @if($project->skills->isNotEmpty())
                    <div class="admin-project-show__tags">
                        @foreach($project->skills as $skill)
                            <span class="badge badge--grey">{{ $skill->name }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No skills added.</p>
                @endif
            </div>

            {{-- Team Members --}}
            <div class="card admin-project-show__card">
                <h2 class="heading-3 admin-project-show__card-title">
                    <i class="fas fa-users"></i> Team Members
                </h2>
                @if($project->team_roles->isNotEmpty())
                    <div class="admin-project-show__team">
                        @foreach($project->team_roles as $member)
                            <div class="admin-project-show__member">
                                <div class="admin-project-show__member-info">
                                    {{-- Avatar --}}
                                    @if($member->profile_picture)
                                        <img src="{{ asset('storage/' . $member->profile_picture) }}"
                                             alt="{{ $member->name }}"
                                             class="admin-project-show__member-avatar">
                                    @else
                                        <div class="admin-project-show__member-avatar admin-project-show__member-avatar--placeholder">
                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="admin-project-show__member-name">
                                            {{ $member->name }}
                                        </div>
                                        <div class="text-muted" style="font-size:var(--font-size-meta);">
                                            {{ $member->email }}
                                        </div>
                                    </div>
                                </div>
                                <span class="badge badge--grey">
                                    {{ $member->pivot->role ?? 'Member' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No team members assigned yet.</p>
                @endif
            </div>

        </aside>
    </div>

@endsection