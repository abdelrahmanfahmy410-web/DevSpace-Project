@extends('admin.layouts.admin')

@php
    $pageTitle    = 'Skills';
    $pageSubtitle = 'Manage the skills available on DevSpace';
@endphp

@section('content')

    <div class="admin-page-header">
        <a href="{{ route('admin.skill.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Skill
        </a>
    </div>

    <div class="admin-filters">
        <div class="admin-filters__search">
            <i class="fas fa-search admin-filters__search-icon"></i>
            <input
                type="text"
                id="skillSearch"
                class="admin-filters__input"
                placeholder="Search skills...">
        </div>
        <select id="skillFilter" class="admin-filters__select">
            <option value="">All Skills</option>
            @foreach($skills as $skill)
                <option value="{{ $skill->name }}">{{ $skill->name }}</option>
            @endforeach
        </select>
    </div>

    <p class="admin-table__count text-muted">
        Showing <span id="visibleCount">{{ $skills->count() }}</span> skill(s)
    </p>

    <div class="card admin-table__wrapper">
        <table class="admin-table" id="skillsTable">
            <thead class="admin-table__head">
                <tr>
                    <th>#</th>
                    <th>Skill Name</th>
                </tr>
            </thead>
            <tbody>
                @forelse($skills as $skill)
                    <tr class="admin-table__row" data-name="{{ strtolower($skill->name) }}">
                        <td class="admin-table__cell admin-table__cell--muted">
                            {{ $loop->iteration }}
                        </td>
                        <td class="admin-table__cell">
                            <div class="admin-role-cell">
                                <div class="admin-role-cell__icon">
                                    <i class="fas fa-code"></i>
                                </div>
                                <span class="admin-role-cell__name">{{ $skill->name }}</span>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="admin-table__empty">
                            <i class="fas fa-code admin-table__empty-icon"></i>
                            No skills available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            
        </table>
        <!-- all laravel pagination -->
       <div class="table__pagination">
            {{ $skills->links() }}
        </div>

    </div>

@endsection

@push('scripts')
<script>
    const searchInput  = document.getElementById('skillSearch');
    const filterSelect = document.getElementById('skillFilter');
    const rows         = document.querySelectorAll('#skillsTable tbody tr[data-name]');
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