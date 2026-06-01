<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

<div class="register-page">

    <div class="register-container">

        <div class="register-header">
            <span class="register-eyebrow">
                <span class="eyebrow-dot"></span>
                Welcome Back
            </span>

            <h1 class="register-title">Mentor Login</h1>

            <p class="register-subtitle">
                Sign in to your DevSpace account
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-card">

                <div class="form-card-header">

                    <div class="form-card-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 12a5 5 0 100-10 5 5 0 000 10zm0 2c-4.4 0-8 2-8 4.5V21h16v-2.5C20 16 16.4 14 12 14z"/>
                        </svg>
                    </div>

                    <div>
                        <div class="form-card-title">
                            Account Login
                        </div>

                        <div class="form-card-sub">
                            Enter your email and password
                        </div>
                    </div>

                </div>

                <div class="form-card-body">

                    <div class="form-group">

                        <label class="form-label">
                            Email Address
                            <span class="required">*</span>
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-input"
                            placeholder="you@example.com"
                            required>
                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            Password
                            <span class="required">*</span>
                        </label>

                        <div class="password-wrapper">

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-input"
                                placeholder="Enter password"
                                required>

                            <button
                                type="button"
                                class="toggle-password"
                                onclick="togglePassword()">
                                👁
                            </button>

                        </div>

                    </div>

                </div>

                <div class="form-footer">

                    <span class="form-footer-note">
                        Secure login to your account
                    </span>

                    <div class="form-footer-actions">

                        <button
                            type="submit"
                            class="btn btn-primary">
                            Login
                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

<script>
function togglePassword() {

    let password =
        document.getElementById('password');

    if(password.type === 'password'){
        password.type = 'text';
    }else{
        password.type = 'password';
    }
}
</script>

</body>
</html>