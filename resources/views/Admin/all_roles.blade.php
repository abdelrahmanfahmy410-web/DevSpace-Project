@extends('admin.layouts.admin')

@section('content')

    {{-- Header Action --}}
    <div class="admin-page-header">
        <div>
            <h1 class="heading-1">Roles</h1>
            <p class="text-muted admin-page-header__sub">Manage user roles on DevSpace</p>
        </div>
        <a href="{{ route('admin.role.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Role
        </a>
    </div>

    {{-- Table --}}
    <div class="card admin-table__wrapper">
        <table class="admin-table">
            <thead class="admin-table__head">
                <tr>
                    <th>#</th>
                    <th>Role Name</th>
                    <th>Users</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                    <tr class="admin-table__row">

                        <td class="admin-table__cell admin-table__cell--muted">
                            {{ $loop->iteration }}
                        </td>

                        <td class="admin-table__cell">
                            <div class="admin-role-cell">
                                <div class="admin-role-cell__icon">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <span class="admin-role-cell__name">{{ ucfirst($role->name) }}</span>
                            </div>
                        </td>

                        <td class="admin-table__cell">
                            <span class="badge badge--grey">
                                {{ $role->users_count }} {{ Str::plural('user', $role->users_count) }}
                            </span>
                        </td>

                        <td class="admin-table__cell admin-table__cell--muted">
                            {{ $role->created_at->format('M d, Y') }}
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="admin-table__empty">
                            <i class="fas fa-user-shield admin-table__empty-icon"></i>
                            No roles found. Create your first role.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection