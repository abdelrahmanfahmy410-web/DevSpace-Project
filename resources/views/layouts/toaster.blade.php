
<div class="toaster-container">
    @if (session('success'))
        <div class="toaster">
            {{ session('success') }}
        </div>
    @endif
    @foreach($php_errormsg as $error)
        <div class="toaster error">
            {{ $error }}
        </div>
    @endforeach
</div>