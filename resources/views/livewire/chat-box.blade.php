{{-- resources/views/livewire/chat-box.blade.php --}}
<div>
    {{-- Messages window --}}
    <div id="messages-container"
         class="border border-gray-200 rounded-lg bg-white shadow-sm p-4 space-y-4 overflow-y-auto"
         style="height: 450px;"
         x-data
         x-on:message-sent.window="$el.scrollTop = $el.scrollHeight">

        @foreach($conversation->messages as $message)
            @php $isMine = $message->user_id === auth()->id(); @endphp

            <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-xs lg:max-w-md">
                    {{-- Sender name (only for received messages) --}}
                    @unless($isMine)
                        <p class="text-xs text-gray-400 mb-1 ml-1">{{ $message->sender->name }}</p>
                    @endunless

                    <div class="px-4 py-2 rounded-2xl text-sm
                        {{ $isMine
                            ? 'bg-green-600 text-white rounded-br-sm'
                            : 'bg-gray-100 text-gray-800 rounded-bl-sm' }}">
                        {{ $message->body }}
                    </div>

                    {{-- Timestamp + read status --}}
                    <p class="text-xs text-gray-400 mt-1 {{ $isMine ? 'text-right' : 'text-left' }}">
                        {{ $message->created_at->format('g:i A') }}
                        @if($isMine)
                            · {{ $message->isRead() ? 'Seen' : 'Sent' }}
                        @endif
                    </p>
                </div>
            </div>
        @endforeach

        @if($conversation->messages->isEmpty())
            <div class="flex items-center justify-center h-full text-gray-400 text-sm">
                No messages yet. Say hello!
            </div>
        @endif
    </div>

    {{-- Message Input --}}
    <div class="mt-4 flex gap-3">
        <input
            type="text"
            wire:model="newMessage"
            wire:keydown.enter="sendMessage"
            placeholder="Type a message..."
            class="flex-1 border border-gray-300 rounded-full px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
            maxlength="2000"
        />
        <button
            wire:click="sendMessage"
            wire:loading.attr="disabled"
            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-full text-sm font-medium transition disabled:opacity-50">
            <span wire:loading.remove>Send</span>
            <span wire:loading>...</span>
        </button>
    </div>

    @error('newMessage')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
    @enderror
</div>