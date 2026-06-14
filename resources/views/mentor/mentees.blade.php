{{-- resources/views/mentees/index.blade.php --}}
@extends('layouts.app_dashboard')

@section('page-title', 'My Developers')

@section('sidebar')
    @include('layouts.sidebar', ['active' => 'mentees'])
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/mentees.css') }}">
<div class="mentees-page">

    {{-- Page header --}}
    <header class="page-header">
        <div class="page-header__meta">
            <span class="page-header__eyebrow">Mentorship</span>
            <h1 class="page-header__title">My Developers</h1>
            <p class="page-header__sub">
                Developers you have mentored across your projects.
            </p>
        </div>
        <div class="page-header__stats">
            <div class="stat-pill">
                <span class="stat-pill__value">{{ $total }}</span>
                <span class="stat-pill__label">{{ Str::plural('developer', $total) }}</span>
            </div>
        </div>
    </header>

    @if (!$mentees->isEmpty())
        {{-- Toolbar --}}
        <div class="teammates-toolbar">
            <div class="search-form__wrap">
                <svg class="search-form__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
                <input
                    class="search-form__input"
                    type="search"
                    id="mentees-search"
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

            <div class="toolbar-sort">
                <label class="toolbar-sort__label" for="sort-select">Sort</label>
                <select class="toolbar-sort__select" id="sort-select">
                    <option value="most">Most collaborated</option>
                    <option value="least">Least collaborated</option>
                    <option value="name">Name A–Z</option>
                </select>
            </div>
        </div>
    @endif

    {{-- Empty state --}}
    @if ($mentees->isEmpty())
        <div class="empty-state">
            <div class="mentees-empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="7" r="3"/>
                    <path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    <path d="M21 21v-2a4 4 0 0 0-3-3.85"/>
                </svg>
            </div>
            <h2 class="empty-state__heading">No developers yet</h2>
            <p class="empty-state__body">
                Once you mentor developers on a project,<br>they'll appear here.
            </p>
            <a href="{{ route('projects.index') }}" class="btn btn-primary">Browse Projects</a>
        </div>

    @else
        <div class="mentees-list" id="mentees-list">
            @foreach ($mentees as $mentee)
                <article class="mentee-card"
                    data-name="{{ strtolower($mentee['name']) }}"
                    data-headline="{{ strtolower($mentee['headline'] ?? '') }}"
                    data-count="{{ $mentee['projects']->count() }}">

                    {{-- Left: avatar + identity --}}
                    <div class="mentee-card__left">
                        @if ($mentee['avatar'])
                            <img class="mentee-card__avatar" src="{{ $mentee['avatar'] }}" alt="{{ $mentee['name'] }}">
                        @else
                            <div class="mentee-card__avatar mentee-card__avatar--initials">
                                {{ collect(explode(' ', $mentee['name']))->map(fn($w) => strtoupper($w[0]))->take(2)->implode('') }}
                            </div>
                        @endif

                        <div class="mentee-card__identity">
                            <h3 class="mentee-card__name">{{ $mentee['name'] }}</h3>
                            @if ($mentee['headline'])
                                <p class="mentee-card__headline">{{ $mentee['headline'] }}</p>
                            @endif
                            <span class="mentee-card__badge">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/>
                                </svg>
                                Developer
                            </span>
                        </div>
                    </div>

                    {{-- Middle: shared projects --}}
                    <div class="mentee-card__projects">
                        <p class="mentee-card__projects-label">Shared Projects</p>
                        <div class="mentee-card__projects-list">
                            @foreach ($mentee['projects'] as $project)
                                <a href="{{ route('projects.show', $project->id) }}" class="mentee-project-chip">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/>
                                        <polyline points="13 2 13 9 20 9"/>
                                    </svg>
                                    {{ $project->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Right: actions --}}
                    <div class="mentee-card__actions">
                        <a href="#" class="mentee-btn mentee-btn--message" title="Send Message">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                            </svg>
                            Message
                        </a>
                        <a href="/member/profile/{{ $mentee['id'] }}" class="mentee-btn mentee-btn--profile" title="View Profile">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            View Profile
                        </a>
                        <a href="#" class="mentee-btn mentee-btn--projects" title="Shared Projects">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/>
                                <polyline points="13 2 13 9 20 9"/>
                            </svg>
                            {{ $mentee['projects']->count() }} {{ Str::plural('Project', $mentee['projects']->count()) }}
                        </a>
                    </div>

                </article>
            @endforeach
        </div>

        {{-- Empty search result --}}
        <div class="empty-state" id="empty-search" style="display:none;">
            <div class="mentees-empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
            </div>
            <h2 class="empty-state__heading">No results found</h2>
            <p class="empty-state__body">Try a different name or headline.</p>
        </div>

    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input       = document.getElementById('mentees-search');
    const clearBtn    = document.getElementById('search-clear');
    const list        = document.getElementById('mentees-list');
    const emptySearch = document.getElementById('empty-search');
    const sortSelect  = document.getElementById('sort-select');

    if (!list) return;

    let activeSort  = 'most';
    let activeQuery = '';

    function getCards() {
        return Array.from(list.querySelectorAll('.mentee-card'));
    }

    function applyAll() {
        const q = activeQuery.trim().toLowerCase();
        let cards = getCards();

        // Sort
        cards.sort(function (a, b) {
            if (activeSort === 'most')  return b.dataset.count - a.dataset.count;
            if (activeSort === 'least') return a.dataset.count - b.dataset.count;
            if (activeSort === 'name')  return a.dataset.name.localeCompare(b.dataset.name);
        });
        cards.forEach(c => list.appendChild(c));

        // Filter
        let visible = 0;
        cards.forEach(function (card) {
            const words      = (card.dataset.name + ' ' + card.dataset.headline).split(/\s+/);
            const matchSearch = q === '' || words.some(w => w.startsWith(q));
            card.style.display = matchSearch ? '' : 'none';
            if (matchSearch) visible++;
        });

        if (emptySearch) emptySearch.style.display = visible === 0 ? '' : 'none';
        if (clearBtn)    clearBtn.style.display     = q !== '' ? '' : 'none';
    }

    if (input) {
        input.addEventListener('input', function () {
            activeQuery = this.value;
            applyAll();
        });
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            input.value = '';
            activeQuery = '';
            applyAll();
            input.focus();
        });
    }

    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            activeSort = this.value;
            applyAll();
        });
    }

    applyAll();
});
</script>
@endsection