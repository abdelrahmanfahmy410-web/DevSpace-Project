@extends('layouts.app')

@section('content')
    <style>
        /* إعدادات الخلفية العامة المتناسقة مع الصورة */
        body {
            background-color: #F8FAFC;
            color: #334155;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        .project-page {
            padding: 3rem 0;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* الهيدر العلوي ومسار التنقل */
        .project-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 1.5rem;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .project-title {
            margin: 0.5rem 0 0.25rem 0;
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
            color: #0F172A;
            letter-spacing: -0.02em;
        }

        .project-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
        }

        /* تصميم البادج العلوي مثل الصورة تماماً */
        .project-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 6px;
            padding: 0.35rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: #E6F4EA;
            color: #10B981;
        }

        .project-badge.other {
            background: #EEF2FF;
            color: #4F46E5;
        }

        /* أزرار الأكشنز الاحترافية */
        .project-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .btn-view,
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-view {
            background: #10B981;
            color: #ffffff;
            border: 1px solid transparent;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .btn-view:hover {
            background: #059669;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #ffffff;
            color: #475569;
            border: 1px solid #E2E8F0;
        }

        .btn-secondary:hover {
            background: #F1F5F9;
            color: #0F172A;
            border-color: #CBD5E1;
        }

        /* تقسيم الصفحة - Grid */
        .content-grid {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(340px, 1fr);
            gap: 2rem;
        }

        /* تصميم الكارد المحدث بحواف دائرية ناعمة وظل خفيف جداً */
        .card {
            background: #ffffff;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 10px 15px -3px rgba(0, 0, 0, 0.03);
        }

        .section-title {
            margin: 0 0 1.5rem 0;
            font-size: 1.25rem;
            color: #0F172A;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .project-description {
            color: #475569;
            line-height: 1.8;
            font-size: 1.05rem;
        }

        /* تفاصيل المشروع (جدول البيانات الأساسية) */
        .project-details dt {
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 1.5rem;
            color: #94A3B8;
        }

        .project-details dd {
            margin: 0.5rem 0 0 0;
            color: #334155;
            font-size: 1.05rem;
        }
        
        .project-details dd a {
            color: #10B981;
            text-decoration: none;
            word-break: break-all;
        }
        .project-details dd a:hover {
            text-decoration: underline;
        }

        /* تصميم الـ Tags (التخصصات والمهارات مثل الصورة) */
        .tags-title {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94A3B8;
            margin-bottom: 0.75rem;
        }

        .tags-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .project-tag {
            display: inline-flex;
            align-items: center;
            border-radius: 6px;
            padding: 0.4rem 0.75rem;
            font-size: 0.85rem;
            font-weight: 500;
            background: #F1F5F9;
            color: #475569;
            border: 1px solid #E2E8F0;
        }

        .project-tag.specialization {
            background: #EFF6FF;
            color: #2563EB;
            border-color: #DBEAFE;
        }

        .project-tag.skill {
            background: #E6F4EA;
            color: #059669;
            border-color: #D1FAE5;
        }

        /* قائمة أعضاء الفريق الكلاسيكية والأنيقة */
        .project-list {
            display: grid;
            gap: 1rem;
        }

        .project-list-item {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .member-info strong {
            color: #0F172A;
            font-size: 0.95rem;
            display: block;
        }

        .member-info span {
            color: #64748B;
            font-size: 0.85rem;
        }

        .member-role {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            color: #475569;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
        }

        /* قسم الميديا والصور */
        .project-image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .project-image {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            aspect-ratio: 16 / 10;
            background: #F1F5F9;
            border: 1px solid #E2E8F0;
            transition: transform 0.2s ease;
        }

        .project-image:hover {
            transform: scale(1.02);
        }

        .project-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .empty-state {
            color: #94A3B8;
            font-size: 0.95rem;
            font-style: italic;
            margin: 0;
        }

        /* متوافق مع الموبايل والشاشات الصغيرة */
        @media (max-width: 900px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            .project-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .project-actions {
                width: 100%;
            }
            .project-actions .btn-view, 
            .project-actions .btn-secondary {
                flex: 1;
                text-align: center;
            }
        }
    </style>

    <section class="project-page">
        <!-- الهيدر العلوي -->
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
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to projects
                </a>
                @if($project->repository_link)
                    <a href="{{ $project->repository_link }}" target="_blank" class="btn-secondary">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        Repo
                    </a>
                @endif
                @if($project->live_demo_link)
                    <a href="{{ $project->live_demo_link }}" target="_blank" class="btn-view">
                        Open live demo
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                @endif
            </div>
        </div>
<!-- {{$project}} -->
        <!-- الجريد الأساسي للمحتوى -->
        <div class="content-grid">
            <!-- الجزء الأيسر: التفاصيل والميديا -->
            <div>
                <div class="card">
                    <h2 class="section-title">
                        <svg width="20" height="20" fill="none" stroke="#10B981" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Project overview
                    </h2>
                    
                    <div class="project-description">
                        {{ $project->description }}
                    </div>

                    <dl class="project-details">
                        <dt>Repository Link</dt>
                        <dd>
                            @if($project->repository_link)
                                <a href="{{ $project->repository_link }}" target="_blank">{{ $project->repository_link }}</a>
                            @else
                                <span class="empty-state">No repository link provided.</span>
                            @endif
                        </dd>

                        <dt>Live Demo</dt>
                        <dd>
                            @if($project->live_demo_link)
                                <a href="{{ $project->live_demo_link }}" target="_blank">{{ $project->live_demo_link }}</a>
                            @else
                                <span class="empty-state">No live demo link provided.</span>
                            @endif
                        </dd>
                    </dl>
                </div>

                <div class="card" style="margin-top: 1.5rem;">
                    <h2 class="section-title">
                        <svg width="20" height="20" fill="none" stroke="#10B981" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Project media
                    </h2>
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

            <!-- الجزء الأيمن (Sidebar): التخصصات والمهارات وأعضاء الفريق -->
            <aside>
                <div class="card">
                    <!-- التخصصات -->
                    <div class="tags-title">Specializations</div>
                    @if($project->specializations->isNotEmpty())
                        <div class="tags-row">
                            @foreach($project->specializations as $specialization)
                                <span class="project-tag specialization">{{ $specialization->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="empty-state" style="margin-bottom: 1.5rem;">No specializations selected.</p>
                    @endif

                    <!-- المهارات -->
                    <div class="tags-title" style="margin-top: 1.5rem;">Skills</div>
                    @if($project->skills->isNotEmpty())
                        <div class="tags-row" style="margin-bottom: 0;">
                            @foreach($project->skills as $skill)
                                <span class="project-tag skill">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="empty-state">No skills added.</p>
                    @endif
                </div>

                <!-- أعضاء الفريق -->
                <div class="card" style="margin-top: 1.5rem;">
                    <h2 class="section-title">
                        <svg width="20" height="20" fill="none" stroke="#10B981" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Team members
                    </h2>
                    @if($project->team_roles->isNotEmpty())
                        <div class="project-list">
                            @foreach($project->team_roles as $member)
                                <div class="project-list-item">
                                    <div class="member-info">
                                        <strong>{{ $member->name ?? 'Team member' }}</strong>
                                        <span>{{ $member->email ?? '' }}</span>
                                    </div>
                                    <div class="member-role">
                                        {{ $member->pivot->role ?? 'Member' }}
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
@endsection