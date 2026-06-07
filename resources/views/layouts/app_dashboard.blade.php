<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DevSpace – Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/toaster.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @yield('head')
</head>

<body class="dashboard-body">

    <div>
        @include('layouts.toaster')
    </div>

    <div class="dashboard-layout">
        @yield('sidebar')

        {{-- Change dashboard-right → main-content --}}
        <div class="main-content">

            <header class="topbar">
                <button class="hamburger" id="hamburgerBtn" aria-label="Toggle navigation" aria-expanded="false"
                    aria-controls="sidebar">
                    <span></span><span></span><span></span>
                </button>

                <h1 class="topbar-title">@yield('page-title', 'Dashboard')</h1>

                <a href="/" class="navbar__link is-active">Home</a>
                <a href="#" class="navbar__link">Projects</a>
                <a href="#" class="navbar__link">Mentors</a>
                <a href="#" class="navbar__link">Developers</a>

                <div class="topbar-actions">
                    <div class="search-wrap" role="search">
                        <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" aria-hidden="true">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                        <label for="globalSearch" class="sr-only">Search</label>
                        <input type="text" id="globalSearch" placeholder="Search..." class="search-box">
                    </div>
                </div>
            </header>

            {{-- Change dashboard-main → page-body --}}
            <main class="page-body">
                @yield('content')
            </main>

        </div>
    </div>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        const hamburger = document.getElementById('hamburgerBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.add('is-open');
            overlay.classList.add('is-visible');
            hamburger.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('is-open');
            overlay.classList.remove('is-visible');
            hamburger.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }

        hamburger.addEventListener('click', () => {
            sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar();
        });

        overlay.addEventListener('click', closeSidebar);

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeSidebar();
        });
    </script>

</body>

</html>
