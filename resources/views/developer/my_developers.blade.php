@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevSpace - My Developers</title>
    <link rel="stylesheet" href="{{ asset('assets/my_developers.css') }}">
</head>
<body>

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
                <label for="filterSpecialization">Specialization</label>
                <select id="filterSpecialization" class="filter-select">
                    <option value="">All Specializations</option>
                    @foreach($specializations as $spec)
                        <option value="{{ $spec }}">{{ $spec }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="filterSkill">Skill</label>
                <select id="filterSkill" class="filter-select">
                    <option value="">All Skills</option>
                    @foreach($skills as $skill)
                        <option value="{{ $skill }}">{{ $skill }}</option>
                    @endforeach
                </select>
            </div>
        </aside>

        <main class="main-content">
            <div class="developers-grid" id="developersGrid">
                </div>

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
    const filterSpec = document.getElementById('filterSpecialization');
    const filterSkill = document.getElementById('filterSkill');

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
                    </div>
                </div>
            `;
            grid.insertAdjacentHTML('beforeend', card);
        });
    }

    // دالة الفلترة الفورية (شغالة تمام ومربوطة بكل العناصر)
    function filterDevelopers() {
        const nameQuery = searchName.value.toLowerCase();
        const selectedSpec = filterSpec.value;
        const selectedSkill = filterSkill.value;

        const filteredList = developersData.filter(dev => {
            const matchesName = dev.name.toLowerCase().includes(nameQuery);
            const matchesSpec = selectedSpec === "" || dev.specialization === selectedSpec;
            const matchesSkill = selectedSkill === "" || dev.skills.includes(selectedSkill);

            return matchesName && matchesSpec && matchesSkill;
        });

        displayDevelopers(filteredList);
    }

    searchName.addEventListener('input', filterDevelopers);
    filterSpec.addEventListener('change', filterDevelopers);
    filterSkill.addEventListener('change', filterDevelopers);

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

</body>
</html>
@endsection