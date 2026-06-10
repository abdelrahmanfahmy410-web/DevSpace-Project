{{-- resources/views/teammates/index.blade.php --}}
@extends('layouts.app_dashboard')

@section('page-title', $pageTitle)

@php
    $roleNames = auth()->user()->roles->pluck('name')->map(fn($r) => strtolower($r))->toArray();
    $isDeveloper = in_array('developer', $roleNames);
    $isMentor    = in_array('mentor', $roleNames);
@endphp

@section('sidebar')
    @include('layouts.sidebar', ['active' => 'my-team'])
@endsection

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
                    <span class="stat-pill__value">{{ $total }}</span>
                    <span class="stat-pill__label">{{ Str::plural('person', $total) }}</span>
                </div>
            </div>
        </header>

        {{-- Toolbar --}}
        <div class="teammates-toolbar">

            {{-- Search --}}
            <div class="search-form__wrap">
                <svg class="search-form__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
                <input
                    class="search-form__input"
                    type="search"
                    id="teammates-search"
                    placeholder="Search by name or headline…"
                    autocomplete="off"
                >
                <button class="search-form__clear" id="search-clear" style="display:none;" title="Clear">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Sort --}}
            <div class="toolbar-sort">
                <label class="toolbar-sort__label" for="sort-select">Sort</label>
                <select class="toolbar-sort__select" id="sort-select">
                    <option value="most">Most collaborated</option>
                    <option value="least">Least collaborated</option>
                    <option value="name">Name A–Z</option>
                </select>
            </div>

        </div>

        {{-- Role filter chips --}}
        @if (!$teammates->isEmpty())
            <div class="filter-chips" id="filter-chips">
                <button class="filter-chip filter-chip--active" data-role="all">All</button>
                @foreach ($roles as $role)
                    <button class="filter-chip" data-role="{{ strtolower($role) }}">
                        {{ ucfirst($role) }}
                    </button>
                @endforeach
            </div>
        @endif

        {{-- Empty state (no teammates at all) --}}
        @if ($teammates->isEmpty())
            <div class="empty-state" id="empty-initial">
                <div class="empty-state__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="7" r="3"/>
                        <path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        <path d="M21 21v-2a4 4 0 0 0-3-3.85"/>
                    </svg>
                </div>
                <h2 class="empty-state__heading">No teammates yet</h2>
                <p class="empty-state__body">
                    Once you join or create a project with other members,<br>they'll show up here.
                </p>
                <a href="{{ route('projects.create') }}" class="btn btn--primary">+ Start a Project</a>
            </div>

        @else
            <div class="teammates-grid" id="teammates-grid">
                @foreach ($teammates as $teammate)
                    <article class="teammate-card"
                        data-name="{{ strtolower($teammate['name']) }}"
                        data-headline="{{ strtolower($teammate['headline'] ?? '') }}"
                        data-roles="{{ strtolower($teammate['roles']) }}"
                        data-count="{{ $teammate['projects']->count() }}">

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
                                    <span class="shared-project__role shared-project__role--{{ Str::slug($project->role) }}">
                                        {{ $project->role }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                    </article>
                @endforeach
            </div>

            {{-- Empty search/filter result --}}
            <div class="empty-state" id="empty-search" style="display:none;">
                <div class="empty-state__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                    </svg>
                </div>
                <h2 class="empty-state__heading">No results found</h2>
                <p class="empty-state__body">Try a different name or role.</p>
            </div>

            {{-- Pagination --}}
            @if ($teammates->hasPages())
                <nav class="pagination-nav" id="pagination-nav">
                    @if ($teammates->onFirstPage())
                        <span class="pagination-nav__btn pagination-nav__btn--disabled">&lsaquo; Prev</span>
                    @else
                        <a class="pagination-nav__btn" href="{{ $teammates->previousPageUrl() }}">&lsaquo; Prev</a>
                    @endif

                    <div class="pagination-nav__pages">
                        @foreach ($teammates->getUrlRange(1, $teammates->lastPage()) as $page => $url)
                            @if ($page == $teammates->currentPage())
                                <span class="pagination-nav__page pagination-nav__page--active">{{ $page }}</span>
                            @else
                                <a class="pagination-nav__page" href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    </div>

                    @if ($teammates->hasMorePages())
                        <a class="pagination-nav__btn" href="{{ $teammates->nextPageUrl() }}">Next &rsaquo;</a>
                    @else
                        <span class="pagination-nav__btn pagination-nav__btn--disabled">Next &rsaquo;</span>
                    @endif
                </nav>
            @endif
        @endif

    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const input       = document.getElementById('teammates-search');
        const clearBtn    = document.getElementById('search-clear');
        const grid        = document.getElementById('teammates-grid');
        const emptySearch = document.getElementById('empty-search');
        const pagination  = document.getElementById('pagination-nav');
        const sortSelect  = document.getElementById('sort-select');
        const chips       = document.querySelectorAll('.filter-chip');

        if (!grid) return;

        let activeRole = 'all';
        let activeSort = 'most';
        let activeQuery = '';

        function getCards() {
            return Array.from(grid.querySelectorAll('.teammate-card'));
        }

        function applyAll() {
            const q = activeQuery.trim().toLowerCase();
            let cards = getCards();

            // 1. Sort
            cards.sort(function (a, b) {
                if (activeSort === 'most')  return b.dataset.count - a.dataset.count;
                if (activeSort === 'least') return a.dataset.count - b.dataset.count;
                if (activeSort === 'name')  return a.dataset.name.localeCompare(b.dataset.name);
            });
            cards.forEach(c => grid.appendChild(c)); // re-order DOM

            // 2. Filter
            let visible = 0;
            cards.forEach(function (card) {
                const nameWords = (card.dataset.name + ' ' + card.dataset.headline).split(/\s+/);
                const matchSearch = q === '' || nameWords.some(w => w.startsWith(q));
                const matchRole   = activeRole === 'all' || card.dataset.roles.split(',').includes(activeRole);

                const show = matchSearch && matchRole;
                card.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            if (emptySearch) emptySearch.style.display = visible === 0 ? '' : 'none';
            if (pagination)  pagination.style.display  = (q === '' && activeRole === 'all') ? '' : 'none';
            if (clearBtn)    clearBtn.style.display     = q !== '' ? '' : 'none';
        }

        // Search
        if (input) {
            input.addEventListener('input', function () {
                activeQuery = this.value;
                applyAll();
            });
        }

        // Clear
        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                input.value = '';
                activeQuery = '';
                applyAll();
                input.focus();
            });
        }

        // Sort
        if (sortSelect) {
            sortSelect.addEventListener('change', function () {
                activeSort = this.value;
                applyAll();
            });
        }

        // Role chips
        chips.forEach(function (chip) {
            chip.addEventListener('click', function () {
                chips.forEach(c => c.classList.remove('filter-chip--active'));
                this.classList.add('filter-chip--active');
                activeRole = this.dataset.role;
                applyAll();
            });
        });

        // Initial sort
        applyAll();
    });
    </script>
@endsection