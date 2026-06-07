{{-- resources/views/conversations/show.blade.php --}}
<x-app-layout>
    <div class="max-w-3xl mx-auto py-8 px-4">

        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('inbox') }}" class="text-gray-500 hover:text-gray-700">
                ← Back
            </a>
            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold">
                {{ strtoupper(substr($otherUser->name, 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-gray-800">{{ $otherUser->name }}</p>
                <p class="text-xs text-gray-400 capitalize">{{ $otherUser->role }}</p>
            </div>
        </div>

        {{-- Livewire Chat Component --}}
        @livewire('chat-box', ['conversation' => $conversation])

    </div>
</x-app-layout>