@extends('layouts.app_dashboard')

@section('page-title', 'Chat')

{{-- 1. تمرير السايدبار وتفعيل زر الـ chats --}}
@section('sidebar')
    @include('layouts.sidebar', ['active' => 'chats'])
@endsection

{{-- 2. محتوى صفحة الشات فقط --}}
@section('content')
<style>
    :root {
        --green:      #1A7A4A;
        --green-light:#E8F5EE;
        --red:        #C0392B;
        --surface:    #FFFFFF;
        --border:     rgba(0,0,0,0.08);
        --text-primary:   #111827;
        --text-secondary: #6B7280;
        --text-muted:     #9CA3AF;
        --radius-lg:  14px;
        --shadow-sm:  0 1px 3px rgba(0,0,0,0.07);
    }

    .chat-wrapper {
        max-width: 900px;
        margin: 10px auto;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    /* Header */
    .chat-header {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: var(--shadow-sm);
    }

    .back-btn {
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        padding: 6px 12px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: var(--surface);
        transition: all 0.18s ease;
    }
    .back-btn:hover { color: var(--green); border-color: var(--green); background: var(--green-light); }

    .avatar-chat {
        width: 42px; height: 42px;
        border-radius: 50%;
        background: var(--green-light);
        color: var(--green);
        font-weight: 700;
        font-size: 16px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .chat-header-info p { font-weight: 600; font-size: 15px; color: var(--text-primary); margin: 0; }
    .chat-header-info span { font-size: 12px; color: var(--text-muted); text-transform: capitalize; }

    /* Chat Box Container */
    .chat-box-container {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }
</style>

<div class="chat-wrapper">

    {{-- Header --}}
    <div class="chat-header">
        <a href="{{ route('inbox') }}" class="back-btn">← Back</a>
        <div class="avatar-chat">
            {{ strtoupper(substr($otherUser->name, 0, 1)) }}
        </div>
        <div class="chat-header-info">
            <p>{{ $otherUser->name }}</p>
            <span>{{ $otherUser->roles()->first()?->name ?? 'member' }}</span>
        </div>
    </div>

    {{-- Livewire Chat Component --}}
    <div class="chat-box-container">
        @livewire('chat-box', ['conversation' => $conversation])
    </div>

</div>
@endsection