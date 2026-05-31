<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - {{ $developer->user?->name ?? 'Developer' }}</title>
    
    {{-- ربط ملف الـ CSS الخاص بيكِ مباشرة --}}
    <link rel="stylesheet" href="{{ asset('developer_reg_style.css') }}">
    
    {{-- مكتبة FontAwesome للأيقونات --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body style="background-color: var(--color-bg-light, #f8fafc); margin: 0; padding: 0; font-family: sans-serif;">

<div class="container section" style="max-width: 800px; margin: 40px auto; padding: 0 20px;">
    
    <div style="margin-bottom: 20px;">
        <a href="{{ route('developer.profile') }}" style="color: var(--color-primary, #1A7A4A); text-decoration: none; font-weight: 500;">
            <i class="fas fa-arrow-left" style="margin-right: 5px;"></i> Back to Profile
        </a>
    </div>

    <div class="card" style="padding: var(--space-5, 32px); background: #ffffff; border: 1px solid var(--color-border, #e2e8f0); border-radius: var(--radius-md, 8px);">
        
        <h2 class="heading-2 mb-4" style="border-bottom: 1px solid var(--color-border, #e2e8f0); padding-bottom: var(--space-2, 12px); color: var(--color-dark-navy, #0f172a); font-size: 24px; font-weight: 600; margin-top: 0;">
            Edit Developer Profile
        </h2>

        @if(session('success'))
            <div style="background-color: #e6f4ea; color: #1a7a4a; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-weight: 500;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background-color: #fce8e6; color: #c5221f; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('developer.update') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: var(--space-4, 20px);">
            @csrf

            <div style="display: flex; align-items: center; gap: 20px;">
                <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; border: 1px solid #e2e8f0; background: #f8fafc;">
                    @if($developer->profile_picture)
                        <img src="{{ asset('storage/' . $developer->profile_picture) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($developer->user?->name ?? 'DevSpace') }}&background=1A7A4A&color=fff" alt="Default Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                    @endif
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #334155;">Profile Picture</label>
                    <input type="file" name="profile_picture" accept="image/*" style="font-size: 14px;">
                </div>
            </div>

            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155;">Specialization</label>
                <select name="specialization_id" required style="width: 100%; padding: 10px; border: 1px solid var(--color-border, #e2e8f0); border-radius: 6px; font-size: 15px; background: #fff;">
                    @foreach($specializations as $spec)
                        <option value="{{ $spec->id }}" {{ $developer->specialization_id == $spec->id ? 'selected' : '' }}>
                            {{ $spec->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155;">Phone Number</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $developer->phone_number) }}" placeholder="e.g. +201234567890" style="width: 100%; padding: 10px; border: 1px solid var(--color-border, #e2e8f0); border-radius: 6px; font-size: 15px; box-sizing: border-box;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155;">Portfolio URL</label>
                <input type="url" name="portfolio_url" value="{{ old('portfolio_url', $developer->portfolio_url) }}" placeholder="https://myportfolio.com" style="width: 100%; padding: 10px; border: 1px solid var(--color-border, #e2e8f0); border-radius: 6px; font-size: 15px; box-sizing: border-box;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155;">LinkedIn URL</label>
                <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $developer->linkedin_url) }}" placeholder="https://linkedin.com/in/username" style="width: 100%; padding: 10px; border: 1px solid var(--color-border, #e2e8f0); border-radius: 6px; font-size: 15px; box-sizing: border-box;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #334155;">Biography</label>
                <textarea name="bio" rows="5" placeholder="Tell investors about your experience and focus..." style="width: 100%; padding: 10px; border: 1px solid var(--color-border, #e2e8f0); border-radius: 6px; font-size: 15px; font-family: sans-serif; resize: vertical; box-sizing: border-box;">{{ old('bio', $developer->bio) }}</textarea>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 10px;">
                <button type="submit" style="background-color: var(--color-primary, #1A7A4A); color: white; padding: 12px 24px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 15px;">
                    Save Changes
                </button>
                <a href="{{ route('developer.profile') }}" style="background-color: #f1f5f9; color: #475569; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 15px; text-align: center;">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>

</body>
</html>