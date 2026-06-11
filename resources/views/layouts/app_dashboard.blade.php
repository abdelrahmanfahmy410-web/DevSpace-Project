@extends('layouts.app')
@php($fullWidth = true)

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DevSpace – Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/css_template.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/toaster.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @yield('head')
</head>
@section('title', 'Dashboard')

@section('content')
    <header class="topbar">
        <button class="hamburger" id="hamburgerBtn" aria-label="Toggle navigation"
            aria-expanded="false" aria-controls="sidebar">
            <span></span><span></span><span></span>
        </button>

        <h1 class="topbar-title">@yield('page-title', 'Dashboard')</h1>

        <div class="navbar__user">
            <div class="navbar__avatar">
                @if(Auth::user()->avatar)
                    <img class="navbar__avatar-initials"
                        src="{{ asset('storage/' . Auth::user()->avatar) }}"
                        alt="{{ Auth::user()->name }}">
                @else
                    <div class="navbar__avatar-initials">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <span style="font-weight:500;">{{ Auth::user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline">Log Out</button>
            </form>
        </div>
    </header>

    @include('layouts.toaster')

    <main class="page-body">
        @yield('dashboard-content')
    </main>
@endsection

@push('scripts')
<script>
    const hamburger = document.getElementById('hamburgerBtn');
    const sidebar   = document.getElementById('sidebar');
    const overlay   = document.getElementById('sidebarOverlay');

    const openSidebar  = () => { sidebar.classList.add('is-open'); overlay.classList.add('is-visible'); hamburger.setAttribute('aria-expanded','true'); document.body.style.overflow='hidden'; };
    const closeSidebar = () => { sidebar.classList.remove('is-open'); overlay.classList.remove('is-visible'); hamburger.setAttribute('aria-expanded','false'); document.body.style.overflow=''; };

    hamburger.addEventListener('click', () => sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar());
    overlay.addEventListener('click', closeSidebar);
    document.addEventListener('keydown', e => e.key === 'Escape' && closeSidebar());
</script>
@endpush