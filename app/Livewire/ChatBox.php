<?php
// app/Livewire/ChatBox.php

namespace App\Livewire;

use App\Models\Conversation;
use App\Services\ConversationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatBox extends Component
{
    public Conversation $conversation;
    public string $newMessage = '';

    protected array $rules = [
        'newMessage' => 'required|string|min:1|max:2000',
    ];

    public function mount(Conversation $conversation): void
    {
        // Authorization check
        $authId = Auth::id();
        abort_unless(
            $conversation->sender_id === $authId || $conversation->receiver_id === $authId,
            403
        );

        $this->conversation = $conversation;
    }

    public function sendMessage(ConversationService $service): void
    {
        $this->validate();

        $service->sendMessage($this->conversation, Auth::id(), $this->newMessage);

        // Touch conversation so inbox sorts correctly
        $this->conversation->touch();

        $this->newMessage = '';

        // Refresh messages
        $this->conversation->load('messages.sender');

        // Scroll to bottom via JS event
        $this->dispatch('messageSent');
    }

    public function render()
    {
        $this->conversation->load('messages.sender');

        return view('livewire.chat-box');
    }
}