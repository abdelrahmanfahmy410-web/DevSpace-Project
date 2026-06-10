{{-- resources/views/admin/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin · DevSpace</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @stack('styles')
</head>

<body>

    <nav class="navbar">
        <div class="navbar__logo">
            @include('layouts.logo', ['darkMode' => false])
        </div>
        <div class="navbar__links">
            <span class="badge badge--warning admin-navbar__badge">Admin Panel</span>
            <a href="{{ route('dashboard') }}" class="navbar__link">← Back to App</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline">Log Out</button>
            </form>
        </div>
    </nav>

    <div class="layout">

        <aside class="sidebar admin-sidebar">
            <div class="admin-sidebar__heading">
                <span class="text-label">Navigation</span>
            </div>

            @php
                $adminNav = [
                    ['route' => 'admin.dashboard', 'icon' => 'fa-gauge', 'label' => 'Dashboard'],
                    ['route' => 'admin.projects.index',       'icon' => 'fa-diagram-project',  'label' => 'Projects'],
                    ['route' => 'admin.users.index', 'icon' => 'fa-users', 'label' => 'Users'],
                    ['route' => 'admin.role.index', 'icon' => 'fa-user-shield', 'label' => 'Roles'],
                    ['route' => 'admin.specialization.index', 'icon' => 'fa-layer-group', 'label' => 'Specializations'],
                    ['route' => 'admin.skill.index', 'icon' => 'fa-tags', 'label' => 'Skills'],
                ];
            @endphp

            @foreach ($adminNav as $nav)
                <a href="{{ route($nav['route']) }}"
                    class="admin-sidebar__link {{ request()->routeIs($nav['route']) ? 'admin-sidebar__link--active' : '' }}">
                    <i class="fas {{ $nav['icon'] }} admin-sidebar__icon"></i>
                    {{ $nav['label'] }}
                </a>
            @endforeach
        </aside>

        <main class="layout__main">

            @if (isset($pageTitle))
                <div class="admin-page-header">
                    <div>
                        <h1 class="heading-1">{{ $pageTitle }}</h1>
                        @if (isset($pageSubtitle))
                            <p class="text-muted admin-page-header__sub">{{ $pageSubtitle }}</p>
                        @endif
                    </div>
                    @if (isset($pageAction))
                        {!! $pageAction !!}
                    @endif
                </div>
            @endif

            @if (session('success'))
                <div class="admin-alert admin-alert--success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="admin-alert admin-alert--error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
