@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/all_developers.css') }}">

<div class="container">
    
    <div class="header-box">
        <div class="header-title">
            <h1>Developer Directory</h1>
            <p>Discover and connect with talented developers</p>
        </div>
        
        <div class="search-wrapper">
            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" id="searchName" placeholder="Search developers by name..." class="search-input">
        </div>
    </div>

    <div class="page-layout">
        
        <aside class="sidebar-filters">
            <h3>Filter By</h3>

            <div class="filter-group">
                <label>Specialization</label>
                <div class="checkbox-group">
                    @foreach($specializations as $spec)
                        <label class="checkbox-item">
                            <input type="checkbox" name="specialization" value="{{ $spec }}" class="filter-spec-checkbox">
                            <span>{{ $spec }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="filter-group">
                <label>Skill</label>
                <div class="checkbox-group">
                    @foreach($skills as $skill)
                        <label class="checkbox-item">
                            <input type="checkbox" name="skill" value="{{ $skill }}" class="filter-skill-checkbox">
                            <span>{{ $skill }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </aside>

        <main class="main-content">
            <div class="developers-grid" id="developersGrid"></div>

            <div class="d-flex justify-content-center mt-4">
                {{ $developers->links() }}
            </div>
        </main>

    </div>
        
</div>

<script>
    const developersData = @json($developers->items());

    const grid = document.getElementById('developersGrid');
    const searchName = document.getElementById('searchName');

    // دالة بناء كروت المطورين داخل الـ Grid
    function displayDevelopers(data) {
        grid.innerHTML = ''; 
        
        if (data.length === 0) {
            grid.innerHTML = `<div class="no-results">No developers found matching the criteria.</div>`;
            return;
        }

        data.forEach(dev => {
            const specLower = dev.specialization ? dev.specialization.toLowerCase() : '';
            let badgeClass = 'badge-fullstack';
            
            if (specLower.includes('backend')) badgeClass = 'badge-backend';
            if (specLower.includes('frontend')) badgeClass = 'badge-frontend';

            const skillsHTML = dev.skills.map(skill => `<span class="skill-tag">${skill}</span>`).join('');

            /* توليد رابط البروفايل ديناميكياً باستخدام الـ Named Route الخاص باللارافيل.
               إذا كان اسم الـ route في ملف web.php مختلف عن 'developer.profile'، قومي بتعديله هنا فقط.
            */
            const profileUrl = `{{ route('developer.profile', ':id') }}`.replace(':id', dev.id);

            const card = `
                <div class="dev-card">
                    <div>
                        <div class="card-top">
                            <img src="${dev.avatar}" alt="${dev.name}" class="dev-avatar">
                            <span class="badge ${badgeClass}">${dev.specialization || 'Developer'}</span>
                        </div>
                        <h3 class="dev-name">${dev.name}</h3>
                        <p class="dev-bio">${dev.bio || 'No bio available.'}</p>
                    </div>
                    <div class="card-footer">
                        <span class="skills-title">Skills</span>
                        <div class="skills-list">
                            ${skillsHTML || '<span class="text-xs text-gray-400">No skills listed</span>'}
                        </div>
                        
                        <a href="${profileUrl}" class="btn-view-profile">
                            View Profile
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            `;
            grid.insertAdjacentHTML('beforeend', card);
        });
    }

    // دالة الفلترة بناءً على المدخلات وخيارات الـ Checkbox
    function filterDevelopers() {
        const nameQuery = searchName.value.toLowerCase();
        
        // تجميع الخيارات المحددة في مصفوفات واضحة
        const selectedSpecs = Array.from(document.querySelectorAll('.filter-spec-checkbox:checked')).map(cb => cb.value);
        const selectedSkills = Array.from(document.querySelectorAll('.filter-skill-checkbox:checked')).map(cb => cb.value);

        const filteredList = developersData.filter(dev => {
            const matchesName = dev.name.toLowerCase().includes(nameQuery);
            const matchesSpec = selectedSpecs.length === 0 || selectedSpecs.includes(dev.specialization);
            const matchesSkill = selectedSkills.length === 0 || selectedSkills.some(skill => dev.skills.includes(skill));

            return matchesName && matchesSpec && matchesSkill;
        });

        displayDevelopers(filteredList);
    }

    // الاستماع الفوري لأحداث عناصر الإدخال والـ Checkboxes
    searchName.addEventListener('input', filterDevelopers);

    document.querySelectorAll('.filter-spec-checkbox, .filter-skill-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', filterDevelopers);
    });

    // العرض الأول عند فتح الصفحة مباشرة
    displayDevelopers(developersData);
</script>

<div class="toaster-container">
    @if (session('success'))
        <div class="toaster">
            {{ session('success') }}
        </div>
    @endif
    @foreach($errors->all() as $error)
        <div class="toaster error">
            {{ $error }}
        </div>
    @endforeach
</div>
@endsection