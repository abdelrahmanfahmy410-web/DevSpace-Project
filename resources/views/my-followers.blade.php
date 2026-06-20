@extends('layouts.app_dashboard')

@section('sidebar')
    @include('layouts.sidebar', ['active' => 'my-followers'])
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/my-followers.css') }}">

<div class="container">
    <div class="page-header">
        <h1>My Followers</h1>
        <span class="followers-count">{{ $followers->count() }} connections</span>
    </div>

   <div class="search-bar">
    {{-- <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"/>
        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
    </svg> --}}
    <input type="text" id="searchInput" placeholder="Search by name or username..." autocomplete="off" value="{{ request('search') }}">
    <button type="button" class="search-clear-x" id="clearX" style="{{ request('search') ? '' : 'display:none' }}" onclick="clearSearch()">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
    </button>
</div>

   @php
    $mutualIds     = $followers->filter(fn($f) => $f->follower && in_array($f->follower_id, $followingIds))->pluck('follower_id');
    $allCount      = $followers->whereNotNull('follower')->count();
    $followerCount = $allCount - $mutualIds->count();
    $mutualCount   = $mutualIds->count();
    $followingCount = $following->count();
@endphp

<div class="chips" id="filterChips">
    <button class="chip active" data-filter="all" onclick="filterChips(this, 'all')">
        <span class="chip-dot"></span> All ({{ $allCount + $followingCount }})
    </button>
    <button class="chip" data-filter="follower" onclick="filterChips(this, 'follower')">
        <span class="chip-dot"></span> Followers ({{ $followerCount }})
        </button>
    <button class="chip" data-filter="mutual" onclick="filterChips(this, 'mutual')">
        <span class="chip-dot"></span> Mutual ({{ $mutualCount }})
    </button>
    <button class="chip" data-filter="following" onclick="filterChips(this, 'following')">
        <span class="chip-dot"></span> Following ({{ $followingCount }})
        </button>
    </div>

    {{-- Followers list --}}
    <div class="followers-list" id="followersList">
    @if($followers->count() > 0 || $following->count() > 0)

        {{-- Followers --}}
        @foreach ($followers as $item)
            @if($item->follower)
                @php
                    $ismutual  = in_array($item->follower_id, $followingIds);
                    $badgeType = $ismutual ? 'mutual' : 'follower';
                    $specialty = optional(optional($item->follower->developer)->specialization)->name;
                @endphp
                <div class="row"
                     data-name="{{ strtolower($item->follower->name) }}"
                     data-username="{{ strtolower($item->follower->username ?? '') }}"
                     data-type="{{ $badgeType }}">

                    <img class="avatar"
                         src="{{ $item->follower->profile_picture ? asset('storage/' . $item->follower->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($item->follower->name) . '&background=random' }}"
                         alt="{{ $item->follower->name }}">

                    <div class="row-info">
                        <p class="row-name">{{ $item->follower->name }}</p>
                        <p class="row-username">{{ $item->follower->email ?? '' }}</p>
                        <div class="row-skills">
                            @if($specialty)
                                <span class="skill-tag">{{ $specialty }}</span>
                            @else
                                <span class="skill-tag skill-tag--empty">No specialty listed</span>
                            @endif
                        </div>
                    </div>

                    <div class="row-right">
                        <div class="badge-dots-row">
                            <span class="badge badge-{{ $badgeType }}">
                                {{ $ismutual ? 'Mutual' : 'Follower' }}
                            </span>
                            <div class="dropdown-wrap">
                                <button class="dots-btn" onclick="toggleDropdown(this)" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('member.other_profile', $item->follower->id) }}" class="dropdown-item">View Profile</a>
                                    <button type="button" class="dropdown-item danger"
                                        onclick="openRemoveModal('{{ $item->follower->id }}', '{{ $item->follower->name }}')">
                                        Remove Follower
                                    </button>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('member.other_profile', $item->follower->id) }}" class="btn-view-profile">
                            View Profile
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                </div>
            @endif
        @endforeach

        {{-- Following --}}
        @foreach ($following as $item)
            @if($item->following)
                @php
                    $specialty = optional(optional($item->following->developer)->specialization)->name;
                @endphp
                <div class="row"
                     data-name="{{ strtolower($item->following->name) }}"
                     data-username="{{ strtolower($item->following->username ?? '') }}"
                     data-type="following">

                    <img class="avatar"
                         src="{{ $item->following->profile_picture ? asset('storage/' . $item->following->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($item->following->name) . '&background=random' }}"
                         alt="{{ $item->following->name }}">

                    <div class="row-info">
                        <p class="row-name">{{ $item->following->name }}</p>
                        <p class="row-username">{{ $item->following->email ?? '' }}</p>
                        <div class="row-skills">
                            @if($specialty)
                                <span class="skill-tag">{{ $specialty }}</span>
                            @else
                                <span class="skill-tag skill-tag--empty">No specialty listed</span>
                            @endif
                        </div>
                    </div>

                    <div class="row-right">
                        <div class="badge-dots-row">
                            <span class="badge badge-following">Following</span>
                            <div class="dropdown-wrap">
                                <button class="dots-btn" onclick="toggleDropdown(this)" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
                                </button>
                                <div class="dropdown-menu">
                                   <a href="{{ route('member.other_profile', $item->following->id) }}" class="dropdown-item">View Profile</a>   
                                    {{-- Unfollow --}}
                                    <form action="{{ route('user.follow', $item->following->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item danger">Unfollow</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('member.other_profile', $item->following->id) }}" class="btn-view-profile">
                            View Profile
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                </div>
            @endif
        @endforeach

    @else
        <p class="no-results">No connections found.</p>
    @endif
    </div>
