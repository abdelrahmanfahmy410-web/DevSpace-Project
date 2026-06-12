@extends('admin.layouts.admin')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/form.css') }}">

    <div class="page-wrap">
        <div class="page-header">
            <span class="badge">SKILL</span>
            <h1 class="title">Create Skill</h1>
            <div class="subtitle">Add a new skill to DevSpace</div>
        </div>

        <div class="card">
            <div class="card-title">Skill</div>
            <div class="card-sub">Provide the name of the skill</div>

            <form method="POST" action="{{ route('admin.skill.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" class="form-control" type="text" name="name" required autofocus>
                </div>

                <div class="footer-row">
                    <a href="{{ route('admin.skill.index') }}" class="btn btn-outline">
                        ← Back to Skills
                    </a>
                    <button class="btn btn-primary" type="submit">Create Skill</button>
                </div>
            </form>
        </div>

    </div>

@endsection