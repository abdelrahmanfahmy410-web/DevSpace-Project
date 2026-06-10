@extends('layouts.app_dashboard')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox — DevSpace</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green:      #1A7A4A;
            --green-light:#E8F5EE;
            --bg:         #F4F7FA;
            --surface:    #FFFFFF;
            --border:     rgba(0,0,0,0.08);
            --text-primary:   #111827;
            --text-secondary: #6B7280;
            --text-muted:     #9CA3AF;
            --radius-lg:  14px;
            --shadow-sm:  0 1px 3px rgba(0,0,0,0.07);
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text-primary);
            min-height: 100vh;
        }

        .inbox-wrapper {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .inbox-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .inbox-list {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .inbox-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            text-decoration: none;
            color: inherit;
            transition: background 0.18s ease;
        }
        .inbox-item:last-child { border-bottom: none; }
        .inbox-item:hover { background: var(--bg); }

        .avatar-sender {
            width: 46px; height: 46px;
            border-radius: 50%;
            background: var(--green-light);
            color: var(--green);
            font-weight: 700;
            font-size: 18px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .inbox-info { flex: 1; min-width: 0; }

        .inbox-info-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .inbox-name { font-weight: 600; font-size: 15px; color: var(--text-primary); }
        .inbox-time { font-size: 12px; color: var(--text-muted); }

        .inbox-last-msg {
            font-size: 13px;
            color: var(--text-secondary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .unread-badge {
            background: var(--green);
            color: white;
            font-size: 11px;
            font-weight: 700;
            border-radius: 999px;
            padding: 2px 8px;
            flex-shrink: 0;
        }

        .empty-state {
            background: var(--surface);
            border: 1px dashed var(--border);
            border-radius: var(--radius-lg);
            padding: 60px 20px;
            text-align: center;
            color: var(--text-muted);
            font-size: 15px;
        }
    </style>
</head>
<body>

<div class="inbox-wrapper">

    <h1 class="inbox-title">Inbox</h1>

    @if($conversations->isEmpty())
        <div class="empty-state">No conversations yet.</div>
    @else
        <div class="inbox-list">
            @foreach($conversations as $convo)
                @php $other = $convo->otherParticipant(auth()->id()); @endphp
                <a href="{{ route('conversations.show', $convo) }}" class="inbox-item">

                    <div class="avatar-sender">
                        {{ strtoupper(substr($other->name, 0, 1)) }}
                    </div>

                    <div class="inbox-info">
                        <div class="inbox-info-top">
                            <span class="inbox-name">{{ $other->name }}</span>
                            <span class="inbox-time">
                                {{ $convo->latestMessage->first()?->created_at?->diffForHumans() }}
                            </span>
                        </div>
                        <p class="inbox-last-msg">
                            {{ $convo->latestMessage->first()?->body ?? 'No messages yet.' }}
                        </p>
                    </div>

                    @php $unread = $convo->unreadCount(auth()->id()); @endphp
                    @if($unread > 0)
                        <span class="unread-badge">{{ $unread }}</span>
                    @endif

                </a>
            @endforeach
        </div>
    @endif

</div>

</body>
</html>
@endsection