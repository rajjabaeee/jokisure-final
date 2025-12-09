@extends('layouts.app')

@push('styles')
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        background: #f5f5f5;
    }

    .chat-container {
        display: flex;
        flex-direction: column;
        height: 100vh;
        background: #ffffff;
        padding-bottom: 60px;
    }

    .chat-header {
        padding: 12px 16px;
        background: #ffffff;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .chat-header-left {
        display: flex;
        align-items: center;
        flex: 1;
        gap: 12px;
    }

    .chat-header-back {
        font-size: 24px;
        color: #000;
        cursor: pointer;
        background: none;
        border: none;
        padding: 4px 8px;
        line-height: 1;
    }

    .chat-header-title {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        color: #000;
    }

    .chat-header-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chat-header-icon {
        font-size: 22px;
        color: #666;
        cursor: pointer;
        background: none;
        border: none;
        padding: 4px 8px;
        line-height: 1;
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
        width: 0;
        height: 0;
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
        margin-bottom: 8px;
        align-items: flex-end;
        gap: 8px;
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

    .message-bubble {
        max-width: 65%;
        padding: 10px 14px;
        border-radius: 18px;
        word-wrap: break-word;
        font-size: 0.95rem;
        line-height: 1.3;
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
        margin-top: 4px;
        opacity: 0.8;
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
        padding: 12px 16px 24px 16px;
        background: #ffffff;
        border-top: 1px solid #e0e0e0;
        flex-shrink: 0;
        position: fixed;
        bottom: 60px;
        left: 0;
        right: 0;
        box-sizing: border-box;
        max-width: 100%;
    }

    .input-form {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
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

    .no-messages {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 1;
        flex-direction: column;
        color: #999;
    }

    .no-messages p {
        margin: 8px 0;
        font-size: 0.95rem;
    }
</style>
@endpush

@section('title', 'Chat')

@section('content')
<div class="chat-container">
    {{-- Header --}}
    <div class="chat-header">
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

    {{-- Messages Area --}}
    <div class="chat-messages" id="chat-box">
        @if($chats->isEmpty())
            {{-- Auto message from booster --}}
            <div class="date-divider">{{ \Carbon\Carbon::now()->format('d M Y') }}</div>
            <div class="message-row">
                <img src="{{ asset('assets/' . str()->slug($receiver->user_name) . '.jpg') }}" alt="{{ $receiver->user_name }}" class="message-avatar" onerror="this.src='{{ asset('assets/avatar-placeholder.jpg') }}'">
                <div>
                    <div class="message-bubble received">
                        Hello, {{ Auth::user()->user_name }}!<br>
                        How can I help you?
                    </div>
                    <div class="message-time" style="text-align: left;">
                        {{ \Carbon\Carbon::now()->format('H:i a') }}
                    </div>
                </div>
            </div>
        @else
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
                    
                    <div>
                        <div class="message-bubble {{ $isCurrentUser ? 'sent' : 'received' }}">
                            {{ $chat->chat_msg }}
                        </div>
                        <div class="message-time" style="text-align: {{ $isCurrentUser ? 'right' : 'left' }}; margin-right: {{ $isCurrentUser ? '0' : 'auto' }};">
                            {{ $chat->created_at->format('H:i a') }}
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{-- Input Area --}}
    <div class="chat-input-area">
        {{-- Suggestion Pills --}}
        <div class="suggestion-pills" id="suggestionPills" style="display: none;">
            <button class="suggestion-pill" type="button" onclick="insertSuggestion('&quot;design&quot;')">"design"</button>
            <button class="suggestion-pill" type="button" onclick="insertSuggestion('Design')">Design</button>
            <button class="suggestion-pill" type="button" onclick="insertSuggestion('Designer')">Designer</button>
        </div>

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
                onkeyup="handleInput()"
            >
            
            <button type="submit" class="input-send-btn" title="Send message">
                ➤
            </button>
        </form>
    </div>
</div>

<script>
    // Scroll to bottom on page load
    document.addEventListener('DOMContentLoaded', function() {
        const chatBox = document.getElementById('chat-box');
        setTimeout(() => {
            chatBox.scrollTop = chatBox.scrollHeight;
        }, 100);
    });

    // Handle input to show suggestions
    function handleInput() {
        const input = document.getElementById('messageInput');
        const pills = document.getElementById('suggestionPills');
        
        // Show suggestions if input is not empty
        if (input.value.trim() !== '') {
            pills.style.display = 'flex';
        } else {
            pills.style.display = 'none';
        }
    }

    // Insert suggestion and focus
    function insertSuggestion(text) {
        const input = document.getElementById('messageInput');
        input.value = text;
        input.focus();
    }

    // Auto-scroll when form is submitted
    document.getElementById('chatForm').addEventListener('submit', function(e) {
        setTimeout(() => {
            const chatBox = document.getElementById('chat-box');
            chatBox.scrollTop = chatBox.scrollHeight;
        }, 100);
    });

    // Auto-scroll on new messages (polling)
    setInterval(() => {
        const chatBox = document.getElementById('chat-box');
        if (chatBox.scrollTop + chatBox.clientHeight >= chatBox.scrollHeight - 100) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    }, 1000);
</script>
@endsection