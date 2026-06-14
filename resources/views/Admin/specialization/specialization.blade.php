@extends('admin.layouts.admin')

@php
    $pageTitle    = 'Specializations';
    $pageSubtitle = 'Manage all specializations with their assigned skills';
@endphp

@section('content')

    <div class="admin-page-header">
        <a href="{{ route('admin.specialization.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Specialization
        </a>
    </div>

    <div class="admin-filters">
        <div class="admin-filters__search">
            <i class="fas fa-search admin-filters__search-icon"></i>
            <input
                type="text"
                id="specSearch"
                class="admin-filters__input"
                placeholder="Search specializations...">
        </div>
        <select id="specFilter" class="admin-filters__select">
            <option value="">All Specializations</option>
            @foreach($specializations as $specialization)
                <option value="{{ strtolower($specialization->name) }}">{{ $specialization->name }}</option>
            @endforeach
        </select>
    </div>

    <p class="admin-table__count text-muted">
        Showing <span id="visibleCount">{{ $specializations->count() }}</span> specialization(s)
    </p>

    <div class="card admin-table__wrapper">
        <table class="admin-table" id="specTable">
            <thead class="admin-table__head">
                <tr>
                    <th>#</th>
                    <th>Specialization</th>
                    <th>Skills</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($specializations as $specialization)
                    <tr class="admin-table__row" data-name="{{ strtolower($specialization->name) }}">
                        <td class="admin-table__cell admin-table__cell--muted">
                            {{ $loop->iteration }}
                        </td>
                        <td class="admin-table__cell">
                            <div class="admin-role-cell">
                                <div class="admin-role-cell__icon">
                                    <i class="fas fa-layer-group"></i>
                                </div>
                                <span class="admin-role-cell__name">{{ $specialization->name }}</span>
                            </div>
                        </td>
                        <td class="admin-table__cell">
                            <div class="admin-role-list">
                                @forelse($specialization->skills as $skill)
                                    <span class="badge badge--grey admin-role-list__badge">
                                        {{ $skill->name }}
                                    </span>
                                @empty
                                    <span class="text-muted">No skills assigned</span>
                                @endforelse
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="admin-table__empty">
                            <i class="fas fa-layer-group admin-table__empty-icon"></i>
                            No specializations available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection

@push('scripts')
<script>
    const searchInput  = document.getElementById('specSearch');
    const filterSelect = document.getElementById('specFilter');
    const rows         = document.querySelectorAll('#specTable tbody tr[data-name]');
    const countEl      = document.getElementById('visibleCount');

    function filterTable() {
        const search = searchInput.value.toLowerCase();
        const filter = filterSelect.value.toLowerCase();
        let visible  = 0;

        rows.forEach(row => {
            const name    = row.dataset.name;
            const matches = name.includes(search) && (filter === '' || name === filter);
            row.style.display = matches ? '' : 'none';
            if (matches) visible++;
        });

        countEl.textContent = visible;
    }

    searchInput.addEventListener('input', filterTable);
    filterSelect.addEventListener('change', filterTable);
</script>
@endpush