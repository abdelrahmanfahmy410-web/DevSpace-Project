{{-- resources/views/layouts/sidebar.blade.php --}}
{{-- Usage: @include('layouts.sidebar', ['active' => 'dashboard']) --}}

@php
    $roleNames = auth()->user()->roles->pluck('name')->map(fn($r) => strtolower($r))->toArray();
    $isDeveloper = in_array('developer', $roleNames);
    $isMentor    = in_array('mentor', $roleNames);
    $isInvestor  = in_array('investor', $roleNames);

    // $active is passed in from the parent blade, e.g. 'dashboard', 'my-projects', 'my-team', 'mentees', 'wishlist', 'chats', 'settings'
    $active = $active ?? '';
@endphp

<aside class="sidebar" id="sidebar" role="navigation" aria-label="Main navigation">

    <div class="sidebar-brand">
        @include('layouts.logo', ['darkMode' => false])
    </div>

    <nav class="sidebar-menu" aria-label="Workspace navigation">

        <p class="menu-title" role="heading" aria-level="3">MY WORKSPACE</p>

        <a href="{{ route('dashboard') }}" @class(['menu-link', 'active' => $active === 'dashboard'])
            @if($active === 'dashboard') aria-current="page" @endif>
            <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7" />
                <rect x="14" y="3" width="7" height="7" />
                <rect x="3" y="14" width="7" height="7" />
                <rect x="14" y="14" width="7" height="7" />
            </svg>
            Dashboard
        </a>

        @if ($isDeveloper || $isMentor)
            <a href="{{ route('projects.my') }}" @class(['menu-link', 'active' => $active === 'my-projects'])
                @if($active === 'my-projects') aria-current="page" @endif>
                <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z" />
                    <polyline points="13 2 13 9 20 9" />
                </svg>
                My Projects
            </a>
        @endif

        @if ($isDeveloper || $isMentor)
            <a href="#" @class(['menu-link', 'active' => $active === 'assigned'])
                @if($active === 'assigned') aria-current="page" @endif>
                <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 11l3 3L22 4" />
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                </svg>
                Assigned Project
            </a>
        @endif

        @if ($isDeveloper || $isMentor)
            <a href="{{ route('my_team.index') }}" @class(['menu-link', 'active' => $active === 'my-team'])
                @if($active === 'my-team') aria-current="page" @endif>
                <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                My Team
            </a>
        @endif

        @if ($isMentor)
            <a href="{{ route('mentees.index') }}" @class(['menu-link', 'active' => $active === 'mentees'])
                @if($active === 'mentees') aria-current="page" @endif>
                <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                My Developers
            </a>
        @endif

        <a href="#" @class(['menu-link', 'active' => $active === 'wishlist'])
            @if($active === 'wishlist') aria-current="page" @endif>
            <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
            </svg>
            My Wishlist Projects
        </a>

        <a href="#" @class(['menu-link', 'active' => $active === 'chats'])
            @if($active === 'chats') aria-current="page" @endif>
            <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
            </svg>
            My Chats
        </a>

        <p class="menu-title" role="heading" aria-level="3">ACCOUNT</p>

        <a href="#" @class(['menu-link', 'active' => $active === 'settings'])
            @if($active === 'settings') aria-current="page" @endif>
            <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="3" />
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
            </svg>
            Settings
        </a>

        <a href="#" class="menu-link menu-link--danger"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                <polyline points="16 17 21 12 16 7" />
                <line x1="21" y1="12" x2="9" y2="12" />
            </svg>
            Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>

    </nav>

    <div class="sidebar-footer">
        <div class="avatar avatar--sm" aria-hidden="true">
            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
        </div>
        <div class="sidebar-user">
            <strong>{{ auth()->user()->name }}</strong>
            <span class="sidebar-user-role">
                {{ auth()->user()->roles->pluck('name')->implode(', ') }}
            </span>
        </div>
    </div>

</aside>