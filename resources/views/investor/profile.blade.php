<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/investor-register.css') }}">
    <title>Register - Investor</title>
</head>
<body>
    <main class="register-page">
        <div class="register-container">
            
            <header class="register-header">
                <div class="register-eyebrow">
                    <span class="eyebrow-dot"></span>
                    Join Us
                </div>
                <h2 class="register-title">Investor Registration</h2>
                <p class="register-subtitle">Join ITI Hive to discover and connect with graduate projects.</p>
            </header>

            @if ($errors->any())
                <div class="form-card" style="border-color: var(--color-accent); background: var(--color-accent-bg); padding: 16px; margin-bottom: 20px;">
                    <ul style="list-style-position: inside; color: var(--color-accent); font-size: 14px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="/investor/register" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="role" value="investor">

                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon">
                            <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        <div>
                            <h3 class="form-card-title">Account Information</h3>
                            <p class="form-card-sub">Your login credentials</p>
                        </div>
                    </div>
                    
                    <div class="form-card-body">
                        <div class="form-group-row">
                            <div class="form-group">
                                <label class="form-label" for="name">
                                    Full Name <span class="required">*</span>
                                </label>
                                <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus>
                                @error('name') <span style="color: var(--color-accent); font-size: 12px;">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="email">
                                    Email <span class="required">*</span>
                                </label>
                                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required>
                                @error('email') <span style="color: var(--color-accent); font-size: 12px;">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-group-row">
                            <div class="form-group">
                                <label class="form-label" for="organization">
                                    Organization <span class="optional">(Optional)</span>
                                </label>
                                <input id="organization" class="form-input" type="text" name="organization" value="{{ old('organization') }}" placeholder="Firm, incubator, or institution">
                                @error('organization') <span style="color: var(--color-accent); font-size: 12px;">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="linkedin">
                                    LinkedIn Profile <span class="optional">(Optional)</span>
                                </label>
                                <input id="linkedin" class="form-input" type="url" name="linkedin" value="{{ old('linkedin') }}" placeholder="https://linkedin.com/in/username">
                                @error('linkedin') <span style="color: var(--color-accent); font-size: 12px;">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-group-row">
                            <div class="form-group">
                                <label class="form-label" for="password">
                                    Password <span class="required">*</span>
                                </label>
                                <input id="password" class="form-input" type="password" name="password" required>
                                @error('password') <span style="color: var(--color-accent); font-size: 12px;">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password_confirmation">
                                    Confirm Password <span class="required">*</span>
                                </label>
                                <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon">
                            <svg viewBox="0 0 24 24"><path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z"/></svg>
                        </div>
                        <div>
                            <h3 class="form-card-title">Investor Profile</h3>
                            <p class="form-card-sub">Tell us about your investment focus and background</p>
                        </div>
                    </div>

                    <div class="form-card-body">
                        <div class="form-group">
                            <label class="form-label" for="bio">Bio</label>
                            <textarea id="bio" class="form-textarea" name="bio" placeholder="Share a brief bio or investment focus...">{{ old('bio') }}</textarea>
                            @error('bio') <span style="color: var(--color-accent); font-size: 12px;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="profile_picture">Profile Picture</label>
                            <input id="profile_picture" class="form-input" type="file" name="profile_picture" accept="image/*">
                            @error('profile_picture') <span style="color: var(--color-accent); font-size: 12px;">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-footer">
                        <div class="form-footer-note">
                            <span class="required">*</span> Indicates required fields
                        </div>
                        <div class="form-footer-actions">
                            <button type="submit" class="btn btn-primary">
                                Create Investor Account
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="login-link">
                Already have an account? <a href="/login">Log in</a>
            </div>

        </div>
    </main>
</body>
</html>