</div>

{{-- Remove Confirmation Modal --}}
<div id="removeModal" class="modal-overlay" style="display:none" onclick="closeModalOutside(event)">
    <div class="modal-box">
        <div class="modal-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
        </div>
        <h3 class="modal-title">Remove Follower</h3>
        <p class="modal-desc">Are you sure you want to remove <strong id="modalName"></strong> from your followers? They won't be notified.</p>
        <div class="modal-actions">
            <button class="modal-btn-cancel" onclick="closeModal()">Cancel</button>
            <form id="removeForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="modal-btn-confirm">Remove</button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    document.getElementById('clearX').style.display = q ? 'inline-flex' : 'none';
    applyFilters();
});

function clearSearch() {
    const input = document.getElementById('searchInput');
    input.value = '';
    input.dispatchEvent(new Event('input'));
    input.focus();
}

let activeFilter = 'all';

function filterChips(btn, filter) {
    document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    activeFilter = filter;
    applyFilters();
}

function applyFilters() {
    const q = document.getElementById('searchInput').value.toLowerCase().trim();
    document.querySelectorAll('#followersList .row').forEach(function (row) {
        const name  = row.dataset.name || '';
        const uname = row.dataset.username || '';
        const type  = row.dataset.type || '';
        const matchSearch = !q || name.includes(q) || uname.includes(q);
        let matchFilter = true;
        if (activeFilter === 'follower') matchFilter = type === 'follower';
        else if (activeFilter === 'mutual') matchFilter = type === 'mutual';
        else if (activeFilter === 'following') matchFilter = type === 'following';
        row.style.display = (matchSearch && matchFilter) ? '' : 'none';
    });
}


function toggleDropdown(btn) {
    const menu = btn.nextElementSibling;
    const isOpen = menu.classList.contains('open');
    document.querySelectorAll('.dropdown-menu.open').forEach(m => m.classList.remove('open'));
    if (!isOpen) menu.classList.add('open');
}

document.addEventListener('click', function (e) {
    if (!e.target.closest('.dropdown-wrap')) {
        document.querySelectorAll('.dropdown-menu.open').forEach(m => m.classList.remove('open'));
    }
});

function openRemoveModal(id, name) {
    document.getElementById('modalName').textContent = name;
    document.getElementById('removeForm').action = '/followers/' + id + '/remove';
    document.getElementById('removeModal').style.display = 'flex';
    document.querySelectorAll('.dropdown-menu.open').forEach(m => m.classList.remove('open'));
}

function closeModal() {
    document.getElementById('removeModal').style.display = 'none';
}

function closeModalOutside(e) {
    if (e.target.id === 'removeModal') closeModal();
}
</script>
@endsection