@extends('layouts.app')

@section('title', 'Games')

@section('content')
    <!-- APP BAR -->
    <div class="appbar d-flex align-items-center justify-content-between px-3">
      <a href="{{ url()->previous() }}" class="icon-btn" aria-label="Back">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M15 6l-6 6 6 6" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
      <div class="fw-semibold">Games</div>
      <a href="#" class="icon-btn">
        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M12 8v8M8 12h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      </a>
    </div>

    <!-- BODY -->
    <div class="px-3 pb-5">

      <!-- Games List -->
      @php
        $games = [
          ['name' => 'Mobile Legends', 'description' => 'Popular MOBA Game', 'rating' => 4.9, 'img' => 'mlbb.jpg'],
          ['name' => 'Valorant', 'description' => 'Tactical FPS Game', 'rating' => 4.8, 'img' => 'valorant.jpg'],
          ['name' => 'Genshin Impact', 'description' => 'Open World Adventure', 'rating' => 5.0, 'img' => 'genshin.jpg'],
          ['name' => 'Honkai Star Rail', 'description' => 'Turn-based RPG', 'rating' => 4.7, 'img' => 'honkai.jpg'],
          ['name' => 'Free Fire', 'description' => 'Battle Royale', 'rating' => 4.5, 'img' => 'freefire.jpg'],
          ['name' => 'DOTA 2', 'description' => 'Strategic MOBA', 'rating' => 4.6, 'img' => 'dota2.jpg'],
        ];
      @endphp

      @foreach ($games as $game)
        <a href="{{ route('games.show', 1) }}" style="display: flex; flex-direction: row; align-items: center; background: #fff; border: 1px solid #e9e9e9; border-radius: 14px; padding: 12px; margin-bottom: 12px; text-decoration: none; color: #0a0a0a; gap: 12px;">
          <img src="{{ asset('assets/' . $game['img']) }}" alt="{{ $game['name'] }}" style="width: 55px; height: 55px; border-radius: 10px; object-fit: cover; flex-shrink: 0;">
          <div style="flex: 1; min-width: 0;">
            <div style="font-weight: 600; font-size: 14px; margin-bottom: 4px;">{{ $game['name'] }}</div>
            <div style="font-size: 12px; color: #666; margin-bottom: 6px;">{{ $game['description'] }}</div>
            <div style="display: flex; align-items: center; gap: 4px;">
              <span style="font-size: 11px; background: #2D9E41; color: #fff; padding: 2px 6px; border-radius: 4px;">⭐ {{ $game['rating'] }}</span>
            </div>
          </div>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0a0a0a" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
        </a>
      @endforeach

    </div>
  </section>

  <!-- TAB BAR -->
  <nav class="tabbar">
    <a class="tab" href="{{ route('home') }}">
      <svg viewBox="0 0 24 24"><path d="M3 10l9-7 9 7v8a2 2 0 0 1-2 2h-3v-5H8v5H5a2 2 0 0 1-2-2v-8Z"/></svg>
      <span>Home</span>
    </a>
    <a class="tab active" href="{{ route('games.index') }}">
      <svg viewBox="0 0 24 24"><path d="M6 7h12l-1 11a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2L6 7Z"/><path d="M9 7V5a3 3 0 0 1 6 0v2" fill="none"/></svg>
      <span>Explore</span>
    </a>
    <a class="tab" href="{{ route('chat.index') }}">
      <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
      <span>Message</span>
    </a>
    <a class="tab" href="{{ route('cart.index') }}">
      <svg viewBox="0 0 24 24"><path d="M9 2a1 1 0 0 0 0 2h.01a1 1 0 0 0 0-2H9z"/><path d="M5 5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5z"/></svg>
      <span>Notification</span>
    </a>
    <a class="tab" href="{{ route('profile.show') }}">
      <svg viewBox="0 0 24 24" class="profile-icon">
        <circle cx="12" cy="12" r="9" fill="none"/>
        <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-6 7a6 6 0 0 1 12 0" fill="none"/>
      </svg>
      <span>Profile</span>
    </a>
  </nav>

@endsection
