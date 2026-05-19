<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Registration — ITI Hive</title>
    <link rel="stylesheet" href="{{ asset('css/css_template.css') }}">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: var(--space-5);
        }
        .form-container {
            width: 100%;
            max-width: 560px;
        }
        .form-header {
            text-align: center;
            margin-bottom: var(--space-7);
        }
        .form-header h1 {
            margin: 0 0 var(--space-1);
            font-size: var(--font-size-h1);
            color: var(--color-dark-navy);
            font-weight: var(--font-weight-bold);
        }
        .form-header p {
            margin: 0;
            color: var(--color-muted);
            font-size: var(--font-size-body);
        }
        .alert {
            margin-bottom: var(--space-5);
            padding: var(--space-3) var(--space-4);
            border-radius: var(--radius-card);
        }
        .alert-success {
            background-color: var(--color-success-bg);
            color: var(--color-success-text);
        }
        .form-group {
            margin-bottom: var(--space-5);
        }
        .form-group label {
            display: block;
            margin-bottom: var(--space-2);
            font-weight: var(--font-weight-semibold);
            color: var(--color-body-text);
            font-size: var(--font-size-body);
        }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="url"],
        .form-group input[type="tel"],
        .form-group input[type="file"],
        .form-group input[type="range"],
        .form-group textarea {
            width: 100%;
            padding: var(--space-2) var(--space-3);
            background-color: var(--color-white);
            font-size: var(--font-size-body);
            font-family: var(--font-family-base);
            border: none;
            border-radius: var(--radius-md);
        }
        .form-group textarea {
            resize: vertical;
            min-height: 120px;
            line-height: var(--line-height-base);
        }
        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus,
        .form-group input[type="url"]:focus,
        .form-group input[type="tel"]:focus,
        .form-group textarea:focus {
            outline: none;
            background-color: var(--color-primary-bg);
        }
        .form-group input[type="file"] {
            padding: var(--space-3);
            cursor: pointer;
        }
        .form-group input[type="file"]::file-selector-button {
            background-color: var(--color-primary);
            color: var(--color-white);
            padding: var(--space-1) var(--space-3);
            border: none;
            border-radius: var(--radius-md);
            cursor: pointer;
            font-weight: var(--font-weight-medium);
            margin-right: var(--space-2);
        }
        .form-group input[type="file"]::file-selector-button:hover {
            background-color: var(--color-primary-light);
        }
        .form-group input[type="range"] {
            padding: 0;
            height: 6px;
            accent-color: var(--color-primary);
            border: none;
            box-shadow: none;
        }
        .experience-display {
            display: inline-block;
            margin-left: var(--space-3);
            font-weight: var(--font-weight-semibold);
            color: var(--color-primary);
            min-width: 60px;
            font-size: var(--font-size-body);
        }
        .form-error {
            display: block;
            margin-top: var(--space-1);
            color: var(--color-error-text);
            font-size: var(--font-size-meta);
        }
        .form-divider {
            margin: var(--space-6) 0;
            border: none;
            background: none;
        }
        .form-actions {
            display: flex;
            gap: var(--space-3);
            margin-top: var(--space-6);
        }
        .btn {
            flex: 1;
            padding: var(--space-2) var(--space-4);
            border-radius: var(--radius-md);
            font-size: var(--font-size-small);
            font-weight: var(--font-weight-medium);
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-base);
            border: none;
        }
        .btn-secondary {
            background-color: var(--color-primary-bg);
            color: var(--color-primary);
        }
        .btn-secondary:hover {
            background-color: var(--color-primary);
            color: var(--color-white);
        }
        .btn-primary {
            background-color: var(--color-primary);
            color: var(--color-white);
        }
        .btn-primary:hover {
            background-color: var(--color-primary-light);
        }
        .optional-label {
            font-weight: var(--font-weight-regular);
            color: var(--color-muted);
        }
        fieldset {
         border: none;
         padding: 0;
         margin: 0;
        }
    </style>
</head>
<body>

<div class="form-container">
    <div class="form-header">
        <h1>Mentor Registration</h1>
        <p>Create your mentor profile to get started</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('mentor.store') }}" method="POST" novalidate enctype="multipart/form-data">
        @csrf

        <!-- Account Information Section -->
        <fieldset>
            <legend style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem; display: none;">Account Information</legend>

            <div class="form-group">
                <label for="name">Full Name <span aria-label="required">*</span></label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="e.g. Ahmed Hassan"
                    required
                    aria-describedby="name-error"
                >
                @error('name')
                    <span id="name-error" class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address <span aria-label="required">*</span></label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="you@example.com"
                    required
                    aria-describedby="email-error"
                >
                @error('email')
                    <span id="email-error" class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password <span aria-label="required">*</span></label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    aria-describedby="password-error"
                >
                @error('password')
                    <span id="password-error" class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password <span aria-label="required">*</span></label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="••••••••"
                    required
                >
            </div>
        </fieldset>

        <hr class="form-divider">

        <!-- Professional Information Section -->
        <fieldset>
            <legend style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem; display: none;">Professional Information</legend>

            <div class="form-group">
                <label for="organization">Organization <span class="optional-label">(optional)</span></label>
                <input
                    type="text"
                    id="organization"
                    name="organization"
                    value="{{ old('organization') }}"
                    placeholder="e.g. Google, ITI, Freelance"
                    aria-describedby="organization-error"
                >
                @error('organization')
                    <span id="organization-error" class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="experience_years">Years of Experience <span aria-label="required">*</span></label>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <input
                        type="range"
                        id="experience_years"
                        name="experience_years"
                        min="0"
                        max="30"
                        value="{{ old('experience_years', 0) }}"
                        required
                        aria-describedby="experience-display experience-error"
                    >
                    <span id="experience-display" class="experience-display">{{ old('experience_years', 0) }} yrs</span>
                </div>
                @error('experience_years')
                    <span id="experience-error" class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone Number <span class="optional-label">(optional)</span></label>
                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="e.g. +20 123 456 7890"
                    aria-describedby="phone-error"
                >
                @error('phone')
                    <span id="phone-error" class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="profile_photo">Profile Photo <span class="optional-label">(optional)</span></label>
                <input
                    type="file"
                    id="profile_photo"
                    name="profile_photo"
                    accept="image/*"
                    aria-describedby="profile-photo-error"
                >
                @error('profile_photo')
                    <span id="profile-photo-error" class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="bio">Bio <span class="optional-label">(optional)</span></label>
                <textarea
                    id="bio"
                    name="bio"
                    placeholder="Tell us about yourself, your expertise, and what you're passionate about..."
                    aria-describedby="bio-error"
                >{{ old('bio') }}</textarea>
                @error('bio')
                    <span id="bio-error" class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="linkedin_url">LinkedIn URL <span class="optional-label">(optional)</span></label>
                <input
                    type="url"
                    id="linkedin_url"
                    name="linkedin_url"
                    value="{{ old('linkedin_url') }}"
                    placeholder="https://www.linkedin.com/in/yourprofile"
                    aria-describedby="linkedin-url-error"
                >
                @error('linkedin_url')
                    <span id="linkedin-url-error" class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </fieldset>

        <!-- Form Actions -->
        <div class="form-actions">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Register as Mentor</button>
        </div>

    </form>
</div>

<script>
    // Update experience display on input
    document.getElementById('experience_years').addEventListener('input', function() {
        document.getElementById('experience-display').textContent = this.value + ' yrs';
    });
</script>

</body>
</html>