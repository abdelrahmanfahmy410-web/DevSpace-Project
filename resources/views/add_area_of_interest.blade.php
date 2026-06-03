<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Area Of Interest</title>
    <link rel="stylesheet" href="{{ asset('css/css_template.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add_area_of_interest.css') }}">
</head>

<body>

    <div class="interest-card">

        <h1 class="title">Select at least one Topic</h1>
        <p class="subtitle">Choose areas that match your interests.</p>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Search Bar --}}
        <div class="search-wrapper">
            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            <input
                type="text"
                id="interestSearch"
                class="search-input"
                placeholder="Search topics..."
                autocomplete="off"
            >
            <button type="button" class="search-clear" id="clearSearch" style="display:none;" aria-label="Clear search">
                &times;
            </button>
        </div>

        <p class="no-results" id="noResults" style="display:none;">No topics match your search.</p>

        <form method="POST" action="{{ route('area_of_interest.store') }}">

            @csrf

            <div class="interest-container" id="interestContainer">

                @foreach($specializations as $specialization)
                    <label class="interest-chip" data-name="{{ strtolower($specialization->name) }}">
                        <input
                            type="checkbox"
                            name="areas_of_interest[]"
                            value="{{ $specialization->id }}"
                            class="interest-input"
                            {{ in_array($specialization->id, old('areas_of_interest', [])) ? 'checked' : '' }}
                        >
                        <span class="interest-text">{{ $specialization->name }}</span>
                    </label>
                @endforeach

            </div>

            <button type="submit" class="submit-btn">Continue</button>

        </form>

    </div>

    <script>
        const searchInput = document.getElementById('interestSearch');
        const clearBtn    = document.getElementById('clearSearch');
        const chips       = document.querySelectorAll('#interestContainer .interest-chip');
        const noResults   = document.getElementById('noResults');

        function filterChips(query) {
            const q = query.trim().toLowerCase();
            let visible = 0;

            chips.forEach(chip => {
                const name = chip.dataset.name;
                const match = !q || name.includes(q);
                chip.style.display = match ? '' : 'none';
                if (match) visible++;
            });

            noResults.style.display = visible === 0 ? 'block' : 'none';
            clearBtn.style.display  = q ? 'inline-flex' : 'none';
        }

        searchInput.addEventListener('input', () => filterChips(searchInput.value));

        clearBtn.addEventListener('click', () => {
            searchInput.value = '';
            filterChips('');
            searchInput.focus();
        });
    </script>

</body>
</html>