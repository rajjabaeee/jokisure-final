@extends('layouts.app')

@section('title', 'Boosters')

@section('content')

    <!-- APP BAR -->
    <div class="appbar d-flex align-items-center justify-content-between px-3">
      <a href="{{ route('home') }}" class="icon-btn" aria-label="Back">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M6 12h12M10 8l-4 4 4 4" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
      <div class="fw-semibold">Boosters</div>
      <a href="#" class="icon-btn" aria-label="Settings">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z"/><path d="M19.4 13.5a7.6 7.6 0 0 0 0-3l2.1-1.6-2-3.4-2.6 1a7.5 7.5 0 0 0-2.6-1.5l-.4-2.8H10l-.4 2.8c-.9.3-1.8.8-2.6 1.5l-2.6-1-2 3.4 2.1 1.6a7.6 7.6 0 0 0 0 3L2.4 15l2 3.4 2.6-1a7.5 7.5 0 0 0 2.6 1.5l.4 2.8h4.2l.4-2.8c.9-.3 1.8-.8 2.6-1.5l2.6 1 2-3.4-2.1-1.5Z"/></svg>
      </a>
    </div>

    <!-- BODY -->
    <div class="container px-3">
      @php
        $boosters = [
          ['name' => 'RizkyBoost', 'specialty' => 'Mobile Legends Specialist', 'rating' => 4.9, 'tier' => 'Diamond', 'img' => 'sealw.jpg'],
          ['name' => 'ValorPro', 'specialty' => 'Valorant Radiant Player', 'rating' => 4.8, 'tier' => 'Gold', 'img' => 'bangboost.jpg'],
          ['name' => 'GenshinQueen', 'specialty' => 'Genshin Exploration Expert', 'rating' => 5.0, 'tier' => 'Diamond', 'img' => 'mobalovers.jpg'],
        ];
      @endphp

      @foreach ($boosters as $booster)
        <div class="card-block p-3 d-flex align-items-center gap-3 mt-3">
          <img src="{{ asset('assets/' . $booster['img']) }}" class="avatar" alt="{{ $booster['name'] }}" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
          <div class="flex-grow-1">
            <div class="fw-semibold">{{ $booster['name'] }}</div>
            <div class="text-muted small">{{ $booster['specialty'] }}</div>
            <span class="badge bg-warning text-dark mt-1">⭐ {{ $booster['rating'] }}</span>
          </div>
          <a href="{{ route('booster.profile', 1) }}" class="icon-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="#0066cc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </div>
      @endforeach
    </div>

  </section>

  <!-- TAB BAR -->
  <nav class="tabbar">
    <a class="tab" href="{{ route('home') }}">
      <svg viewBox="0 0 24 24"><path d="M3 10l9-7 9 7v8a2 2 0 0 1-2 2h-3v-5H8v5H5a2 2 0 0 1-2-2v-8Z"/></svg>
      <span>Home</span>
    </a>
    <a class="tab active" href="{{ url('/games') }}">
      <svg viewBox="0 0 24 24"><path d="M6 7h12l-1 11a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2L6 7Z"/><path d="M9 7V5a3 3 0 0 1 6 0v2" fill="none"/></svg>
      <span>Explore</span>
    </a>
    <a class="tab" href="{{ url('/chat') }}">
      <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
      <span>Message</span>
    </a>
    <a class="tab" href="{{ url('/cart') }}">
      <svg viewBox="0 0 24 24"><path d="M9 2a1 1 0 0 0 0 2h.01a1 1 0 0 0 0-2H9z"/><path d="M5 5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5z"/></svg>
      <span>Notification</span>
    </a>
    <a class="tab" href="{{ route('profile.show') }}">
      <svg viewBox="0 0 24 24" class="profile-icon"><circle cx="12" cy="12" r="9" fill="none"/><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-6 7a6 6 0 0 1 12 0" fill="none"/></svg>
      <span>Profile</span>
    </a>
  </nav>

@endsection
