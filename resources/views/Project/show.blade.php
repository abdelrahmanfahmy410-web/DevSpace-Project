@extends('layouts.app')

@section('content')
    <style>
        .project-page {
            padding: 2rem 0;
        }

        .project-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 1rem;
            align-items: flex-start;
            margin-bottom: 1.75rem;
        }

        .project-header-left {
            max-width: 100%;
        }

        .project-title {
            margin: 0;
            font-size: 2.25rem;
            line-height: 1.1;
            color: #111827;
        }

        .project-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 0.75rem;
            color: #4B5563;
            font-size: 0.95rem;
        }

        .project-badge,
        .project-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border-radius: 999px;
            padding: 0.45rem 0.85rem;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            background: #ECFDF5;
            color: #166534;
        }

        .project-badge.other {
            background: #EEF2FF;
            color: #4338CA;
        }

        .project-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .btn-view,
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.85rem 1.2rem;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .btn-view {
            background: #1A7A4A;
            color: #ffffff;
        }

        .btn-view:hover {
            background: #166537;
        }

        .btn-secondary {
            background: #F3F4F6;
            color: #111827;
            border: 1px solid #D1D5DB;
        }

        .content-grid {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(320px, 1fr);
            gap: 1.5rem;
        }

        .card {
            background: #ffffff;
            border: 1px solid #E5E7EB;
            border-radius: 20px;
            padding: 1.75rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
        }

        .card h2 {
            margin: 0 0 0.75rem;
            font-size: 1.25rem;
            color: #111827;
        }

        .section-title {
            margin: 0 0 1rem;
            font-size: 1.1rem;
            color: #111827;
            font-weight: 700;
        }

        .project-description {
            margin: 0;
            color: #4B5563;
            line-height: 1.8;
            white-space: pre-line;
        }

        .project-details dt {
            font-weight: 700;
            margin-top: 1rem;
            color: #111827;
        }

        .project-details dd {
            margin: 0.35rem 0 0;
            color: #4B5563;
            line-height: 1.7;
        }

        .project-list {
            display: grid;
            gap: 0.75rem;
        }

        .project-list-item {
            background: #F9FAFB;
            border-radius: 14px;
            padding: 0.85rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.75rem;
        }

        .project-list-item strong {
            color: #111827;
        }

        .project-list-item span {
            color: #6B7280;
            font-size: 0.95rem;
        }

        .tags-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
            margin-top: 0.75rem;
        }

        .project-image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .project-image {
            position: relative;
            border-radius: 18px;
            overflow: hidden;
            min-height: 130px;
            background: #F3F4F6;
        }

        .project-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .empty-state {
            color: #6B7280;
            font-size: 0.96rem;
        }

        @media (max-width: 900px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <section class="project-page">
        <div class="project-header">
            <div class="project-header-left">
                <p class="project-meta">
                    <span class="project-badge {{ strtolower($project->type) === 'other' ? 'other' : '' }}">{{ $project->type ?: 'Other' }}</span>
        
                </p>
                <h1 class="project-title">{{ $project->title }}</h1>
                <p class="project-description">{{ $project->description }}</p>
            </div>

            <div class="project-actions">
                <a href="{{ route('projects.index') }}" class="btn-secondary">Back to projects</a>
                @if($project->repository_link)
                    <a href="{{ $project->repository_link }}" target="_blank" class="btn-secondary">View repository</a>
                @endif
                @if($project->live_demo_link)
                    <a href="{{ $project->live_demo_link }}" target="_blank" class="btn-view">Open live demo</a>
                @endif
            </div>
        </div>

        <div class="content-grid">
            <div>
                <div class="card">
                    <h2 class="section-title">Project overview</h2>
                    <dl class="project-details">
                        <dt>Description</dt>
                        <dd>{{ $project->description }}</dd>

                        <dt>Type</dt>
                        <dd>{{ $project->type ?: 'N/A' }}</dd>

                        <dt>Repository</dt>
                        <dd>
                            @if($project->repository_link)
                                <a href="{{ $project->repository_link }}" target="_blank">{{ $project->repository_link }}</a>
                            @else
                                <span class="empty-state">No repository link provided.</span>
                            @endif
                        </dd>

                        <dt>Live demo</dt>
                        <dd>
                            @if($project->live_demo_link)
                                <a href="{{ $project->live_demo_link }}" target="_blank">{{ $project->live_demo_link }}</a>
                            @else
                                <span class="empty-state">No live demo link provided.</span>
                            @endif
                        </dd>
                    </dl>
                </div>

                <div class="card" style="margin-top:1.5rem;">
                    <h2 class="section-title">Project media</h2>
                    @if($project->media->isNotEmpty())
                        <div class="project-image-grid">
                            @foreach($project->media as $media)
                                <div class="project-image">
                                    <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $project->title }} media" />
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="empty-state">No media uploaded for this project.</p>
                    @endif
                </div>
            </div>

            <aside>
                <div class="card">
                    <h2 class="section-title">Specializations</h2>
                    @if($project->specializations->isNotEmpty())
                        <div class="tags-row">
                            @foreach($project->specializations as $specialization)
                                <span class="project-tag">{{ $specialization->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="empty-state">No specializations selected.</p>
                    @endif
                </div>

                <div class="card" style="margin-top:1.5rem;">
                    <h2 class="section-title">Skills</h2>
                    @if($project->skills->isNotEmpty())
                        <div class="tags-row">
                            @foreach($project->skills as $skill)
                                <span class="project-tag" style="background: #EEF2FF; color: #4338CA;">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="empty-state">No skills added.</p>
                    @endif
                </div>

                <div class="card" style="margin-top:1.5rem;">
                    <h2 class="section-title">Team members</h2>
                    @if($project->team_roles->isNotEmpty())
                        <div class="project-list">
                            @foreach($project->team_roles as $member)
                                <div class="project-list-item">
                                    <div>
                                        <strong>{{ $member->name ?? 'Team member' }}</strong>
                                        <div>{{ $member->email ?? '' }}</div>
                                    </div>
                                    <span>{{ $member->pivot->role ?? 'Member' }}</span>
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
@endsection
