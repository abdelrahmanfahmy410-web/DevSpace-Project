{{-- resources/views/livewire/chat-box.blade.php --}}

<div>
    {{-- Messages window --}}
    <div id="messages-container"
         style="height:450px; overflow-y:auto; padding:16px; display:flex; flex-direction:column; gap:12px; background:#fff;"
         x-data
         x-on:message-sent.window="$el.scrollTop = $el.scrollHeight">

        @foreach($conversation->messages as $message)
            @php $isMine = $message->user_id === auth()->id(); @endphp

            <div style="display:flex; justify-content:{{ $isMine ? 'flex-end' : 'flex-start' }};">
                <div style="max-width:320px;">

                    {{-- Sender name (only for received messages) --}}
                    @unless($isMine)
                        <p style="font-size:12px; color:#9CA3AF; margin-bottom:4px; margin-left:4px;">
                            {{ $message->sender->name }}
                        </p>
                    @endunless

                    <div style="
                        padding: 10px 16px;
                        border-radius: 18px;
                        font-size: 14px;
                        word-wrap: break-word;
                        {{ $isMine
                            ? 'background:#1A7A4A; color:#ffffff; border-bottom-right-radius:4px;'
                            : 'background:#F0F2F5; color:#111827; border-bottom-left-radius:4px;' }}
                    ">
                        {{ $message->body }}
                    </div>

                    {{-- Timestamp + read status --}}
                    <p style="font-size:11px; color:#9CA3AF; margin-top:4px; text-align:{{ $isMine ? 'right' : 'left' }};">
                        {{ $message->created_at->format('g:i A') }}
                        @if($isMine)
                            · {{ $message->isRead() ? 'Seen' : 'Sent' }}
                        @endif
                    </p>

                </div>
            </div>
        @endforeach

        @if($conversation->messages->isEmpty())
            <div style="display:flex; align-items:center; justify-content:center; height:100%; color:#9CA3AF; font-size:14px;">
                No messages yet. Say hello!
            </div>
        @endif
    </div>

    {{-- Message Input --}}
    <div style="padding:16px; border-top:1px solid rgba(0,0,0,0.08); display:flex; gap:12px; background:#fff;">
        <input
            type="text"
            wire:model="newMessage"
            wire:keydown.enter="sendMessage"
            placeholder="Type a message..."
            style="flex:1; border:1px solid #D1D5DB; border-radius:999px; padding:10px 20px; font-size:14px; outline:none; font-family:'DM Sans',sans-serif;"
            maxlength="2000"
        />
        <button
            wire:click="sendMessage"
            wire:loading.attr="disabled"
            style="background:#1A7A4A; color:#fff; border:none; border-radius:999px; padding:10px 24px; font-size:14px; font-weight:600; cursor:pointer; font-family:'DM Sans',sans-serif;">
            <span wire:loading.remove>Send</span>
            <span wire:loading>...</span>
        </button>
    </div>

    @error('newMessage')
        <p style="color:#C0392B; font-size:12px; margin-top:8px; padding:0 16px;">{{ $message }}</p>
    @enderror
</div>
