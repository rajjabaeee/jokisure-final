<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JokiSure Chat - {{ $receiver->user_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/my-profile.css') }}" rel="stylesheet">
    <style>
        .device-frame {
            position: relative;
        }

        .safe-area {
            position: absolute;
            top: var(--status);
            bottom: 84px;
            left: 0;
            right: 0;
            overflow: hidden;
            background: #ffffff;
            display: flex;
            flex-direction: column;
        }

        .appbar {
            height: 50px;
            background: #ffffff;
            border-bottom: 1px solid #f0f0f0;
            flex-shrink: 0;
            z-index: 10;
        }

        .chat-container {
            display: flex;
            flex-direction: column;
            flex: 1;
            background: #ffffff;
            overflow: hidden;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            background: #ffffff;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .chat-messages::-webkit-scrollbar {
            display: none;
        }

        .date-divider {
            text-align: center;
            color: #999;
            font-size: 0.8rem;
            margin: 8px 0;
            opacity: 0.7;
        }

        .message-row {
            display: flex;
            margin-bottom: 12px;
            align-items: flex-end;
            gap: 8px;
            max-width: 100%;
        }

        .message-row.sent {
            justify-content: flex-end;
        }

        .message-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }

        .message-wrapper {
            display: flex;
            flex-direction: column;
            max-width: 60%;
            gap: 4px;
            word-break: break-word;
        }

        .message-row.sent .message-wrapper {
            align-items: flex-end;
        }

        .message-row:not(.sent) .message-wrapper {
            align-items: flex-start;
        }

        .message-bubble {
            padding: 10px 14px;
            border-radius: 18px;
            word-wrap: break-word;
            word-break: break-word;
            font-size: 0.95rem;
            line-height: 1.4;
            display: inline-block;
            max-width: 100%;
        }

        .message-bubble.received {
            background: #e0e0e0;
            color: #000;
        }

        .message-bubble.sent {
            background: #0d6efd;
            color: #ffffff;
        }

        .message-time {
            font-size: 0.75rem;
            color: #999;
            opacity: 0.8;
            padding: 0 4px;
        }

        .input-form {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 0;
        }

        .input-plus-btn {
            background: none;
            border: none;
            font-size: 24px;
            color: #0d6efd;
            cursor: pointer;
            padding: 6px;
            line-height: 1;
            flex-shrink: 0;
            transition: opacity 0.2s;
        }

        .input-plus-btn:hover {
            opacity: 0.7;
        }

        .input-field {
            flex: 1;
            border: none;
            background: #f5f5f5;
            padding: 10px 16px;
            border-radius: 20px;
            font-size: 0.95rem;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #666;
        }

        .input-field::placeholder {
            color: #999;
        }

        .input-field:focus {
            outline: none;
            background: #f0f0f0;
        }

        .input-send-btn {
            background: none;
            border: none;
            font-size: 20px;
            color: #ff3b6d;
            cursor: pointer;
            padding: 6px;
            line-height: 1;
            flex-shrink: 0;
            transition: opacity 0.2s;
        }

        .input-send-btn:hover {
            opacity: 0.7;
        }

        .suggestion-pills {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        .suggestion-pill {
            background: #f5f5f5;
            border: none;
            padding: 8px 12px;
            border-radius: 16px;
            font-size: 0.85rem;
            color: #333;
            cursor: pointer;
            transition: background 0.2s;
        }

        .suggestion-pill:hover {
            background: #efefef;
        }

        .empty-chat {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #999;
        }

        .chat-input-area {
            padding: 12px 16px;
            background: #ffffff;
            border-top: 1px solid #e0e0e0;
            flex-shrink: 0;
            z-index: 10;
        }
    </style>
</head>
<body class="preview-center">
<main class="device-frame">

  <!-- STATUS BAR -->
  <div class="status-bar d-flex align-items-center justify-content-between px-3">
    <div class="time">9:41</div>
    <div class="status-icons d-flex align-items-center gap-2">
      <svg width="20" height="12" viewBox="0 0 20 12" fill="none"><rect x="1" y="7" width="2" height="4" rx=".75" fill="#0a0a0a"/><rect x="5" y="5" width="2" height="6" rx=".75" fill="#0a0a0a"/><rect x="9" y="3" width="2" height="8" rx=".75" fill="#0a0a0a"/><rect x="13" y="1" width="2" height="10" rx=".75" fill="#0a0a0a"/></svg>
      <svg width="18" height="12" viewBox="0 0 18 12" fill="none"><path d="M9 9.5c.7 0 1.25.55 1.25 1.25S9.7 12 9 12 7.75 11.45 7.75 10.75 8.3 9.5 9 9.5Z" fill="#0a0a0a"/><path d="M3 6.5c3.9-3.2 8.1-3.2 12 0" stroke="#0a0a0a" stroke-width="1.6" stroke-linecap="round"/><path d="M5.6 8c2.53-2.05 4.27-2.05 6.8 0" stroke="#0a0a0a" stroke-width="1.6" stroke-linecap="round"/></svg>
      <svg width="26" height="12" viewBox="0 0 26 12" fill="none"><rect x="1" y="1" width="20" height="10" rx="2" stroke="#0a0a0a" stroke-width="1.5"/><rect x="3" y="3" width="16" height="6" rx="1.5" fill="#0a0a0a"/><rect x="22" y="4" width="3" height="4" rx="1" fill="#0a0a0a"/></svg>
    </div>
  </div>

  <!-- SAFE AREA -->
  <section class="safe-area">

    <!-- APP BAR -->
    <div class="appbar d-flex align-items-center justify-content-between px-3">
      <a href="{{ route('chat.index') }}" class="back-btn" style="text-decoration: none; color: #000000;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
      </a>
      <div class="fw-semibold">{{ $receiver->user_name }}</div>
      <button type="button" class="icon-btn" aria-label="Help" style="border: none; background: none; padding: 0; cursor: pointer;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
        </svg>
      </button>
    </div>

    <!-- BODY -->
    <div class="chat-container">
        {{-- Chat Header (Hidden, using appbar instead) --}}
        <div class="chat-header" style="display: none;">
            <div class="chat-header-left">
                <button class="chat-header-back" onclick="window.location.href='{{ route('chat.index') }}'">
                    ←
                </button>
                <h6 class="chat-header-title">{{ $receiver->user_name }}</h6>
            </div>
                <div class="chat-header-right">
                    <button class="chat-header-icon" title="Help">
                        ⓘ
                    </button>
                    <button class="chat-header-icon" title="More">
                        ⋮
                    </button>
                </div>
            </div>

            {{-- Chat Messages Area --}}
            <div class="chat-messages" id="chat-box">
                {{-- Auto message from booster (always shown first) --}}
                <div class="date-divider">{{ \Carbon\Carbon::now()->format('d M Y') }}</div>
                <div class="message-row">
                    <img src="{{ asset('assets/' . str()->slug($receiver->user_name) . '.jpg') }}" alt="{{ $receiver->user_name }}" class="message-avatar" onerror="this.src='{{ asset('assets/avatar-placeholder.jpg') }}'">
                    <div class="message-wrapper">
                        <div class="message-bubble received">
                            Hello, {{ Auth::user()->user_name }}!<br>How can I help you?
                        </div>
                        <div class="message-time">{{ \Carbon\Carbon::now()->format('H:i a') }}</div>
                    </div>
                </div>

                {{-- Chat messages from database --}}
                @if($chats->count() > 0)
                    @php
                        $lastDate = null;
                    @endphp
                    @foreach($chats as $chat)
                        @php
                            $chatDate = \Carbon\Carbon::parse($chat->created_at)->format('d M Y');
                            $isCurrentUser = $chat->sender_user_id == Auth::user()->user_id;
                        @endphp
                        
                        @if ($loop->first || $chatDate !== \Carbon\Carbon::parse($chats[$loop->index - 1]->created_at)->format('d M Y'))
                            <div class="date-divider">{{ strtoupper($chatDate) }}</div>
                        @endif

                        <div class="message-row {{ $isCurrentUser ? 'sent' : '' }}">
                            @if(!$isCurrentUser)
                                <img src="{{ asset('assets/' . str()->slug($receiver->user_name) . '.jpg') }}" alt="{{ $receiver->user_name }}" class="message-avatar" onerror="this.src='{{ asset('assets/avatar-placeholder.jpg') }}'">
                            @endif
                            
                            <div class="message-wrapper">
                                <div class="message-bubble {{ $isCurrentUser ? 'sent' : 'received' }}">
                                    {{ $chat->chat_msg }}
                                </div>
                                <div class="message-time">
                                    {{ $chat->created_at->format('H:i a') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
    </div>

    {{-- Chat Input Area --}}
    <div class="chat-input-area">
        {{-- Message Input Form --}}
        <form action="{{ route('chat.send') }}" method="POST" class="input-form" id="chatForm">
            @csrf
            <input type="hidden" name="receiver_user_id" value="{{ $receiver->user_id }}">
            
            <button type="button" class="input-plus-btn" title="Add attachment">
                +
            </button>
            
            <input 
                type="text" 
                name="message" 
                class="input-field" 
                id="messageInput"
                placeholder="Start typing..." 
                autocomplete="off"
            >
            
            <button type="submit" class="input-send-btn" title="Send message">
                ➤
            </button>
        </form>
    </div>
  </section>
</main>    <script>
        // Scroll to bottom on page load
        document.addEventListener('DOMContentLoaded', function() {
            const chatBox = document.getElementById('chat-box');
            setTimeout(() => {
                chatBox.scrollTop = chatBox.scrollHeight;
            }, 100);
        });

        // Handle form submission
        document.getElementById('chatForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();
            
            if (!message) return;
            
            const formData = new FormData(this);
            
            // Send message via AJAX
            fetch('{{ route('chat.send') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .catch(error => console.error('Error:', error));
            
            // Clear input and suggestions
            messageInput.value = '';
            messageInput.focus();
            
            // Reload chat after a short delay to show new message
            setTimeout(() => {
                location.reload();
            }, 500);
        });

        // Auto-scroll when scrolling
        const chatBox = document.getElementById('chat-box');
        chatBox.addEventListener('scroll', () => {
            // Optional: implement auto-load more messages on scroll up
        });
    </script>
</body>
</html>
