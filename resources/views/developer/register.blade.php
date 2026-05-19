<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('developer_reg_style.css') }}">
    <title>Register - Developer</title>
</head>
<body>
    <main class="container section section--light">
        <h2 class="heading-2 text-center mb-4">Developer Registration</h2>

        @if ($errors->any())

    <div class="form-error">

        <ul>
            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach
        </ul>

    </div>

@endif

    <form method="POST" action="/developer/register" enctype="multipart/form-data" class="card card--borderless">
        @csrf

        <input type="hidden" name="role" value="developer">

        <div class="form-group">
            <label class="form-label" for="name">Name</label>
            <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus>

            @error('name')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required>

            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <div class="form-group">
            <label class="form-label" for="phone_number">Phone Number</label>
            <input id="phone_number" class="form-input" type="text" name="phone_number" value="{{ old('phone_number') }}">

            @error('phone_number')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <div class="form-group">
            <label class="form-label" for="portfolio_url">Portfolio URL</label>
            <input 
                id="portfolio_url"
                class="form-input"
                type="url"
                name="portfolio_url"
                placeholder="https://yourportfolio.com"
                value="{{ old('portfolio_url') }}"
            >

            @error('portfolio_url')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input id="password" class="form-input" type="password" name="password" required>

            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required>
        </div>

        <br>

        <div class="form-group">
            <label class="form-label" for="bio">Bio</label>
            <textarea id="bio" class="form-textarea" name="bio">{{ old('bio') }}</textarea>

            @error('bio')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <div class="form-group">
            <label class="form-label" for="linkedin_url">LinkedIn Profile</label>
            <input 
                id="linkedin_url"
                class="form-input"
                type="url"
                name="linkedin_url"
                value="{{ old('linkedin_url') }}"
            >

            @error('linkedin_url')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <div class="form-group">
            <label class="form-label" for="profile_picture">Profile Picture</label>
            <input 
                id="profile_picture"
                class="form-input"
                type="file"
                name="profile_picture"
                accept="image/*"
            >

            @error('profile_picture')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>

        <button type="submit" class="btn btn-primary">
            Register as Developer
        </button>

    </form>
    </main>
</body>
</html>