<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investor Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/investor-register.css') }}">
</head>
<body>
    <div class="register-page">
        <div class="register-container">
            <div class="register-header">
                <div class="register-eyebrow"><span class="eyebrow-dot"></span>Investor Registration</div>
                <h1 class="register-title">Create your Investor Account</h1>
                <p class="register-subtitle">Join ITI Hive to discover and connect with graduate projects.</p>
            </div>

            <form method="POST" action="/investor/register" enctype="multipart/form-data">
                @csrf

                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon">&#128100;</div>
                        <div>
                            <div class="form-card-title">Account Details</div>
                            <div class="form-card-sub">Your login credentials</div>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="form-group">
                            <label for="name" class="form-label">Full Name <span class="required">*</span></label>
                            <input id="name" type="text" name="name" class="form-input" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email <span class="required">*</span></label>
                            <input id="email" type="email" name="email" class="form-input" required>
                        </div>
                        <div class="form-group-row">
                            <div class="form-group">
                                <label for="password" class="form-label">Password <span class="required">*</span></label>
                                <input id="password" type="password" name="password" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirm Password <span class="required">*</span></label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-input" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon">&#128221;</div>
                        <div>
                            <div class="form-card-title">Profile Information</div>
                            <div class="form-card-sub">Tell us more about your investor profile</div>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="form-group">
                            <label for="bio" class="form-label">Bio <span class="optional">(optional)</span></label>
                            <textarea id="bio" name="bio" class="form-textarea" placeholder="Share a brief bio or investment focus"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="linkedin" class="form-label">LinkedIn Profile <span class="optional">(optional)</span></label>
                            <input id="linkedin" type="url" name="linkedin" class="form-input" placeholder="https://">
                        </div>
                        <div class="form-group">
                            <label for="organization" class="form-label">Organization <span class="optional">(optional)</span></label>
                            <input id="organization" type="text" name="organization" class="form-input" placeholder="Firm, incubator, or institution">
                        </div>
                        <div class="form-group">
                            <label for="profile_picture" class="form-label">Profile Picture <span class="optional">(optional)</span></label>
                            <input id="profile_picture" type="file" name="profile_picture" class="form-input">
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <p class="form-footer-note">🔒 Your data is encrypted and secure</p>
                    <div class="form-footer-actions">
                        <button type="submit" class="btn btn-primary">Create Investor Account</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>