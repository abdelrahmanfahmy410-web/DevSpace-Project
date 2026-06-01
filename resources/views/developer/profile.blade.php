<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $developer->user?->name ?? 'Developer Profile' }} - Profile</title>
    
    {{-- ربط ملف الـ CSS المينيماليست الفاخر من الـ public folder مباشرة --}}
    <link rel="stylesheet" href="{{ asset('developer_reg_style.css') }}">
    
    {{-- مكتبة FontAwesome للأيقونات --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body style="background-color: var(--color-bg-light, #f8fafc); margin: 0; padding: 0; font-family: sans-serif;">

<div class="container section" style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">
    {{-- تقسيم الصفحة لعمودين باستخدام الـ Grid الخاص بيكِ --}}
    <div class="grid-2">
        <div class="card text-center" style="padding: var(--space-5, 24px); height: fit-content; background: #ffffff; border: 1px solid var(--color-border, #e2e8f0); border-radius: var(--radius-md, 8px);">
            
            <div class="avatar avatar--lg mb-4" style="width: 120px; height: 120px; margin: 0 auto var(--space-4, 16px) auto; display: block; border-radius: 50%; overflow: hidden;">
            @if($developer->user?->profile_picture)
                    <img src="{{ asset('/storage/' . $developer->user?->profile_picture) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($developer->user?->name ?? 'DevSpace') }}&background=1A7A4A&color=fff" alt="Default Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                @endif
            </div>
            
            <h1 class="heading-2 mb-1" style="color: var(--color-dark-navy, #0f172a); font-weight: 600; margin-bottom: var(--space-1, 4px);">
                {{ $developer->user?->name ?? 'Not found' }}
            </h1>
            
            <span class="badge" style="background-color: var(--color-primary-bg, #e6f4ea); color: var(--color-primary, #1A7A4A); display: inline-block; padding: 4px 12px; border-radius: 4px; font-weight: 600; margin-bottom: var(--space-4, 16px); font-size: 14px;">
                {{ $developer->specialization?->name ?? 'Full Stack Developer' }}
            </span>

            <div class="divider" style="height: 1px; background-color: var(--color-border, #e2e8f0); margin: var(--space-4, 16px) 0;"></div>

            <div class="text-left mb-5" style="display: flex; flex-direction: column; gap: var(--space-2, 8px); align-items: flex-start;">
                <span class="text-body" style="font-size: var(--font-size-small, 14px); color: var(--color-muted, #64748b);">
                    <i class="fas fa-phone" style="margin-right: 6px;"></i> {{ $developer->phone_number ?? 'No phone added' }}
                </span>
                
                @if($developer->user?->linkedin_url)
                    <a href="{{ $developer->user?->linkedin_url }}" target="_blank" style="font-size: var(--font-size-small, 14px); color: var(--color-primary, #1A7A4A); text-decoration: none;">
                        <i class="fab fa-linkedin" style="margin-right: 6px;"></i> LinkedIn Profile
                    </a>
                @endif
                
                @if($developer->portfolio_url)
                    <a href="{{ $developer->portfolio_url }}" target="_blank" style="font-size: var(--font-size-small, 14px); color: var(--color-primary, #1A7A4A); text-decoration: none;">
                        <i class="fas fa-globe" style="margin-right: 6px;"></i> Personal Portfolio
                    </a>
                @endif
            </div>

            <a href="{{ action([App\Http\Controllers\DeveloperController::class, 'edit']) }}" class="btn btn-primary" style="display: block; width: 100%; background-color: var(--color-primary, #1A7A4A); color: white; text-align: center; padding: var(--space-3, 12px); border-radius: var(--radius-md, 6px); text-decoration: none; font-weight: 500; border: none;">
                Edit Profile
            </a>
        </div>

        <div style="display: flex; flex-direction: column; gap: var(--space-5, 24px);">
            
            <div class="card" style="padding: var(--space-5, 24px); background: #ffffff; border: 1px solid var(--color-border, #e2e8f0); border-radius: var(--radius-md, 8px);">
                <h2 class="heading-2 mb-3" style="border-bottom: 1px solid var(--color-border, #e2e8f0); padding-bottom: var(--space-2, 8px); color: var(--color-dark-navy, #0f172a); font-size: 20px; font-weight: 600;">
                    Biography
                </h2>
                <p class="text-body" style="color: var(--color-body-text, #334155); line-height: 1.6; font-size: 15px; margin-top: var(--space-3, 12px);">
                    {{ $developer->user?->bio ?? 'Welcome to DevSpace! No biography added yet.' }}
                </p>
            </div>

            <div class="card" style="padding: var(--space-5, 24px); background: #ffffff; border: 1px solid var(--color-border, #e2e8f0); border-radius: var(--radius-md, 8px);">
                <h2 class="heading-2 mb-4" style="border-bottom: 1px solid var(--color-border, #e2e8f0); padding-bottom: var(--space-2, 8px); color: var(--color-dark-navy, #0f172a); font-size: 20px; font-weight: 600;">
                    Featured Projects
                </h2>
                
                {{-- الـ grid-cards المجهز في ملف الـ CSS الخاص بكِ لعرض كروت المشاريع --}}
                <div class="grid-cards" style="margin-top: var(--space-4, 16px);">
                    
                    <div class="card card--project" style="border: 1px solid var(--color-border, #e2e8f0); border-radius: var(--radius-md, 8px); overflow: hidden; background: #ffffff;">
                        <div class="card__thumbnail" style="display: flex; align-items: center; justify-content: center; color: var(--color-muted, #94a3b8); background-color: var(--color-bg-light, #f8fafc); height: 180px; font-size: 18px;">
                            <i class="far fa-image" style="margin-right: 8px;"></i> Project Thumbnail
                        </div>
                        <div class="card__body" style="padding: 16px;">
                            <h3 class="card__title" style="color: var(--color-dark-navy, #0f172a); margin-bottom: 8px; font-size: 18px; font-weight: 600;">DevSpace Platform</h3>
                            <p class="card__description" style="color: var(--color-body-text, #475569); font-size: 14px; margin-bottom: 12px; line-height: 1.5;">A professional platform connecting developers with mentors and potential investors.</p>
                            
                            <div class="card__footer" style="display: flex; gap: 8px;">
                                <span class="badge" style="background-color: #f1f5f9; color: #64748b; padding: 2px 8px; border-radius: 4px; font-size: 12px;">Web App</span>
                                <span class="badge" style="background-color: #f1f5f9; color: #64748b; padding: 2px 8px; border-radius: 4px; font-size: 12px;">Laravel</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>