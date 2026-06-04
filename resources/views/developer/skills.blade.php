<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Your Skills</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('style.css') }}" rel="stylesheet">
</head>
<body>

<div class="main-container">
    <div class="skill-card">
        
        <h1 class="page-title">Select Your Skills</h1>
        <p class="text-muted mb-4">Choose the technologies you excel at to showcase on your profile.</p>

      
        @if(session('success'))
            <div class="alert alert-success py-2" style="border-radius: 10px;">
                {{ session('success') }}
            </div>
        @endif

 <form action="/developer/skills/update" method="POST">
            @csrf

            <div class="skills-grid mb-4">
                @foreach($skills as $skill)
                    <div class="skill-item">
                        <input type="checkbox" 
                               name="skills[]" 
                               value="{{ $skill->id }}" 
                               id="skill_{{ $skill->id }}"
                               {{ in_array($skill->id, $developerSkills ?? []) ? 'checked' : '' }}>
                        <label for="skill_{{ $skill->id }}" style="margin: 0; font-weight: 500; cursor: pointer; flex: 1;">
                            {{ $skill->name }}
                        </label>
                    </div>
                @endforeach
            </div>

            @error('skills')
                <small class="text-danger d-block mb-3">{{ $message }}</small>
            @enderror

            <button type="submit" class="btn btn-save w-100">
                Save Changes
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>