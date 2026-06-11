@extends('admin.layouts.admin')

@php
    $pageTitle = 'Projects';
    $pageSubtitle = 'All projects submitted on DevSpace';
@endphp

@section('content')

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.projects.index') }}" class="admin-filters">

        <div class="admin-filters__search">
            <i class="fas fa-search admin-filters__search-icon"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title or description…"
                class="admin-filters__input">
        </div>

        <select name="type" class="admin-filters__select">
            <option value="">All Types</option>
            @foreach ($types as $type)
                <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>
                    {{ ucfirst($type) }}
                </option>
            @endforeach
        </select>

        <select name="specialization" class="admin-filters__select">
            <option value="">All Specializations</option>
            @foreach ($specializations as $specialization)
                <option value="{{ $specialization->id }}"
                    {{ request('specialization') == $specialization->id ? 'selected' : '' }}>
                    {{ $specialization->name }}
                </option>
            @endforeach
        </select>

        <select name="sort" class="admin-filters__select">
            <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>Newest First</option>
            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
            <option value="views" {{ request('sort') === 'views' ? 'selected' : '' }}>Most Viewed</option>
        </select>

        <button type="submit" class="btn btn-primary">Filter</button>

        @if (request()->hasAny(['search', 'type', 'specialization', 'sort']))
            <a href="{{ route('admin.projects.index') }}" class="btn btn-outline">Clear</a>
        @endif

    </form>

    {{-- Results Count --}}
    <p class="admin-table__count text-muted">
        Showing {{ $projects->firstItem() }}–{{ $projects->lastItem() }} of {{ $projects->total() }} projects
    </p>

    {{-- Table --}}
    <div class="card admin-table__wrapper">
        <table class="admin-table">
            <thead class="admin-table__head">
                <tr>
                    <th>#</th>
                    <th>Project</th>
                    <th>Type</th>
                    <th>Specializations</th>
                    <th>Skills</th>
                    <th>Team</th>
                    <th>Views</th>
                    <th>Created</th>
                    <th>Links</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr class="admin-table__row">

                        {{-- # --}}
                        <td class="admin-table__cell admin-table__cell--muted">
                            {{ $projects->firstItem() + $loop->index }}
                        </td>

                        {{-- Project --}}
                        <td class="admin-table__cell">
                            <a href="{{ route('admin.projects.show', $project) }}" class="admin-project-cell">
                                <div class="admin-project-cell__title">{{ $project->title }}</div>
                                <div class="admin-project-cell__desc">
                                    {{ Str::limit($project->description, 60) }}
                                </div>
                            </a>
                        </td>
                        {{-- Type --}}
                        <td class="admin-table__cell">
                            <span class="badge badge--prototype">
                                {{ ucfirst($project->type) }}
                            </span>
                        </td>

                        {{-- Specializations --}}
                        <td class="admin-table__cell">
                            <div class="admin-role-list">
                                @forelse($project->specializations->take(2) as $spec)
                                    <span class="badge badge--idea admin-role-list__badge">
                                        {{ $spec->name }}
                                    </span>
                                @empty
                                    <span class="text-muted">—</span>
                                @endforelse
                                @if ($project->specializations->count() > 2)
                                    <span class="badge badge--grey admin-role-list__badge">
                                        +{{ $project->specializations->count() - 2 }}
                                    </span>
                                @endif
                            </div>
                        </td>

                        {{-- Skills --}}
                        <td class="admin-table__cell">
                            <div class="admin-role-list">
                                @forelse($project->skills->take(3) as $skill)
                                    <span class="badge badge--grey admin-role-list__badge">
                                        {{ $skill->name }}
                                    </span>
                                @empty
                                    <span class="text-muted">—</span>
                                @endforelse
                                @if ($project->skills->count() > 3)
                                    <span class="badge badge--grey admin-role-list__badge">
                                        +{{ $project->skills->count() - 3 }}
                                    </span>
                                @endif
                            </div>
                        </td>

                        {{-- Team --}}
                        <td class="admin-table__cell">
                            <div class="admin-team-cell">
                                @forelse($project->team_roles->take(3) as $member)
                                    @if ($member->profile_picture)
                                        <img src="{{ asset('storage/' . $member->profile_picture) }}"
                                            alt="{{ $member->name }}" class="admin-team-cell__avatar"
                                            title="{{ $member->name }}">
                                    @else
                                        <div class="admin-team-cell__avatar admin-team-cell__avatar--placeholder"
                                            title="{{ $member->name }}">
                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                        </div>
                                    @endif
                                @empty
                                    <span class="text-muted">—</span>
                                @endforelse
                                @if ($project->team_roles->count() > 3)
                                    <div class="admin-team-cell__more">
                                        +{{ $project->team_roles->count() - 3 }}
                                    </div>
                                @endif
                            </div>
                        </td>

                        {{-- Views --}}
                        <td class="admin-table__cell">
                            <div class="admin-views-cell">
                                <i class="fas fa-eye admin-views-cell__icon"></i>
                                {{ number_format($project->views) }}
                            </div>
                        </td>

                        {{-- Created --}}
                        <td class="admin-table__cell admin-table__cell--muted">
                            {{ $project->created_at->format('M d, Y') }}
                        </td>

                        {{-- Links --}}
                        <td class="admin-table__cell">
                            <div class="admin-links-cell">
                                @if ($project->repository_link)
                                    <a href="{{ $project->repository_link }}" target="_blank" class="admin-links-cell__btn"
                                        title="Repository">
                                        <i class="fas fa-code-branch"></i>
                                    </a>
                                @endif
                                @if ($project->live_demo_link)
                                    <a href="{{ $project->live_demo_link }}" target="_blank" class="admin-links-cell__btn"
                                        title="Live Demo">
                                        <i class="fas fa-arrow-up-right-from-square"></i>
                                    </a>
                                @endif
                                @if (!$project->repository_link && !$project->live_demo_link)
                                    <span class="text-muted">—</span>
                                @endif
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="admin-table__empty">
                            <i class="fas fa-diagram-project admin-table__empty-icon"></i>
                            No projects found matching your filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($projects->hasPages())
        <div class="admin-pagination">
            <span class="pagination-info">
                Showing {{ $projects->firstItem() }} to {{ $projects->lastItem() }} of {{ $projects->total() }} results
            </span>
            {{ $projects->links() }}
        </div>
    @endif

@endsection
