<!-- 5026231002 | Aisya Candra Kirana Dewi (Velyven) -->

@extends('layouts.app')

@section('hide-appbar', true) {{-- matikan appbar "JokiSure" di halaman ini --}}

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
        height: 100%;
        background: #ffffff;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: 0;
        padding: 0;
    }

    .messages-header {
        padding: 12px 16px 10px;
        background: #ffffff;
        border-bottom: 1px solid #f0f0f0;
        flex-shrink: 0;
    }

    .messages-header-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .messages-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .messages-header-back {
        cursor: pointer;
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
        top: 11px;
        left: 12px;
        color: #999;
        flex-shrink: 0;
    }

    .search-box input {
        width: 100%;
        padding: 9px 16px 9px 40px;
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
        overflow-y: auto;
        background: #ffffff;
    }

    .message-item {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        border-bottom: 1px solid #f5f5f5;
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
        width: 52px;
        height: 52px;
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
        white-space: nowrap;
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
            <div class="messages-header-left">
                {{-- back arrow --}}
                <a href="{{ url()->previous() }}" class="messages-header-back">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="#000000" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6" />
                    </svg>
                </a>
                <h5>Messages</h5>
            </div>

            {{-- question mark icon --}}
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2"
                 class="messages-header-icon">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 2-3 4"></path>
                <line x1="12" y1="17" x2="12" y2="17"></line>
            </svg>
        </div>

        {{-- Search Bar --}}
        <div class="search-box">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input type="text" class="search-input" placeholder="Search" id="searchInput" oninput="filterMessages()">
        </div>
    </div>

    {{-- Messages List --}}
    <div class="messages-list" id="messagesList">
        @forelse($users as $user)
            @php
              $hasProfilePic = in_array(str()->slug($user->user_name), ['bangboost', 'sealw', 'monkeyd', 'emo', 'nagaaaa']);
            @endphp
            @if($hasProfilePic)
            <a href="{{ route('chat.show', $user->user_id) }}" class="message-item" data-username="{{ strtolower($user->user_name) }}">
                <img src="{{ asset('assets/' . str()->slug($user->user_name) . '.jpg') }}" alt="{{ $user->user_name }}" class="message-avatar" onerror="this.src='{{ asset('assets/avatar-placeholder.jpg') }}'">
                
                <div class="message-content">
                    <div class="message-header">
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <h6 class="message-name">{{ $user->user_name }}</h6>
                            @php
                              $booster = \App\Models\Booster::where('user_id', $user->user_id)->first();
                            @endphp
                            @if($booster)
                              @if($booster->verified)
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" title="Verified">
                                  <circle cx="12" cy="12" r="10" fill="#1DA1F2"/>
                                  <path d="M7 12.5l3 3 7-7" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                              @endif
                            @endif
                        </div>
                        <span class="message-time">{{ $user->latest_message_date ? $user->latest_message_date->format('H:i a') : now()->format('H:i a') }}</span>
                    </div>
                    <p class="message-preview">{{ $user->latest_message ?? 'Start a conversation' }}</p>
                </div>
            </a>
            @endif
        @empty
            <div class="empty-messages">
                <p style="font-size: 0.95rem; font-weight: 500;">Your conversations are empty</p>
                <p style="font-size: 0.85rem; margin: 8px 16px 0; text-align: center;">Browse boosters and send them a message to get started</p>
            </div>
        @endforelse
    </div>
</div>

<script>
    function filterMessages() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase().trim();
        const items = document.querySelectorAll('.message-item');

        items.forEach(item => {
            const username = item.getAttribute('data-username').toLowerCase();
            const messageName = item.querySelector('.message-name').textContent.toLowerCase();
            const messagePreview = item.querySelector('.message-preview').textContent.toLowerCase();
            
            // Check if filter matches username, message name, or message preview
            if (username.includes(filter) || messageName.includes(filter) || messagePreview.includes(filter)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>
@endsection
