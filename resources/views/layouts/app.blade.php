{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DevSpace</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/toaster.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @stack('styles')
</head>

<body>
    <div>
        @include('layouts.toaster')
    </div>

    <nav class="navbar">
        <div class="navbar__logo">
            @include('layouts.logo', ['darkMode' => false])
        </div>

        <div class="navbar__links" id="navLinks">
            <a href="#" class="navbar__link is-active">Home</a>
            <a href="{{ route('projects.index') }}" class="navbar__link">Projects</a>
            <a href="#" class="navbar__link">Mentors</a>
            <a href="#" class="navbar__link">Developers</a>
            @auth
                @if (!($fullWidth ?? false))
                    <a href="{{ route('dashboard') }}" class="navbar__link">Dashboard</a>
                @endif
            @endauth

            @guest
                <a href="{{ route('login') }}" class="btn btn-outline" style="margin-left: 8px;">Sign In</a>
                <a href="{{ route('mentor.register') }}" class="btn btn-primary">Join the Space</a>
            @else
                <div class="navbar__user" style="margin-left: 8px; display: flex; align-items: center; gap: 12px;">
                    <a href="{{ route('member.profile') }}"
                        style="display: flex; align-items: center; gap: 12px; text-decoration: none; color: inherit;">
                        <div class="navbar__avatar">
                            @if (Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}"
                                    style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
                            @else
                                <div
                                    style="width: 36px; height: 36px; border-radius: 50%;
                    background: var(--color-primary);
                    display: flex; align-items: center; justify-content: center;
                    color: white; font-weight: 600; font-size: 14px;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <span style="font-weight: 500;">{{ Auth::user()->name }}</span>
                    </a>

                    {{-- Only show logout when NOT on a dashboard page --}}
                    @if (!($fullWidth ?? false))
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline">Log Out</button>
                        </form>
                    @endif
                </div>
            @endguest
        </div>

        <button class="navbar__mobile-toggle" id="mobileToggle" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
    </nav>

    @auth
        <div class="layout">
            @if ($fullWidth ?? false)
                @include('layouts.sidebar', ['active' => $active ?? ''])
            @endif
            <main class="layout__main">
                @if ($fullWidth ?? false)
                    @yield('content')
                @else
                    <div class="container">
                        @yield('content')
                    </div>
                @endif
            </main>
        </div>
    @else
        <main>
            <div class="container">
                @yield('content')
            </div>
        </main>
    @endauth

    <footer class="footer-extended">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="footer-brand-name">
                        @include('layouts.logo', ['darkMode' => true])
                    </div>
                    <p class="footer-brand-desc">Where developers showcase their work, connect with mentors, and turn
                        side projects into real products.</p>
                    <div class="social-links">
                        <a href="#" class="social-btn" aria-label="LinkedIn"><i
                                class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-btn" aria-label="Twitter / X"><i
                                class="fab fa-x-twitter"></i></a>
                        <a href="#" class="social-btn" aria-label="GitHub"><i class="fab fa-github"></i></a>
                        <a href="#" class="social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>

                <div>
                    <div class="footer-col-title">Platform</div>
                    <div class="footer-col-links">
                        <a href="#" class="footer-col-link">Browse Projects</a>
                        <a href="#" class="footer-col-link">Submit a Project</a>
                        <a href="#" class="footer-col-link">Find Mentors</a>
                        <a href="#" class="footer-col-link">Investor Portal</a>
                    </div>
                </div>

                <div>
                    <div class="footer-col-title">Resources</div>
                    <div class="footer-col-links">
                        <a href="#" class="footer-col-link">Getting Started</a>
                        <a href="#" class="footer-col-link">Pitch Guidelines</a>
                        <a href="#" class="footer-col-link">Success Stories</a>
                        <a href="#" class="footer-col-link">FAQ</a>
                    </div>
                </div>

                <div>
                    <div class="footer-col-title">Company</div>
                    <div class="footer-col-links">
                        <a href="#" class="footer-col-link">About Us</a>
                        <a href="#" class="footer-col-link">Our Team</a>
                        <a href="#" class="footer-col-link">Partners</a>
                        <a href="#" class="footer-col-link">Contact</a>
                        <a href="#" class="footer-col-link">Privacy Policy</a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <span>© 2025 DevSpace · Egypt</span>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
