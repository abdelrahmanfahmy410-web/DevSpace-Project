@extends('layouts.app')

@section('title', 'Developers')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/all_developers.css') }}">
<div class="container">
    
    <div class="header-box">
        <div class="header-title">
            <h1>Developers</h1>
            <p>Discover and connect with talented developers</p>
        </div>

        {{-- ✅ search داخل form بـ GET --}}
        <form method="GET" action="{{ route('developer.all_developers') }}" id="filterForm">
        <div class="search-wrapper">
            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" name="search" id="searchName"
                   value="{{ request('search') }}"
                   placeholder="Search developers by name..." class="search-input">
        </div>
    </div>

    <div class="page-layout">
        
        <aside class="sidebar-filters">
            <h3>Filter By</h3>

            <div class="filter-group">
                <label class="group-label">Specialization</label>
                <input type="text" id="searchSpec" placeholder="Search specs..." class="mini-filter-search">
                
                <div class="checkbox-group" id="specGroup">
                    @foreach($specializations as $spec)
                        <label class="checkbox-item" data-value="{{ strtolower($spec) }}">
                            {{-- ✅ name="specialization[]" + checked لو كان محدد --}}
                            <input type="checkbox" name="specialization[]" value="{{ $spec }}"
                                   {{ in_array($spec, request('specialization', [])) ? 'checked' : '' }}
                                   class="filter-spec-checkbox">
                            <span>{{ $spec }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="filter-group">
                <label class="group-label">Skill</label>
                <input type="text" id="searchSkill" placeholder="Search skills..." class="mini-filter-search">
                
                <div class="checkbox-group" id="skillGroup">
                    @foreach($skills as $skill)
                        <label class="checkbox-item" data-value="{{ strtolower($skill) }}">
                            {{-- ✅ name="skills[]" + checked لو كان محدد --}}
                            <input type="checkbox" name="skills[]" value="{{ $skill }}"
                                   {{ in_array($skill, request('skills', [])) ? 'checked' : '' }}
                                   class="filter-skill-checkbox">
                            <span>{{ $skill }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </aside>

        <main class="main-content">
            <div class="developers-grid" id="developersGrid">
                @forelse($developers as $dev)
                    @php
                        $specLower = strtolower($dev['specialization'] ?? '');
                        $badgeClass = 'badge-fullstack';
                        
                        if (str_contains($specLower, 'backend')) $badgeClass = 'badge-backend';
                        if (str_contains($specLower, 'frontend')) $badgeClass = 'badge-frontend';
                    @endphp

                    <div class="dev-card">
                        <div>
                            <div class="card-top">
                                <img src="{{ $dev['avatar'] ?? asset('images/default-avatar.png') }}" alt="{{ $dev['name'] ?? 'Developer' }}" class="dev-avatar">
                                <span class="badge {{ $badgeClass }}">{{ $dev['specialization'] ?? 'Developer' }}</span>
                            </div>
                            <h3 class="dev-name">{{ $dev['name'] ?? 'Unknown Developer' }}</h3>
                            <p class="dev-bio">{{ $dev['bio'] ?? 'No bio available.' }}</p>
                        </div>
                        <div class="card-footer">
                            <span class="skills-title">SKILLS</span>
                            <div class="skills-list">
                                @if(!empty($dev['skills']) && is_array($dev['skills']) && count($dev['skills']) > 0)
                                    @foreach($dev['skills'] as $skill)
                                        <span class="skill-tag">{{ $skill }}</span>
                                    @endforeach
                                @else
                                    <span class="text-xs text-gray-400">No skills listed</span>
                                @endif
                            </div>
                            <a href="{{ route('member.other_profile', $dev['id']) }}" class="btn-view-profile">
                                View Profile
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    {{-- ✅ لو مفيش نتائج من الـ backend --}}
                    <div class="no-results">
                        No developers found matching the criteria.
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $developers->links('pagination::simple-bootstrap-4') }}
            </div>
        </main>

    </div>
        
</div>
</form> {{-- ✅ إغلاق الـ form --}}

<script>
    const searchName = document.getElementById('searchName');
    const searchSpecInput = document.getElementById('searchSpec');
    const searchSkillInput = document.getElementById('searchSkill');
    const filterForm = document.getElementById('filterForm');

    // ✅ الـ checkboxes تعمل submit فوراً
    document.querySelectorAll('.filter-spec-checkbox, .filter-skill-checkbox').forEach(cb => {
        cb.addEventListener('change', () => {
            filterForm.submit();
        });
    });

    // ✅ الـ search بعد 500ms من وقف الكتابة (debounce)
    let searchTimer;
    searchName.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            filterForm.submit();
        }, 500);
    });

    // ✅ فلتر الـ checkboxes محلياً في الـ sidebar بس (مش بيأثر على النتائج)
    function filterCheckboxItems(inputElement, groupContainerId) {
        const query = inputElement.value.toLowerCase().trim();
        const items = document.querySelectorAll(`#${groupContainerId} .checkbox-item`);
        items.forEach(item => {
            const val = (item.getAttribute('data-value') || '').toLowerCase();
            item.style.display = val.includes(query) ? 'flex' : 'none';
        });
    }

    searchSpecInput.addEventListener('input', () => filterCheckboxItems(searchSpecInput, 'specGroup'));
    searchSkillInput.addEventListener('input', () => filterCheckboxItems(searchSkillInput, 'skillGroup'));
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