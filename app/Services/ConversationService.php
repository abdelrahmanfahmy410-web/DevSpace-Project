<?php
// app/Services/ConversationService.php

namespace App\Services;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ConversationService
{
    /**
     * Get existing conversation or create a new one.
     * Checks both directions (A→B and B→A).
     */
    public function getOrCreate(int $senderId, int $receiverId): Conversation
    {
        // Check both directions to avoid duplicates
        $conversation = Conversation::where(function ($q) use ($senderId, $receiverId) {
                $q->where('sender_id', $senderId)->where('receiver_id', $receiverId);
            })
            ->orWhere(function ($q) use ($senderId, $receiverId) {
                $q->where('sender_id', $receiverId)->where('receiver_id', $senderId);
            })
            ->first();

        if (! $conversation) {
            $conversation = Conversation::create([
                'sender_id'   => $senderId,
                'receiver_id' => $receiverId,
            ]);
        }

        return $conversation;
    }

    /**
     * Send a message in a conversation.
     */
    public function sendMessage(Conversation $conversation, int $userId, string $body): Message
    {
        return $conversation->messages()->create([
            'user_id' => $userId,
            'body'    => trim($body),
        ]);
    }

    /**
     * Mark all messages in a conversation as read (except the auth user's own).
     */
    public function markAsRead(Conversation $conversation, int $userId): void
    {
        $conversation->messages()
            ->where('user_id', '!=', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    /**
     * Get all conversations for a user, with latest message and other user eager-loaded.
     */
    public function getUserConversations(int $userId)
    {
        return Conversation::with(['sender', 'receiver', 'latestMessage'])
            ->where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderByDesc('updated_at')
            ->get();
    }
}