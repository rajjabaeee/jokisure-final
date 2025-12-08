@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div class="d-flex flex-column" style="height: 100vh; background: #ffffff;">

    {{-- Header --}}
    <div class="px-4 py-3 border-bottom border-light" style="background: #ffffff;">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="fw-bold mb-0" style="font-size: 1.25rem;">Messages</h5>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-muted">
                <circle cx="12" cy="12" r="1"></circle>
                <circle cx="19" cy="12" r="1"></circle>
                <circle cx="5" cy="12" r="1"></circle>
            </svg>
        </div>

        {{-- Search Bar --}}
        <div class="position-relative">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="position-absolute" style="top: 12px; left: 12px; color: #999;">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input type="text" class="form-control" placeholder="Search" style="padding-left: 40px; background: #f5f5f5; border: none; border-radius: 20px;">
        </div>
    </div>

    {{-- Messages List --}}
    <div class="flex-grow-1 overflow-auto" style="background: #ffffff;">
        @forelse($users as $user)
            @php
              // Skip users without profile pictures (like aisya, account baru, Mochi)
              $hasProfilePic = in_array(str()->slug($user->user_name), ['bangboost', 'sealw', 'monkeyd']);
            @endphp
            @if($hasProfilePic)
            <a href="{{ route('chat.show', $user->user_id) }}" class="d-flex align-items-center px-4 py-3 text-decoration-none text-dark" style="border-bottom: 1px solid #f0f0f0; cursor: pointer; transition: background 0.15s;">
                
                {{-- Avatar --}}
                <img src="{{ asset('assets/' . str()->slug($user->user_name) . '.jpg') }}" alt="{{ $user->user_name }}" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover; flex-shrink: 0;" onerror="this.src='{{ asset('assets/avatar-placeholder.jpg') }}'">
                
                {{-- Message Info --}}
                <div class="flex-grow-1 min-width-0">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="fw-bold mb-0" style="font-size: 0.95rem; color: #000;">{{ $user->user_name }}</h6>
                        <span class="text-muted" style="font-size: 0.8rem;">12:02pm</span>
                    </div>
                    <p class="text-muted mb-0" style="font-size: 0.85rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Klik untuk mulai chat</p>
                </div>

            </a>
            @endif
        @empty
            <div class="d-flex align-items-center justify-content-center flex-column" style="height: 100%; color: #999;">
                <p style="font-size: 0.95rem;">Belum ada pengguna lain.</p>
            </div>
        @endforelse
    </div>

</div>

<style>
    a[href*="chat.show"]:hover {
        background-color: #f9f9f9 !important;
    }
</style>
@endsection