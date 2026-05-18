<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <label for="name">Name</label>
            <input id="name" type="text" name="name" required autofocus>
        </div>
        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" required>
        </div>
      
        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
        </div>
        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>
<!-- //bio -->
<div>
    <label for="bio">Bio</label>
    <textarea id="bio" name="bio"></textarea>
</div>
<!-- //linkedin -->
<div>
    <label for="linkedin">LinkedIn Profile</label>
    <input id="linkedin" type="url" name="linkedin">
</div>
    <!-- //profile picture -->
<div>
    <label for="profile_picture">Profile Picture</label>
    <input id="profile_picture" type="file" name="profile_picture">
</div>
<!-- / select role mentor show expereince year -->

        <button type="submit">Register</button>
</body>
</html>