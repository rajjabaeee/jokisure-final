@extends('layouts.app')

@push('styles')
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .messages-container {
        display: flex;
        flex-direction: column;
        height: 100vh;
        background: #ffffff;
    }

    .messages-header {
        padding: 12px 16px;
        background: #ffffff;
        border-bottom: 1px solid #f0f0f0;
    }

    .messages-header-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .messages-header-top h5 {
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
        color: #000;
    }

    .messages-header-icon {
        color: #999;
        cursor: pointer;
    }

    .search-box {
        position: relative;
    }

    .search-box svg {
        position: absolute;
        top: 12px;
        left: 12px;
        color: #999;
        flex-shrink: 0;
    }

    .search-box input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        background: #f5f5f5;
        border: none;
        border-radius: 20px;
        font-size: 0.95rem;
        color: #000;
    }

    .search-box input::placeholder {
        color: #999;
    }

    .search-box input:focus {
        outline: none;
        background: #f0f0f0;
    }

    .messages-list {
        flex: 1;
        overflow: hidden;
        background: #ffffff;
    }

    .message-item {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        border-bottom: 1px solid #f0f0f0;
        text-decoration: none;
        color: #000;
        transition: background 0.15s ease;
        cursor: pointer;
    }

    .message-item:hover {
        background: #f9f9f9;
    }

    .message-item:active {
        background: #f5f5f5;
    }

    .message-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        margin-right: 12px;
        background: #e0e0e0;
    }

    .message-content {
        flex: 1;
        min-width: 0;
    }

    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 4px;
    }

    .message-name {
        font-size: 0.95rem;
        font-weight: 600;
        color: #000;
        margin: 0;
    }

    .message-time {
        font-size: 0.8rem;
        color: #999;
    }

    .message-preview {
        font-size: 0.85rem;
        color: #666;
        margin: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .empty-messages {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #999;
    }

    .empty-messages p {
        margin: 8px 0;
    }
</style>
@endpush

@section('title', 'Messages')

@section('content')
<div class="messages-container">
    {{-- Header --}}
    <div class="messages-header">
        <div class="messages-header-top">
            <h5>Messages</h5>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="messages-header-icon">
                <circle cx="12" cy="12" r="1"></circle>
                <circle cx="19" cy="12" r="1"></circle>
                <circle cx="5" cy="12" r="1"></circle>
            </svg>
        </div>

        {{-- Search Bar --}}
        <div class="search-box">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input type="text" class="search-input" placeholder="Search" id="searchInput" onkeyup="filterMessages()">
        </div>
    </div>

    {{-- Messages List --}}
    <div class="messages-list" id="messagesList">
        @if($users->count() > 0)
            @forelse($users as $user)
                @php
                  $hasProfilePic = in_array(str()->slug($user->user_name), ['bangboost', 'sealw', 'monkeyd', 'emo', 'nagaaaa']);
                @endphp
                @if($hasProfilePic)
                <a href="{{ route('chat.show', $user->user_id) }}" class="message-item" data-username="{{ strtolower($user->user_name) }}">
                    <img src="{{ asset('assets/' . str()->slug($user->user_name) . '.jpg') }}" alt="{{ $user->user_name }}" class="message-avatar" onerror="this.src='{{ asset('assets/avatar-placeholder.jpg') }}'">
                    
                    <div class="message-content">
                        <div class="message-header">
                            <h6 class="message-name">{{ $user->user_name }}</h6>
                            <span class="message-time">{{ now()->format('H:i a') }}</span>
                        </div>
                        <p class="message-preview">{{ $user->user_email ?? 'Klik untuk mulai chat' }}</p>
                    </div>
                </a>
                @endif
            @endforeach
        @else
            <div class="empty-messages">
                <p style="font-size: 0.95rem;">Belum ada pengguna lain.</p>
            </div>
        @endif
    </div>

</div>

<script>
    function filterMessages() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const items = document.querySelectorAll('.message-item');
        
        items.forEach(item => {
            const username = item.getAttribute('data-username');
            if (username.includes(filter)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>
@endsection