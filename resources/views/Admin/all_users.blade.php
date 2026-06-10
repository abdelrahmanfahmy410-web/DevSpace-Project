@extends('admin.layouts.admin')

@php
    $pageTitle    = 'Users';
    $pageSubtitle = 'Manage all registered users on DevSpace';
@endphp

@section('content')

    {{-- Filters Bar --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="admin-filters">

        <div class="admin-filters__search">
            <i class="fas fa-search admin-filters__search-icon"></i>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search name, email or phone…"
                class="admin-filters__input">
        </div>

        <select name="role" class="admin-filters__select">
            <option value="">All Roles</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                    {{ ucfirst($role->name) }}
                </option>
            @endforeach
        </select>

        <select name="verified" class="admin-filters__select">
            <option value="">Any Status</option>
            <option value="yes" {{ request('verified') === 'yes' ? 'selected' : '' }}>Verified</option>
            <option value="no"  {{ request('verified') === 'no'  ? 'selected' : '' }}>Unverified</option>
        </select>

        <button type="submit" class="btn btn-primary">Filter</button>

        @if(request()->hasAny(['search', 'role', 'verified']))
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Clear</a>
        @endif

    </form>

    {{-- Results Count --}}
    <p class="admin-table__count text-muted">
        Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} users
    </p>

    {{-- Table --}}
    <div class="card admin-table__wrapper">
        <table class="admin-table">
            <thead class="admin-table__head">
                <tr>
                    <th>User</th>
                    <th>Contact</th>
                    <th>Roles</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="admin-table__row">

                        {{-- User --}}
                        <td class="admin-table__cell">
                            <div class="admin-user-cell">
                                @if($user->profile_picture)
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}"
                                         alt="{{ $user->name }}"
                                         class="admin-user-cell__avatar">
                                @else
                                    <div class="admin-user-cell__avatar admin-user-cell__avatar--placeholder">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="admin-user-cell__name">{{ $user->name }}</div>
                                    <div class="admin-user-cell__id text-muted">#{{ $user->id }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Contact --}}
                        <td class="admin-table__cell">
                            <div class="admin-user-cell__email">{{ $user->email }}</div>
                            @if($user->phonenumber)
                                <div class="text-muted" style="margin-top:2px;">{{ $user->phonenumber }}</div>
                            @endif
                        </td>

                        {{-- Roles --}}
                        <td class="admin-table__cell">
                            <div class="admin-role-list">
                                @forelse($user->roles as $role)
                                    <span class="badge badge--grey admin-role-list__badge">
                                        {{ $role->name }}
                                    </span>
                                @empty
                                    <span class="text-muted">—</span>
                                @endforelse
                            </div>
                        </td>

                        {{-- Joined --}}
                        <td class="admin-table__cell admin-table__cell--muted">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="admin-table__empty">
                            <i class="fas fa-users admin-table__empty-icon"></i>
                            No users found matching your filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($users->hasPages())
        <div class="admin-pagination">
            {{ $users->links() }}
        </div>
    @endif

@endsection