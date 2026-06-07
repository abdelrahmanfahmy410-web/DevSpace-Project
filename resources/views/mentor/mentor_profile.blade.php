<!DOCTYPE html>
<html>
<head>
    <title>Mentor Profile</title>
    <link rel="stylesheet" href="{{ asset('css/mentor-profile.css') }}">
</head>
<body>

<div class="container">
    <div class="profile-card">

        <div class="header">
            <img src="{{ asset('storage/' . $mentor->profile_photo) }}"
                 alt="Profile Photo"
                 class="profile-image">

            <h1>{{ $mentor->name }}</h1>

            <span class="specialization">
                {{ $mentor->specialization->name }}
            </span>
        </div>

        <div class="info-grid">

            <div class="info-box">
                <h4>Email</h4>
                <p>{{ $mentor->email }}</p>
            </div>

            <div class="info-box">
                <h4>Phone</h4>
                <p>{{ $mentor->phone }}</p>
            </div>

            <div class="info-box">
                <h4>Organization</h4>
                <p>{{ $mentor->organization }}</p>
            </div>

            <div class="info-box">
                <h4>Experience</h4>
                <p>{{ $mentor->experience_years }} Years</p>
            </div>

        </div>

        <div class="linkedin">
            <h4>LinkedIn</h4>
            <a href="{{ $mentor->linkedin_url }}" target="_blank">
                {{ $mentor->linkedin_url }}
            </a>
        </div>

        <div class="bio-section">
            <h3>About Me</h3>
            <p>{{ $mentor->bio }}</p>
        </div>
           
    </div>
</div>

</body>
</html>