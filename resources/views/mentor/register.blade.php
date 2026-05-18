<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investor Register</title>
</head>
<body>
    <form method="POST" action="{{ route('investor.register') }}" enctype="multipart/form-data">
        @csrf

        {{-- Users table fields --}}
        <div>
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @error('email') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
            @error('password') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>

        {{-- Investors table fields --}}
        <div>
            <label for="bio">Bio</label>
            <textarea id="bio" name="bio">{{ old('bio') }}</textarea>
            @error('bio') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="linkedin">LinkedIn Profile</label>
            <input id="linkedin" type="url" name="linkedin" value="{{ old('linkedin') }}">
            @error('linkedin') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="profile_picture">Profile Picture</label>
            <input id="profile_picture" type="file" name="profile_picture" accept="image/*">
            @error('profile_picture') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="organization">Organization</label>
            <input id="organization" type="text" name="organization" value="{{ old('organization') }}">
            @error('organization') <span>{{ $message }}</span> @enderror
        </div>

        <button type="submit">Register as Investor</button>
    </form>
</body>
</html>