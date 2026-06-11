@extends('admin.layouts.admin')

@php
    $pageTitle    = 'Create Specialization';
    $pageSubtitle = 'Add a new specialization to DevSpace';
@endphp

@section('content')

    <div class="admin-form-wrap">

        @if(session('success'))
            <div class="admin-alert admin-alert--success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="admin-alert admin-alert--error">
                <i class="fas fa-exclamation-circle"></i>
                <ul style="margin:0; padding-left:var(--space-3);">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card admin-form-card">
            <div class="admin-form-card__header">
                <div class="admin-form-card__icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <div class="admin-form-card__title">Specialization Details</div>
                    <div class="admin-form-card__sub">Provide the specialization name to be displayed</div>
                </div>
            </div>

            <div class="admin-form-card__body">
                <form method="POST" action="{{ route('admin.specialization.store') }}">
                    @csrf

                    {{-- Specialization select --}}
                    <div class="form-group">
                        <label for="specialization" class="form-label">
                            Specialization <span class="admin-form__required">*</span>
                        </label>
                        <select
                            id="specialization"
                            name="name"
                            class="admin-filters__select"
                            style="width:100%;"
                            required
                            onchange="toggleOther()">
                            <option disabled selected>Select Specialization</option>
                            @foreach($specializations as $specialization)
                                <option value="{{ $specialization->name }}">
                                    {{ $specialization->name }}
                                </option>
                            @endforeach
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    {{-- Other input --}}
                    <div id="other-specialization" class="form-group admin-form__hidden">
                        <label for="other_specialization" class="form-label">
                            New Specialization Name <span class="admin-form__required">*</span>
                        </label>
                        <input
                            id="other_specialization"
                            type="text"
                            name="other_specialization"
                            class="form-input"
                            placeholder="Enter specialization name">
                    </div>

                    {{-- Skills --}}
                    <div class="form-group">
                        <div class="admin-form-skills__header">
                            <label class="form-label" style="margin:0;">Skills</label>
                            <a href="{{ route('admin.skill.create') }}" class="btn btn-outline">
                                <i class="fas fa-plus"></i> Add Skill
                            </a>
                        </div>
                        <div class="admin-form-skills__grid">
                            @foreach($skills as $skill)
                                <label class="admin-form-skills__item">
                                    <input
                                        type="checkbox"
                                        name="skills[]"
                                        value="{{ $skill->id }}"
                                        class="admin-form-skills__checkbox">
                                    {{ $skill->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="admin-form-card__footer">
                        <a href="{{ route('admin.specialization.index') }}" class="btn btn-outline">
                            ← Back to Specializations
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create Specialization
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>

@push('scripts')
<script>
function toggleOther() {
    const val = document.getElementById('specialization').value;
    const box = document.getElementById('other-specialization');
    box.classList.toggle('admin-form__hidden', val !== 'Other');
}
</script>
@endpush

@endsection