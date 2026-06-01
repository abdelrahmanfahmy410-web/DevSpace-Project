<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DevSpace</title>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
</head>
<body>

<div class="login-page">
    <div class="login-container">
        <div class="login-header">
            <div class="login-eyebrow">
                <span class="eyebrow-dot"></span>
                Welcome to DevSpace
            </div>
            <h1>User Login</h1>
            <p>Sign in to your account and continue your learning journey with DevSpace.</p>
        </div>

        <div class="login-card">
            <div class="card-header">
                <div class="card-icon">🔒</div>
                <div>
                    <h2>Account Login</h2>
                    <span>Enter your credentials to access your account</span>
                </div>
            </div>

            <form id="loginForm" action="{{ url('/login') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div style="color: red; margin-bottom: 15px;">
                        {{ $errors->first('email') }}
                    </div>
                @endif

                <div class="form-group">
                    <label>Email Address <span style="color: red;">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                </div>

                <div class="form-group">
                   <label>Password <span style="color: red;">*</span></label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                        <button type="button" class="toggle-password" id="togglePassword">👁</button>
                    </div>
                </div>

                <button type="submit" class="login-btn">Login to DevSpace</button>
            </form>

        </div>
    </div>
</div>

<script>
// سيبنا كود العين بس شغال عشان يفتح ويقفل الباسورد
const password = document.getElementById("password");
const togglePassword = document.getElementById("togglePassword");

togglePassword.addEventListener("click", () => {
    password.type = password.type === "password" ? "text" : "password";
});
</script>

</body>
</html>