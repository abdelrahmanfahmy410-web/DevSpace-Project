<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investor Register</title>
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
                        <div class="form-card-icon">👤</div>
                        <div>
                            <div class="form-card-title">Account & Profile Information</div>
                            <div class="form-card-sub">Login credentials and profile details</div>
                        </div>
                    </div>
                    
                    <div class="form-card-body">
                        <div class="form-group-row">
                            <div class="form-group">
                                <label for="name" class="form-label">Full Name <span class="required">*</span></label>
                                <input id="name" type="text" name="name" class="form-input" required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Email <span class="required">*</span></label>
                                <input id="email" type="email" name="email" class="form-input" required>
                            </div>
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

                        <hr class="form-divider" style="margin: 20px 0;">

                        <div class="profile-section">
                            <div class="avatar-upload-wrapper">
                                <div class="avatar-preview-box" onclick="document.getElementById('profile_picture').click()">
                                    <img id="avatarPreview" src="" style="display:none;">
                                    <span id="avatarPlaceholder" class="avatar-placeholder">Upload</span>
                                </div>
                                <label for="profile_picture" class="upload-btn-label">Choose photo</label>
                                <input id="profile_picture" type="file" name="profile_picture" accept="image/*" style="display:none" onchange="previewAvatar(this)">
                            </div>

                            <div class="bio-fields-wrapper">
                                <div class="form-group">
                                    <label for="bio" class="form-label">Bio</label>
                                    <textarea id="bio" name="bio" class="form-textarea" placeholder="Share a brief bio or investment focus"></textarea>
                                </div>
                                <div class="form-group-row">
                                    <div class="form-group">
                                        <label for="linkedin" class="form-label">LinkedIn Profile</label>
                                        <input id="linkedin" type="url" name="linkedin" class="form-input" placeholder="https://">
                                    </div>
                                    <div class="form-group">
                                        <label for="organization" class="form-label">Organization</label>
                                        <input id="organization" type="text" name="organization" class="form-input" placeholder="Firm or institution">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-footer">
                        <p class="form-footer-note">🔒 Your data is encrypted and secure</p>
                        <div class="form-footer-actions">
                            <button type="submit" class="btn btn-primary">Create Investor Account</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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