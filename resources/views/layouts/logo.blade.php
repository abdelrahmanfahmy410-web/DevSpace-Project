{{-- <a href="{{ url('/') }}" class="logo-link">
    <img
        src="{{ asset('logo.png') }}"
        alt="DevSpace"
        class="logo__icon"
    />
</a> --}}
{{-- layouts/logo.blade.php --}}
@if($darkMode ?? false)
  <img src="{{ asset('logo-dark.png') }}" alt="DevSpace" />
@else
  <img src="{{ asset('logo.png') }}" alt="DevSpace" />
@endif