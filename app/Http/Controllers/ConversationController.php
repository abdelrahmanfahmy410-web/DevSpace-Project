<?php
// app/Http/Controllers/ConversationController.php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use App\Services\ConversationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ConversationController extends Controller
{
    public function __construct(protected ConversationService $service) {}

    /**
     * Inbox: list all conversations for the logged-in user.
     */
    public function index(): View
    {
        $conversations = $this->service->getUserConversations(Auth::id());

        return view('conversations.inbox', compact('conversations'));
    }

    /**
     * Start or resume a conversation with a given user.
     * Enforces: only investors/mentors can initiate.
     */
    public function start(User $user): RedirectResponse
{
    $auth = Auth::user();

    // Prevent messaging yourself
    abort_if($auth->id === $user->id, 403, 'You cannot message yourself.');

    // ✅ جلب الـ role صح من الـ relationship
    $authRole = $auth->roles()->first()?->name ?? '';
    $allowedToInitiate = in_array($authRole, ['investor', 'mentor']);

    $existing = Conversation::where(function ($q) use ($auth, $user) {
            $q->where('sender_id', $auth->id)->where('receiver_id', $user->id);
        })
        ->orWhere(function ($q) use ($auth, $user) {
            $q->where('sender_id', $user->id)->where('receiver_id', $auth->id);
        })
        ->first();

    if (! $existing && ! $allowedToInitiate) {
        abort(403, 'Only investors and mentors can start new conversations.');
    }

    $conversation = $this->service->getOrCreate($auth->id, $user->id);

    return redirect()->route('conversations.show', $conversation);
}

    /**
     * Show the chat page for a conversation.
     */
    public function show(Conversation $conversation): View
    {
        $authId = Auth::id();

        // Authorization: only participants can view
        abort_unless(
            $conversation->sender_id === $authId || $conversation->receiver_id === $authId,
            403,
            'You are not part of this conversation.'
        );

        // Mark incoming messages as read
        $this->service->markAsRead($conversation, $authId);

        $otherUser = $conversation->otherParticipant($authId);

        return view('conversations.show', compact('conversation', 'otherUser'));
    }
}