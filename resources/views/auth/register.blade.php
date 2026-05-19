<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Developer</title>
    <style>
        .error-box { color: red; background: #f8d7da; padding: 10px; margin-bottom: 15px; border-radius: 5px; }
    </style>
</head>
<body>

    <h2>Developer Registration</h2>

    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/developer/register" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
        </div>
        
        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        </div>
      
        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
        </div>
        
        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>

        <div>
            <label for="bio">Bio</label>
            <textarea id="bio" name="bio">{{ old('bio') }}</textarea>
        </div>

        <div>
            <label for="linkedin_url">LinkedIn Profile</label>
            <input id="linkedin_url" type="url" name="linkedin_url" value="{{ old('linkedin_url') }}">
        </div>

  <div>
    <label for="specialization_id">Specialization</label>
    <select id="specialization_id" name="specialization_id" required>
        <option value="">-- Select Specialization --</option>
        
        @foreach($specializations as $specialization)
            <option value="{{ $specialization->id }}" {{ old('specialization_id') == $specialization->id ? 'selected' : '' }}>
                {{ $specialization->name }}
            </option>
        @endforeach
    </select>
</div>
        <div>
            <label for="profile_picture">Profile Picture</label>
            <input id="profile_picture" type="file" name="profile_picture">
        </div>

        <br>
        <button type="submit">Register</button>
    </form>

</body>
</html> -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form method="POST" action="/developer/register" enctype="multipart/form-data">
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

        <div>
            <label for="bio">Bio</label>
            <textarea id="bio" name="bio"></textarea>
        </div>

        <div>
            <label for="linkedin">LinkedIn Profile</label>
            <input id="linkedin" type="url" name="linkedin">
        </div>

        <div>
            <label for="profile_picture">Profile Picture</label>
            <input id="profile_picture" type="file" name="profile_picture">
        </div>

        <button type="submit">Register</button>
    </form>
</body>
</html>