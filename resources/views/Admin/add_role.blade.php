@extends('admin.layouts.admin')

@php
    $pageTitle    = 'Create Role';
    $pageSubtitle = 'Add a new role to DevSpace';
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
                <ul style="margin:0; padding-left: var(--space-3);">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card admin-form-card">
            <div class="admin-form-card__header">
                <div class="admin-form-card__icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <div class="admin-form-card__title">Role Details</div>
                    <div class="admin-form-card__sub">Provide the name of the role</div>
                </div>
            </div>

            <div class="admin-form-card__body">
                <form method="POST" action="{{ route('admin.role.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">
                            Role Name <span class="admin-form__required">*</span>
                        </label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="form-input {{ $errors->has('name') ? 'is-error' : '' }}"
                            required
                            autofocus>
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="admin-form-card__footer">
                        <a href="{{ route('admin.role.index') }}" class="btn btn-outline">
                            ← Back to Roles
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create Role
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>

@endsection