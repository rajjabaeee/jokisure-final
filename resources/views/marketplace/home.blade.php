@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- APP BAR -->
    <div class="appbar d-flex align-items-center justify-content-between px-3">
      <div class="fw-semibold">JokiSure</div>
      <a href="#" class="icon-btn">
        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M12 8v8M8 12h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      </a>
    </div>

    <!-- BODY -->
    <div class="px-3 pb-5">

      <!-- Banner -->
      <div class="card-block p-0 overflow-hidden mt-3 mb-3">
        <img src="{{ asset('assets/banner-naruto.jpg') }}" class="w-100" alt="Banner" style="height: 140px; object-fit: cover; border-radius: 14px;">
      </div>

      <!-- Boost Games Section -->
      <div style="font-weight: 600; font-size: 16px; margin: 16px 0 12px 0;">Boost Games</div>
      <div style="overflow-x: auto; white-space: nowrap; padding-bottom: 8px; margin-left: -12px; margin-right: -12px; padding-left: 12px; padding-right: 12px;">
        @foreach (['Genshin Impact', 'Roblox', 'Mobile Legends', 'Honkai Star Rail', 'Free Fire', 'VALORANT'] as $game)
          <a href="#" style="display: inline-flex; flex-direction: column; width: 100px; margin-right: 12px; border-radius: 12px; overflow: hidden; background: #fff; border: 1px solid #e9e9e9; text-decoration: none; color: #0a0a0a; flex-shrink: 0;">
            <img src="{{ asset('assets/' . str()->slug($game) . '.jpg') }}" alt="{{ $game }}" style="width: 100%; height: 100px; object-fit: cover;">
            <div style="padding: 8px; text-align: center; font-size: 12px; font-weight: 500;">{{ $game }}</div>
          </a>
        @endforeach
      </div>

      <!-- Featured Boosters -->
      <div style="font-weight: 600; font-size: 16px; margin: 16px 0 12px 0;">Featured Boosters</div>
      <div style="overflow-x: auto; white-space: nowrap; padding-bottom: 8px; margin-left: -12px; margin-right: -12px; padding-left: 12px; padding-right: 12px;">
        @php
          $boosters = [
            ['tier'=>'Gold Booster', 'name'=>'SealW', 'games'=>'Mobile Legends, VALORANT', 'img'=>'sealw.jpg'],
            ['tier'=>'Diamond Booster', 'name'=>'BangBoost', 'games'=>'Genshin Impact, Zenless Zone', 'img'=>'bangboost.jpg', 'tag'=>'Best Seller'],
            ['tier'=>'Diamond Booster', 'name'=>'MOBALovers', 'games'=>'Mobile Legends, DOTA', 'img'=>'mobalovers.jpg'],
          ];
        @endphp

        @foreach ($boosters as $b)
          <a href="{{ route('booster.profile', 1) }}" style="display: inline-flex; width: 280px; background: #fff; border: 1px solid #e9e9e9; border-radius: 16px; padding: 12px; margin-right: 12px; gap: 12px; flex-shrink: 0; text-decoration: none; color: #0a0a0a; align-items: center;">
            <img src="{{ asset('assets/' . $b['img']) }}" alt="{{ $b['name'] }}" style="width: 80px; height: 80px; border-radius: 12px; object-fit: cover; flex-shrink: 0;">
            <div style="flex: 1; min-width: 0;">
              <div style="margin-bottom: 4px;">
                <span style="font-size: 10px; padding: 3px 8px; background: #ffc107; color: #000; border-radius: 4px; margin-right: 6px; display: inline-block;">{{ $b['tier'] }}</span>
                @if(isset($b['tag']))
                  <span style="font-size: 10px; padding: 3px 8px; background: #0066cc; color: #fff; border-radius: 4px; display: inline-block;">{{ $b['tag'] }}</span>
                @endif
              </div>
              <div style="font-weight: 600; font-size: 14px; margin: 4px 0; display: flex; align-items: center; gap: 4px;">
                {{ $b['name'] }}
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#0066cc"><path d="M10.5 1.5H4.605c-.606 0-1.122.233-1.5.612-.389.378-.605.894-.605 1.5v16.776c0 .606.233 1.122.612 1.5.378.389.894.605 1.5.605h14.776c.606 0 1.122-.233 1.5-.612.389-.378.605-.894.605-1.5V11.5M10.5 1.5v8m0-8L21 10.5m-10.5-9h8.25"/></svg>
              </div>
              <div style="font-size: 11px; color: #666; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $b['games'] }}</div>
            </div>
          </a>
        @endforeach
      </div>

      <!-- For You Section -->
      <div style="font-weight: 600; font-size: 16px; margin: 16px 0 12px 0;">For You</div>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 24px;">
        @for ($i = 0; $i < 6; $i++)
          <a href="{{ route('service.detail.confirm') }}" style="background: #fff; border: 1px solid #e9e9e9; border-radius: 12px; overflow: hidden; text-decoration: none; color: #0a0a0a; display: flex; flex-direction: column;">
            <img src="{{ asset('assets/abyss.jpg') }}" alt="Service" style="width: 100%; height: 120px; object-fit: cover;">
            <div style="padding: 12px; flex: 1; display: flex; flex-direction: column;">
              <span style="font-size: 10px; padding: 2px 6px; background: #0066cc; color: #fff; display: inline-block; width: fit-content; margin-bottom: 6px; border-radius: 4px;">Open</span>
              <div style="font-weight: 600; font-size: 13px; margin-bottom: 4px;">Genshin | Abyss</div>
              <div style="font-size: 11px; color: #666; margin-bottom: 8px;">Floor 9–12</div>
              <div style="display: flex; justify-content: space-between; align-items: center; font-size: 12px; margin-top: auto;">
                <span style="font-size: 12px;">BangBoost</span>
                <span style="font-weight: 600;">Rp60K+</span>
              </div>
              <div style="font-size: 11px; color: #666; margin-top: 4px;">★ 4.8 (120)</div>
            </div>
          </a>
        @endfor
      </div>

    </div>
  </section>

  <!-- TAB BAR -->
  <nav class="tabbar">
    <a class="tab active" href="{{ route('home') }}">
      <svg viewBox="0 0 24 24"><path d="M3 10l9-7 9 7v8a2 2 0 0 1-2 2h-3v-5H8v5H5a2 2 0 0 1-2-2v-8Z"/></svg>
      <span>Home</span>
    </a>
    <a class="tab" href="{{ route('games.index') }}">
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