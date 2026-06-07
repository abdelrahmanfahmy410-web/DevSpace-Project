<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DevSpace</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

            @guest
                <a href="{{ route('login') }}" class="btn btn-outline" style="margin-left: 8px;">Sign In</a>
                <a href="{{ route('mentor.register') }}" class="btn btn-primary">Join the Space</a>
            @else
                <div class="navbar__user" style="margin-left: 8px; display: flex; align-items: center; gap: 12px;">

                    {{-- Avatar --}}
                    <div class="navbar__avatar">
                        @if (Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}"
                                style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
                        @else
                            <div
                                style="width: 36px; height: 36px; border-radius: 50%; background: var(--primary);
                                display: flex; align-items: center; justify-content: center;
                                color: white; font-weight: 600; font-size: 14px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    {{-- Name --}}
                    <span style="font-weight: 500;">{{ Auth::user()->name }}</span>

                    {{-- Logout --}}
                    <form method="POST" action="{{-- route('logout') --}}">
                        @csrf
                        <button type="submit" class="btn btn-outline">Log Out</button>
                    </form>
                </div>
            @endguest
        </div>

        <button class="navbar__mobile-toggle" id="mobileToggle" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
    </nav>

    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>

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
                        <a href="#" class="social-btn" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="social-btn" aria-label="Twitter / X">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a href="#" class="social-btn" aria-label="GitHub">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="#" class="social-btn" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
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
</body>

</html>