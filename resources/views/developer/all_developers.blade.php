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
            <div class="developers-grid" id="developersGrid">
                @foreach($developers as $dev)
                    @php
                        $specLower = strtolower($dev['specialization'] ?? '');
                        $badgeClass = 'badge-fullstack';
                        
                        if (str_contains($specLower, 'backend')) $badgeClass = 'badge-backend';
                        if (str_contains($specLower, 'frontend')) $badgeClass = 'badge-frontend';
                    @endphp

                    <div class="dev-card" 
                         data-name="{{ strtolower($dev['name'] ?? '') }}" 
                         data-spec="{{ $dev['specialization'] ?? '' }}" 
                         data-skills="{{ json_encode($dev['skills'] ?? []) }}">
                        <div>
                            <div class="card-top">
                                <img src="{{ $dev['avatar'] ?? asset('images/default-avatar.png') }}" alt="{{ $dev['name'] ?? 'Developer' }}" class="dev-avatar">
                                <span class="badge {{ $badgeClass }}">{{ $dev['specialization'] ?? 'Developer' }}</span>
                            </div>
                            <h3 class="dev-name">{{ $dev['name'] ?? 'Unknown Developer' }}</h3>
                            <p class="dev-bio">{{ $dev['bio'] ?? 'No bio available.' }}</p>
                        </div>
                        <div class="card-footer">
                            <span class="skills-title">Skills</span>
                            <div class="skills-list">
                                {{-- تم تعديل الأقواس والتحقق هنا لحل المشكلة تماماً --}}
                                @if(!empty($dev['skills']) && is_array($dev['skills']) && count($dev['skills']) > 0)
                                    @foreach($dev['skills'] as $skill)
                                        <span class="skill-tag">{{ $skill }}</span>
                                    @endforeach
                                @else
                                    <span class="text-xs text-gray-400">No skills listed</span>
                                @endif
                            </div>
                            
                            <a href="{{ route('member.profile', $dev['id'] ?? '') }}" class="btn-view-profile">
                                View Profile
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach

                <div class="no-results" id="noResultsMessage" style="display: none;">
                    No developers found matching the criteria.
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $developers->links() }}
            </div>
        </main>

    </div>
        
</div>

<script>
    const cards = document.querySelectorAll('.dev-card');
    const searchName = document.getElementById('searchName');
    const noResultsMessage = document.getElementById('noResultsMessage');

    function filterDevelopers() {
        const nameQuery = searchName.value.toLowerCase();
        const selectedSpecs = Array.from(document.querySelectorAll('.filter-spec-checkbox:checked')).map(cb => cb.value);
        const selectedSkills = Array.from(document.querySelectorAll('.filter-skill-checkbox:checked')).map(cb => cb.value);

        let visibleCardsCount = 0;

        cards.forEach(card => {
            const cardName = card.getAttribute('data-name') || '';
            const cardSpec = card.getAttribute('data-spec') || '';
            const cardSkills = JSON.parse(card.getAttribute('data-skills') || '[]');

            const matchesName = cardName.includes(nameQuery);
            const matchesSpec = selectedSpecs.length === 0 || selectedSpecs.includes(cardSpec);
            const matchesSkill = selectedSkills.length === 0 || selectedSkills.some(skill => cardSkills.includes(skill));

            if (matchesName && matchesSpec && matchesSkill) {
                card.style.display = 'flex';
                visibleCardsCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (visibleCardsCount === 0) {
            noResultsMessage.style.display = 'block';
        } else {
            noResultsMessage.style.display = 'none';
        }
    }

    searchName.addEventListener('input', filterDevelopers);
    document.querySelectorAll('.filter-spec-checkbox, .filter-skill-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', filterDevelopers);
    });
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