<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/investor-register.css') }}">
    <title>Register - Developer</title>
</head>
<body>
    <main class="register-page">
        <div class="register-container">
            <header class="register-header">
                <div class="register-eyebrow"><span class="eyebrow-dot"></span> Join Us</div>
                <h2 class="register-title">Developer Registration</h2>
                <p class="register-subtitle">Create your developer profile and showcase your skills</p>
            </header>

            <form method="POST" action="/developer/register" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="role" value="developer">

                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon"><svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg></div>
                        <div>
                            <h3 class="form-card-title">Account & Professional Information</h3>
                            <p class="form-card-sub">Complete your details to get started</p>
                        </div>
                    </div>
                    
                    <div class="form-card-body">
                        <div class="form-group-row">
                            <div class="form-group"><label class="form-label">Name <span class="required">*</span></label><input type="text" name="name" class="form-input" required></div>
                            <div class="form-group"><label class="form-label">Email <span class="required">*</span></label><input type="email" name="email" class="form-input" required></div>
                        </div>

                        <div class="form-group-row">
                            <div class="form-group"><label class="form-label">Phone Number <span class="optional">(Optional)</span></label><input type="text" name="phone_number" class="form-input"></div>
                            <div class="form-group"><label class="form-label">Specialization <span class="required">*</span></label><select name="specialization_id" class="form-input" required></select></div>
                        </div>

                        <div class="form-group-row">
                            <div class="form-group"><label class="form-label">Password <span class="required">*</span></label><input type="password" name="password" class="form-input" required></div>
                            <div class="form-group"><label class="form-label">Confirm Password <span class="required">*</span></label><input type="password" name="password_confirmation" class="form-input" required></div>
                        </div>

                        <hr class="form-divider">

                        <div class="profile-section">
                   <div class="avatar-upload-wrapper">
    <div class="avatar-preview-box" onclick="document.getElementById('profile_picture').click()">
        <img id="avatarPreview" src="" style="display:none;">
        <span id="avatarPlaceholder" class="avatar-placeholder">Upload</span>
    </div>
    
    <label for="profile_picture" class="upload-btn-label">
        Choose photo
    </label>
    
    <input id="profile_picture" type="file" name="profile_picture" accept="image/*" style="display:none" onchange="previewAvatar(this)">
    
    <small style="font-size: 10px; color: var(--color-muted); margin-top: 4px;">JPG, PNG up to 2MB</small>
</div>

                            <div class="bio-fields-wrapper">
                                <div class="form-group">
                                    <label class="form-label">Bio</label>
                                    <textarea name="bio" class="form-textarea" placeholder="Tell us about your experience..."></textarea>
                                </div>
                                <div class="form-group-row">
                                    <div class="form-group"><label class="form-label">Portfolio URL</label><input type="url" name="portfolio_url" class="form-input"></div>
                                    <div class="form-group"><label class="form-label">LinkedIn Profile</label><input type="url" name="linkedin_url" class="form-input"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-footer">
                        <div class="form-footer-note"><span class="required">*</span> Indicates required fields</div>
                        <div class="form-footer-actions">
                            <button type="submit" class="btn btn-primary">Register as Developer</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="login-link">Already have an account? <a href="/login">Log in</a></div>
        </div>
    </main>

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