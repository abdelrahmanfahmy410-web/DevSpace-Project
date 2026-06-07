{{-- resources/views/conversations/inbox.blade.php --}}
<x-app-layout>
    <div class="max-w-3xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Inbox</h1>

        @if($conversations->isEmpty())
            <div class="text-center text-gray-500 py-16">
                <p class="text-lg">No conversations yet.</p>
            </div>
        @else
            <div class="divide-y divide-gray-200 border border-gray-200 rounded-lg bg-white shadow-sm">
                @foreach($conversations as $convo)
                    @php $other = $convo->otherParticipant(auth()->id()); @endphp
                    <a href="{{ route('conversations.show', $convo) }}"
                       class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 transition">

                        {{-- Avatar --}}
                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-lg shrink-0">
                            {{ strtoupper(substr($other->name, 0, 1)) }}
                        </div>

                        {{-- Name + last message --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-gray-800">{{ $other->name }}</span>
                                <span class="text-xs text-gray-400">
                                    {{ $convo->latestMessage->first()?->created_at?->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 truncate">
                                {{ $convo->latestMessage->first()?->body ?? 'No messages yet.' }}
                            </p>
                        </div>

                        {{-- Unread badge --}}
                        @php $unread = $convo->unreadCount(auth()->id()); @endphp
                        @if($unread > 0)
                            <span class="bg-green-600 text-white text-xs font-bold rounded-full px-2 py-0.5">
                                {{ $unread }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>