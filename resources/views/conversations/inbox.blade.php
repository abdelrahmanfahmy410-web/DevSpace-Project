@extends('layouts.app_dashboard')

@section('page-title', 'Inbox')

@section('sidebar')
    @include('layouts.sidebar', ['active' => 'chats'])
@endsection

@section('content')
<style>
    /* Scoped to avoid bleeding */
    .inbox-page-wrapper {
        --primary: #1A7A4A;
        --primary-light: #E8F5EE;
        --primary-hover: #145c37;
        --bg: #F9FAFB;
        --surface: #FFFFFF;
        --border: #E5E7EB;
        --text-main: #111827;
        --text-sub: #4B5563;
        --text-muted: #9CA3AF;
        --radius-xl: 16px;
        --radius-lg: 12px;
        --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        font-family: 'DM Sans', sans-serif;
    }

    .inbox-page-wrapper {
        max-width: 850px;
        margin: 30px auto;
        padding: 0 20px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .inbox-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 16px;
        border-bottom: 2px solid var(--border);
    }

    .inbox-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--text-main);
        letter-spacing: -0.5px;
        margin: 0;
    }

    .inbox-list-container {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .inbox-item {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 20px 24px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        text-decoration: none;
        color: inherit;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .inbox-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--primary);
        transform: scaleY(0);
        transition: transform 0.3s ease;
        transform-origin: center;
    }

    .inbox-item:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
        border-color: transparent;
    }

    .inbox-item:hover::before {
        transform: scaleY(1);
    }

    .avatar-wrapper {
        position: relative;
    }

    .avatar-sender {
        width: 52px; height: 52px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-light), #c1e6d1);
        color: var(--primary);
        font-weight: 700;
        font-size: 20px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: inset 0 2px 4px rgba(255,255,255,0.5);
    }

    .online-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        background: #10B981;
        border: 2px solid var(--surface);
        border-radius: 50%;
    }

    .inbox-info { 
        flex: 1; 
        min-width: 0; 
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .inbox-info-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .inbox-name { 
        font-weight: 700; 
        font-size: 16px; 
        color: var(--text-main); 
        transition: color 0.2s;
    }
    
    .inbox-item:hover .inbox-name {
        color: var(--primary);
    }

    .inbox-time { 
        font-size: 13px; 
        color: var(--text-muted); 
        font-weight: 500;
    }

    .inbox-last-msg {
        font-size: 14px;
        color: var(--text-sub);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.4;
    }

    .unread-badge {
        background: var(--primary);
        color: white;
        font-size: 12px;
        font-weight: 700;
        border-radius: 20px;
        padding: 4px 10px;
        flex-shrink: 0;
        box-shadow: 0 2px 4px rgba(26, 122, 74, 0.3);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(26, 122, 74, 0.4); }
        70% { box-shadow: 0 0 0 6px rgba(26, 122, 74, 0); }
        100% { box-shadow: 0 0 0 0 rgba(26, 122, 74, 0); }
    }

    .empty-state {
        background: var(--surface);
        border: 2px dashed var(--border);
        border-radius: var(--radius-xl);
        padding: 80px 20px;
        text-align: center;
        color: var(--text-muted);
        font-size: 16px;
        font-weight: 500;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
    }
    
    .empty-state svg {
        width: 64px;
        height: 64px;
        color: var(--border);
    }
</style>

<div class="inbox-page-wrapper">

    <div class="inbox-header">
        <h1 class="inbox-title">Messages</h1>
    </div>

    @if($conversations->isEmpty())
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <span>No conversations yet. Start chatting!</span>
        </div>
    @else
        <div class="inbox-list-container">
            @foreach($conversations as $convo)
                @php 
                    $other = $convo->otherParticipant(auth()->id()); 
                    $unread = $convo->unreadCount(auth()->id());
                @endphp
                <a href="{{ route('conversations.show', $convo) }}" class="inbox-item">

                    <div class="avatar-wrapper">
                        <div class="avatar-sender">
                            {{ strtoupper(substr($other->name, 0, 1)) }}
                        </div>
                        {{-- Random online indicator for aesthetics, could be dynamic later --}}
                        <div class="online-indicator" style="background: {{ $loop->index % 3 == 0 ? '#10B981' : '#D1D5DB' }}"></div>
                    </div>

                    <div class="inbox-info">
                        <div class="inbox-info-top">
                            <span class="inbox-name" style="{{ $unread > 0 ? 'font-weight: 800; color: #111827;' : '' }}">{{ $other->name }}</span>
                            <span class="inbox-time" style="{{ $unread > 0 ? 'color: var(--primary); font-weight: 600;' : '' }}">
                                {{ $convo->latestMessage->first()?->created_at?->diffForHumans() }}
                            </span>
                        </div>
                        <p class="inbox-last-msg" style="{{ $unread > 0 ? 'font-weight: 600; color: #374151;' : '' }}">
                            {{ $convo->latestMessage->first()?->body ?? 'No messages yet.' }}
                        </p>
                    </div>

                    @if($unread > 0)
                        <span class="unread-badge">{{ $unread }}</span>
                    @endif

                </a>
            @endforeach
        </div>
    @endif

</div>
@endsection