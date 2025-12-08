@extends('layouts.app')

@section('title', 'Chat')

@section('content')
<div class="d-flex flex-column" style="height: 100vh; background: #f5f5f5;">

    {{-- Header --}}
    <div class="px-4 py-3" style="background: #ffffff; border-bottom: 1px solid #e0e0e0;">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center" style="flex: 1;">
                <a href="{{ route('chat.index') }}" class="text-dark text-decoration-none me-3" style="font-size: 1.5rem; line-height: 1;">
                    &larr;
                </a>
                <img src="/images/avatar1.png" alt="{{ $receiver->user_name }}" class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                <div>
                    <h6 class="fw-bold mb-0" style="font-size: 0.95rem;">{{ $receiver->user_name }}</h6>
                </div>
            </div>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-muted">
                <circle cx="12" cy="12" r="1"></circle>
                <circle cx="19" cy="12" r="1"></circle>
                <circle cx="5" cy="12" r="1"></circle>
            </svg>
        </div>
    </div>

    {{-- Chat Messages --}}
    <div class="flex-grow-1 overflow-auto px-4 py-3" id="chat-box" style="background: #f5f5f5; display: flex; flex-direction: column;">

        @forelse($chats as $chat)
            @if($chat->sender_user_id == Auth::user()->user_id)
                {{-- User Message (Right) --}}
                <div class="d-flex justify-content-end mb-3">
                    <div class="px-3 py-2 rounded-3" style="background: #0d6efd; color: white; max-width: 70%; word-break: break-word;">
                        <p class="mb-1" style="font-size: 0.95rem;">{{ $chat->chat_msg }}</p>
                        <small style="font-size: 0.75rem; opacity: 0.8;">{{ $chat->created_at->format('H:i') }}</small>
                    </div>
                </div>
            @else
                {{-- Receiver Message (Left) --}}
                <div class="d-flex justify-content-start mb-3">
                    <div class="px-3 py-2 rounded-3" style="background: #e0e0e0; color: #000; max-width: 70%; word-break: break-word;">
                        <p class="mb-1" style="font-size: 0.95rem;">{{ $chat->chat_msg }}</p>
                        <small style="font-size: 0.75rem; color: #666;">{{ $chat->created_at->format('H:i') }}</small>
                    </div>
                </div>
            @endif
        @empty
            <div class="d-flex align-items-center justify-content-center flex-column" style="height: 100%; color: #999;">
                <p style="font-size: 0.95rem;">Belum ada percakapan.</p>
                <p style="font-size: 0.85rem;">Sapa duluan!</p>
            </div>
        @endforelse

        {{-- Spacer for scrolling --}}
        <div></div>

    </div>

    {{-- Message Input --}}
    <div class="px-4 py-3" style="background: #ffffff; border-top: 1px solid #e0e0e0;">
        <form action="{{ route('chat.send') }}" method="post" class="d-flex align-items-flex-end gap-2">
            @csrf
            <input type="hidden" name="receiver_user_id" value="{{ $receiver->user_id }}">
            
            {{-- Plus Button --}}
            <button type="button" class="btn p-0" style="background: none; border: none; font-size: 1.5rem; color: #0d6efd; cursor: pointer;">
                &#43;
            </button>
            
            {{-- Message Input --}}
            <input 
                type="text" 
                name="message" 
                class="form-control rounded-pill" 
                placeholder="Start typing..." 
                autocomplete="off" 
                required
                style="border: none; background: #f5f5f5; padding: 10px 16px; font-size: 0.95rem;"
            >
            
            {{-- Send Button --}}
            <button 
                type="submit" 
                class="btn p-0" 
                style="background: none; border: none; color: #ff3b6d; font-size: 1.5rem; cursor: pointer;"
            >
                &#x2794;
            </button>
        </form>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var chatBox = document.getElementById("chat-box");
        chatBox.scrollTop = chatBox.scrollHeight;
    });

    // Auto-scroll to bottom when new messages arrive
    const observer = new MutationObserver(function() {
        var chatBox = document.getElementById("chat-box");
        chatBox.scrollTop = chatBox.scrollHeight;
    });

    observer.observe(document.getElementById("chat-box"), {
        childList: true,
        subtree: true
    });
</script>
@endsection