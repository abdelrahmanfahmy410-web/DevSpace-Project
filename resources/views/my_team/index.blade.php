{{-- resources/views/teammates/index.blade.php --}}
@extends('layouts.app_dashboard')

@section('page-title', $pageTitle)

@php
    $roleNames = auth()->user()->roles->pluck('name')->map(fn($r) => strtolower($r))->toArray();
    $isDeveloper = in_array('developer', $roleNames);
    $isMentor = in_array('mentor', $roleNames);
@endphp

{{-- ── Sidebar ──────────────────────────────────────────────────────────────── --}}
@section('sidebar')
    @include('layouts.sidebar', ['active' => 'my-team'])
@endsection

{{-- ── Page content ─────────────────────────────────────────────────────────── --}}
@section('content')
    <link rel="stylesheet" href="{{ asset('css/my_team.css') }}">
    <div class="teammates-page">

        {{-- Page header --}}
        <header class="page-header">
            <div class="page-header__meta">
                <span class="page-header__eyebrow">Network</span>
                <h1 class="page-header__title">{{ $pageTitle }}</h1>
                <p class="page-header__sub">
                    Everyone you've worked with across all your projects.
                </p>
            </div>

            <div class="page-header__stats">
                <div class="stat-pill">
                    <span class="stat-pill__value">{{ $teammates->count() }}</span>
                    <span class="stat-pill__label">{{ Str::plural('person', $teammates->count()) }}</span>
                </div>
            </div>
        </header>

        {{-- Empty state --}}
        @if ($teammates->isEmpty())
            <div class="empty-state">
                <div class="empty-state__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="7" r="3" />
                        <path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        <path d="M21 21v-2a4 4 0 0 0-3-3.85" />
                    </svg>
                </div>
                <h2 class="empty-state__heading">No teammates yet</h2>
                <p class="empty-state__body">
                    Once you join or create a project with other members,<br>
                    they'll show up here.
                </p>
                <a href="{{ route('projects.create') }}" class="btn btn--primary">
                    + Start a Project
                </a>
            </div>

            {{-- Teammate grid --}}
        @else
            <div class="teammates-grid">
                @foreach ($teammates as $teammate)
                    <article class="teammate-card">

                        <div class="teammate-card__identity">
                            <a href="{{ route('member.profile', $teammate['id']) }}" class="teammate-card__profile-link">
                                <div class="teammate-card__avatar-wrap">
                                    @if ($teammate['avatar'])
                                        <img class="teammate-card__avatar" src="{{ $teammate['avatar'] }}"
                                            alt="{{ $teammate['name'] }}">
                                    @else
                                        <div class="teammate-card__avatar teammate-card__avatar--initials">
                                            {{ collect(explode(' ', $teammate['name']))->map(fn($w) => strtoupper($w[0]))->take(2)->implode('') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="teammate-card__info">
                                    <h3 class="teammate-card__name">{{ $teammate['name'] }}</h3>
                                    @if ($teammate['headline'])
                                        <p class="teammate-card__headline">{{ $teammate['headline'] }}</p>
                                    @endif
                                    <span class="teammate-card__project-count">
                                        {{ $teammate['projects']->count() }}
                                        {{ Str::plural('project', $teammate['projects']->count()) }} together
                                    </span>
                                </div>
                            </a>
                        </div>

                        <div class="teammate-card__projects">
                            @foreach ($teammate['projects'] as $project)
                                <div class="shared-project">
                                    <a href="{{ route('projects.show', $project->id) }}"
                                        class="shared-project__name">{{ $project->title }}</a>
                                    <span
                                        class="shared-project__role shared-project__role--{{ Str::slug($project->role) }}">
                                        {{ $project->role }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                    </article>
                @endforeach
            </div>
        @endif

    </div>
@endsection
