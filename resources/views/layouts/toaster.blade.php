
<div class="toaster-container">
    @if (session('success'))
        <div class="toaster">
            {{ session('success') }}
        </div>
    @endif
    @foreach($errors->all() as $error)
        <div class="toaster error">
            {{ $error }}
        </div>
    @endforeach
</div>