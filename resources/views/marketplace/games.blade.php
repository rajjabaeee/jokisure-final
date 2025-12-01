{{-- resources/views/marketplace/games.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>JokiSure | Games</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="{{ asset('css/my-profile.css') }}" rel="stylesheet">
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

  <div class="home-indicator"></div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
