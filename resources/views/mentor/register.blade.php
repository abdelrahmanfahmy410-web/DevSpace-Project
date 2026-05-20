<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Registration — DevSpace</title>

    <link rel="stylesheet" href="{{ asset('css/css_template.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mentor_register.css') }}">


</head>

<body>

<div class="register-page">

    <div class="register-container">

        {{-- HEADER --}}
        <div class="register-header">

            <div class="register-eyebrow">
                <span class="eyebrow-dot"></span>
                Join as a Mentor
            </div>

            <h1 class="register-title">
                Mentor Registration
            </h1>

            <p class="register-subtitle">
                Share your expertise and help the next generation of developers grow through DevSpace.
            </p>

        </div>

        @if(session('success'))
            <div class="alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                     @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                </ul>
            </div>
        @endif
        <form
            action="{{ route('mentor.store') }}"
            method="POST"
            enctype="multipart/form-data"
            novalidate
        >

            @csrf

            {{-- ACCOUNT CARD --}}
            <div class="form-card">

                <div class="form-card-header">

                    <div class="form-card-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                        </svg>
                    </div>

                    <div>
                        <div class="form-card-title">Account Information</div>
                        <div class="form-card-sub">Your login credentials</div>
                    </div>

                </div>

                <div class="form-card-body">

                    <div class="form-group">

                        <label class="form-label">
                            Full Name <span class="required">*</span>
                        </label>

                        <input
                            class="form-input"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Ahmed Hassan"
                        >

                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            Email Address <span class="required">*</span>
                        </label>

                        <input
                            class="form-input"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="you@example.com"
                        >

                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="form-group-row">

                        <div class="form-group">

                            <label class="form-label">
                                Password <span class="required">*</span>
                            </label>

                            <div class="password-wrapper">

                                <input
                                    class="form-input"
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="••••••••"
                                >

                                <button type="button" class="toggle-password">
                                    👁
                                </button>

                            </div>

                            @error('password')
                                <span class="form-error">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="form-group">

                            <label class="form-label">
                                Confirm Password <span class="required">*</span>
                            </label>

                            <div class="password-wrapper">

                                <input
                                    class="form-input"
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="••••••••"
                                >

                                <button type="button" class="toggle-password">
                                    👁
                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- PROFESSIONAL CARD --}}
            <div class="form-card">

                <div class="form-card-header">

                    <div class="form-card-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M20 6h-2.18c.07-.44.18-.88.18-1.36C18 2.05 15.96 0 13.5 0c-1.32 0-2.4.75-3.5 1.67C8.9.75 7.82 0 6.5 0 4.04 0 2 2.05 2 4.64c0 .48.11.92.18 1.36H0v14h24V6h-4zm-6.5-4c.83 0 1.5.67 1.5 1.5S14.33 5 13.5 5 12 4.33 12 3.5 12.67 2 13.5 2z"/>
                        </svg>
                    </div>

                    <div>
                        <div class="form-card-title">Professional Information</div>
                        <div class="form-card-sub">Tell mentees about your expertise</div>
                    </div>

                </div>

                <div class="form-card-body">

                    <div class="form-group-row">

                        <div class="form-group">

                            <label class="form-label">
                                Organization
                                <span class="optional">(optional)</span>
                            </label>

                            <input
                                class="form-input"
                                type="text"
                                name="organization"
                                value="{{ old('organization') }}"
                                placeholder="Google, ITI, Freelance..."
                            >

                        </div>

                        <div class="form-group">

                            <label class="form-label">
                                Specialization
                                <span class="required">*</span>
                            </label>

                            <select
                                class="form-select"
                                name="specialization_id"
                            >

                                <option value="">
                                    Select specialization
                                </option>

                                @foreach($specializations as $specialization)

                                    <option
                                        value="{{ $specialization->id }}"
                                        @selected(old('specialization_id') == $specialization->id)
                                    >
                                        {{ $specialization->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            Years of Experience
                        </label>

                        <div class="range-row">

                            <input
                                class="form-range"
                                type="range"
                                id="experience_years"
                                name="experience_years"
                                min="0"
                                max="30"
                                value="{{ old('experience_years',0) }}"
                            >

                            <span
                                id="experience-display"
                                class="range-value"
                            >
                                {{ old('experience_years',0) }} yrs
                            </span>

                        </div>

                    </div>

                    <div class="form-group-row">

                        <div class="form-group">

                            <label class="form-label">
                                Phone Number
                            </label>

                            <input
                                class="form-input"
                                type="tel"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="+20 123 456 7890"
                            >

                        </div>

                        <div class="form-group">

                            <label class="form-label">
                                LinkedIn URL
                            </label>

                            <input
                                class="form-input"
                                type="url"
                                name="linkedin_url"
                                value="{{ old('linkedin_url') }}"
                                placeholder="https://linkedin.com/in/yourprofile"
                            >

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            Profile Photo
                        </label>

                        <input
                            class="form-file"
                            type="file"
                            id="profile_picture"
                            name="profile_picture"
                            accept="image/*"
                        >

                        <span class="input-note">
                            Maximum size: 2 MB
                        </span>

                        <img id="profile-preview">

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            Bio
                        </label>

                        <textarea
                            class="form-textarea"
                            name="bio"
                            placeholder="Tell us about yourself..."
                        >{{ old('bio') }}</textarea>

                    </div>

                </div>

                <div class="form-footer">

                    <span class="form-footer-note">
                        <span class="required">*</span>
                        Required fields
                    </span>

                    <div class="form-footer-actions">

                        <a
                            href="{{ url()->previous() }}"
                            class="btn"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Register as Mentor
                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

<script>

    /* EXPERIENCE RANGE */

    const range =
        document.getElementById('experience_years');

    const display =
        document.getElementById('experience-display');

    range.addEventListener('input', function () {

        display.textContent =
            this.value + ' yrs';

    });

    /* PASSWORD TOGGLE */

    document
        .querySelectorAll('.toggle-password')
        .forEach(button => {

            button.addEventListener('click', () => {

                const input =
                    button.previousElementSibling;

                input.type =
                    input.type === 'password'
                    ? 'text'
                    : 'password';

            });

        });

    /* IMAGE PREVIEW */

    const profileInput =
        document.getElementById('profile_picture');

    const preview =
        document.getElementById('profile-preview');

    profileInput.addEventListener('change', function () {

        if(!this.files || !this.files[0]) return;

        const file = this.files[0];

        preview.src =
            URL.createObjectURL(file);

        preview.style.display = 'block';

    });

</script>

</body>
</html>