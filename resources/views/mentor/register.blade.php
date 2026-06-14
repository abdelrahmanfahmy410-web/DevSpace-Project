<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Registration — DevSpace</title>
    <link rel="stylesheet" href="{{ asset('css/css_template.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/investor-register.css') }}">
</head>
<body>

<div class="register-page">
    <div class="register-container">
        
        <div class="register-header">
            <div class="register-eyebrow"><span class="eyebrow-dot"></span>Join as a Mentor</div>
            <h1 class="register-title">Mentor Registration</h1>
            <p class="register-subtitle">Share your expertise and help the next generation of developers grow through DevSpace.</p>
        </div>

    @include('layouts.toaster')
        <form action="{{ route('mentor.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

           
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-card-icon"><svg viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg></div>
                    <div>
                        <div class="form-card-title">Account & Professional Information</div>
                        <div class="form-card-sub">Login credentials and expertise details</div>
                    </div>
                </div>

                <div class="form-card-body">
                    <div class="form-group-row">
                        <div class="form-group"><label class="form-label">Full Name <span class="required">*</span></label><input type="text" name="name" class="form-input" value="{{ old('name') }}" required></div>
                        <div class="form-group"><label class="form-label">Email Address <span class="required">*</span></label><input type="email" name="email" class="form-input" value="{{ old('email') }}" required></div>
                    </div>

                    <div class="form-group-row">
                        <div class="form-group"><label class="form-label">Password <span class="required">*</span></label><input type="password" name="password" class="form-input" required></div>
                        <div class="form-group"><label class="form-label">Confirm Password <span class="required">*</span></label><input type="password" name="password_confirmation" class="form-input" required></div>
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
                                <label class="form-label">Bio</label>
                                <textarea name="bio" class="form-textarea" placeholder="Tell us about yourself...">{{ old('bio') }}</textarea>
                            </div>
                            <div class="form-group-row">
                                <div class="form-group"><label class="form-label">LinkedIn URL</label><input type="url" name="linkedin_url" class="form-input" value="{{ old('linkedin_url') }}"></div>
                                <div class="form-group"><label class="form-label">Organization</label><input type="text" name="organization" class="form-input" value="{{ old('organization') }}"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Specialization <span class="required">*</span></label>
                        <select class="form-select" name="specialization_id">
                            <option value="">Select specialization</option>
                            @foreach($specializations as $specialization)
                                <option value="{{ $specialization->id }}" @selected(old('specialization_id') == $specialization->id)>{{ $specialization->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Years of Experience</label>
                        <div class="range-row">
                            <input class="form-range" type="range" id="experience_years" name="experience_years" min="0" max="30" value="{{ old('experience_years', 0) }}">
                            <span id="experience-display" class="range-value">{{ old('experience_years', 0) }} yrs</span>
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <span class="form-footer-note"><span class="required">*</span> Required fields</span>
                    <div class="form-footer-actions">
                        <a href="{{ url()->previous() }}" class="btn">Cancel</a>
                        <button type="submit" class="btn btn-primary">Register as Mentor</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // معاينة الصورة
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
    // تحديث رقم الخبرة
    const range = document.getElementById('experience_years');
    const display = document.getElementById('experience-display');
    range.addEventListener('input', function() { display.textContent = this.value + ' yrs'; });
</script>

</body>
</html>