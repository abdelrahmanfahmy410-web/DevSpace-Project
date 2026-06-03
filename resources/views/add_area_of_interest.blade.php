<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Add Area Of Interest
    </title>

    <link rel="stylesheet" href="{{ asset('css/css_template.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add_area_of_interest.css') }}">
</head>

<body>

    <div class="interest-card">

        <h1 class="title">
            Select at least one Topic
        </h1>

        <p class="subtitle">
            Choose areas that match your interests.
        </p>

        {{-- Success Message --}}

        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

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

        <form
            method="POST"
            action="{{ route('area_of_interest.store') }}"
        >

            @csrf

            <div class="interest-container">

                @foreach($specializations as $specialization)

                    <label class="interest-chip">

                        <input
                            type="checkbox"
                            name="areas_of_interest[]"
                            value="{{ $specialization->id }}"
                            class="interest-input"

                            {{ in_array($specialization->id, old('areas_of_interest', [])) ? 'checked' : '' }}
                        >

                        <span class="interest-text">

                            {{ $specialization->name }}

                        </span>

                    </label>

                @endforeach

            </div>

            <button
                type="submit"
                class="submit-btn"
            >
                Continue
            </button>

        </form>

    </div>

</body>

</html>