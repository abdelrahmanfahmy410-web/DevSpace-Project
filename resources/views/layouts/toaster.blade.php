
<div class="toaster-container">
    @if (session('success'))
        <div class="toaster">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="toaster error">
            {{ session('error') }}
        </div>
    @endif
</div>