<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Registration — DevSpace</title>
    <link rel="stylesheet" href="{{ asset('css/css_template.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/investor-register.css') }}">
        <link rel="stylesheet" href="{{ asset('css/toaster.css') }}">

    <link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

@extends('layouts.toaster')
<div class="register-page">
    <div class="register-container">
        <div class="register-header">
            <h1 class="register-title">Developer Registration</h1>
        </div>
<form action="{{ route('developer.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-card">

        <div class="form-card-header">
            <div class="form-card-icon">
                <i class="fa-solid fa-user-tie"></i>
            </div>

            <div>
                <div class="form-card-title">
                Become a Developer
                </div>

                <div class="form-card-sub">
                   Showcase your skills and build your professional profile
                </div>
            </div>
        </div>

        <div class="form-card-body layout-container">

            <!-- LEFT -->

            <div class="left-column">

                <div class="avatar-upload-wrapper">

                    <label class="form-label">
                        Profile Picture
                    </label>

                    <div class="avatar-preview-box"
                        onclick="document.getElementById('profile_picture').click()">

                        <img id="avatarPreview"
                            src=""
                            style="display:none;">

                        <span id="avatarPlaceholder"
                            class="avatar-placeholder">

                            <i class="fa-solid fa-camera"></i>
                            <br>
                            Upload Photo

                        </span>
                    </div>

                    <input
                        id="profile_picture"
                        type="file"
                        name="profile_picture"
                        accept="image/*"
                        style="display:none"
                        onchange="previewAvatar(this)">
                </div>

                <div class="form-group">

                    <label class="form-label">
                        <i class="fa-solid fa-address-card"></i>
                        Bio
                    </label>

                    <textarea
                        name="bio"
                        class="form-textarea"
                        placeholder="Tell us about yourself...">{{ old('bio') }}</textarea>

                </div>

            </div>

            <!-- RIGHT -->

           <div class="right-column">

    <div class="form-group-row">

        <div class="form-group">
            <label class="form-label">
                <i class="fa-solid fa-user"></i>
                Full Name *
            </label>

            <input
                type="text"
                name="name"
                class="form-input"
                placeholder="Enter your full name"
                required>
        </div>

        <div class="form-group">
            <label class="form-label">
                <i class="fa-solid fa-envelope"></i>
                Email Address *
            </label>

            <input
                type="email"
                name="email"
                class="form-input"
                placeholder="example@gmail.com"
                required>
        </div>

    </div>

    <div class="form-group-row">

        <div class="form-group">
            <label class="form-label">
                <i class="fa-solid fa-lock"></i>
                Password *
            </label>

            <input
                type="password"
                name="password"
                class="form-input"
                placeholder="Enter password"
                required>
        </div>

        <div class="form-group">
            <label class="form-label">
                <i class="fa-solid fa-shield-halved"></i>
                Confirm Password *
            </label>

            <input
                type="password"
                name="password_confirmation"
                class="form-input"
                placeholder="Confirm password"
                required>
        </div>

    </div>

    <div class="form-group-row">

        <div class="form-group">
            <label class="form-label">
                <i class="fa-solid fa-phone"></i>
                Phone Number
            </label>

            <input
                type="text"
                name="phone_number"
                class="form-input"
                placeholder="Phone number">
        </div>

        <div class="form-group">
            <label class="form-label">
                <i class="fa-solid fa-code"></i>
                Specialization *
            </label>

            <select
                class="form-select"
                name="specialization_id"
                required>

                <option value="">
                    Select specialization
                </option>

                @foreach($specializations as $specialization)
                    <option value="{{ $specialization->id }}">
                        {{ $specialization->name }}
                    </option>
                @endforeach

            </select>
        </div>

    </div>

    <div class="form-group-row">

        <div class="form-group">
            <label class="form-label">
                <i class="fa-solid fa-globe"></i>
                Portfolio URL
            </label>

            <input
                type="url"
                name="portfolio_url"
                class="form-input"
                placeholder="Portfolio website">
        </div>

        <div class="form-group">
            <label class="form-label">
                <i class="fa-brands fa-linkedin"></i>
                LinkedIn Profile
            </label>

            <input
                type="url"
                name="linkedin_url"
                class="form-input"
                placeholder="LinkedIn profile">
        </div>

    </div>

</div>
        </div>

        <div class="form-footer">

            <div class="form-footer-note">
                <i class="fa-solid fa-circle-check"></i>
                Your information is secure and protected
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-user-plus"></i>
              Register as Developer
            </button>

        </div>

    </div>

</form>  </div>
</div>

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('avatarPreview').src = e.target.result;
                document.getElementById('avatarPreview').style.display = 'block';
                document.getElementById('avatarPlaceholder').style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</body>
</html>