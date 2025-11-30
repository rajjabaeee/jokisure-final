<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>JokiSure | Home</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="{{ asset('css/home.css') }}" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
      background: #fafafa;
      color: #0a0a0a;
    }

    .preview-center {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      padding: 20px;
    }

    .device-frame {
      width: 390px;
      height: 844px;
      background: #fff;
      border-radius: 40px;
      border: 12px solid #000;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    .status-bar {
      height: 44px;
      background: #fafafa;
      border-bottom: 1px solid #e0e0e0;
      padding: 0 16px !important;
      font-size: 14px;
      font-weight: 600;
    }

    .safe-area {
      flex: 1;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
    }

    .appbar {
      height: 56px;
      background: #fff;
      border-bottom: 1px solid #e0e0e0;
      padding: 8px 16px !important;
      font-weight: 600;
      flex-shrink: 0;
    }

    .icon-btn {
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      background: transparent;
      border: none;
      cursor: pointer;
      color: #0a0a0a;
      transition: background 0.2s;
    }

    .icon-btn:hover {
      background: #f0f0f0;
    }

    .appbar .icon-btn {
      flex-shrink: 0;
    }

    .appbar > div:nth-child(2) {
      flex: 1;
      text-align: center;
    }

    .container {
      width: 100%;
      max-width: 100%;
      padding: 12px 16px;
    }

    .card-block {
      background: #fff;
      border: 1px solid #e0e0e0;
      border-radius: 16px;
      margin-bottom: 12px;
    }

    .card-divider {
      margin: 8px 0 !important;
      border-color: #e0e0e0;
    }

    .scroll-x {
      overflow-x: auto;
      white-space: nowrap;
      padding-bottom: 8px;
      margin-left: -16px;
      margin-right: -16px;
      padding-left: 16px;
      padding-right: 16px;
    }

    .scroll-x::-webkit-scrollbar {
      height: 4px;
    }

    .scroll-x::-webkit-scrollbar-track {
      background: transparent;
    }

    .scroll-x::-webkit-scrollbar-thumb {
      background: #ddd;
      border-radius: 2px;
    }

    .section-title {
      font-weight: 600;
      font-size: 16px;
      margin: 16px 0 12px 0;
      padding: 0 16px;
    }

    .section-title a {
      float: right;
      font-size: 12px;
      color: #0066cc;
      text-decoration: none;
    }

    .game-card {
      display: inline-flex;
      flex-direction: column;
      width: 100px;
      margin-right: 12px;
      border-radius: 12px;
      overflow: hidden;
      background: #fff;
      border: 1px solid #e0e0e0;
      text-decoration: none;
      color: #0a0a0a;
      flex-shrink: 0;
    }

    .game-card img {
      width: 100%;
      height: 100px;
      object-fit: cover;
    }

    .game-card .label {
      padding: 8px;
      text-align: center;
      font-size: 12px;
      font-weight: 500;
    }

    .booster-card {
      display: inline-flex;
      width: 280px;
      background: #fff;
      border: 1px solid #e0e0e0;
      border-radius: 16px;
      padding: 12px;
      margin-right: 12px;
      gap: 12px;
      flex-shrink: 0;
      text-decoration: none;
      color: #0a0a0a;
      align-items: center;
    }

    .booster-card img {
      width: 80px;
      height: 80px;
      border-radius: 12px;
      object-fit: cover;
      flex-shrink: 0;
    }

    .booster-info {
      flex: 1;
      min-width: 0;
    }

    .booster-info .badge {
      font-size: 10px;
      padding: 3px 8px;
      margin-right: 6px;
    }

    .booster-info .name {
      font-weight: 600;
      font-size: 14px;
      margin: 4px 0;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .booster-info .games {
      font-size: 11px;
      color: #666;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .service-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      padding: 0 16px;
    }

    .service-card {
      background: #fff;
      border: 1px solid #e0e0e0;
      border-radius: 12px;
      overflow: hidden;
      text-decoration: none;
      color: #0a0a0a;
      display: flex;
      flex-direction: column;
    }

    .service-card img {
      width: 100%;
      height: 120px;
      object-fit: cover;
    }

    .service-card .content {
      padding: 12px;
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .service-card .badge {
      font-size: 10px;
      padding: 2px 6px;
      display: inline-block;
      width: fit-content;
      margin-bottom: 6px;
    }

    .service-card .title {
      font-weight: 600;
      font-size: 13px;
      margin-bottom: 4px;
    }

    .service-card .variant {
      font-size: 11px;
      color: #666;
      margin-bottom: 8px;
    }

    .service-card .footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 12px;
      margin-top: auto;
    }

    .service-card .booster-info {
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .service-card .price {
      font-weight: 600;
      color: #0a0a0a;
    }

    .service-card .rating {
      font-size: 11px;
      color: #666;
      margin-top: 4px;
    }

    .tabbar {
      position: fixed;
      bottom: 0;
      left: 12px;
      right: 12px;
      height: 60px;
      background: #fff;
      border-top: 1px solid #e0e0e0;
      display: flex;
      justify-content: space-around;
      border-radius: 16px 16px 0 0;
      flex-shrink: 0;
    }

    .tab {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 4px;
      font-size: 10px;
      color: #999;
      text-decoration: none;
      transition: color 0.2s;
    }

    .tab svg {
      width: 24px;
      height: 24px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2;
    }

    .tab.active {
      color: #0066cc;
    }

    .tab.active svg {
      fill: currentColor;
      stroke: none;
    }

    .home-indicator {
      height: 20px;
      flex-shrink: 0;
    }

    .safe-area {
      padding-bottom: 80px;
    }

    @media (max-width: 576px) {
      .device-frame {
        border-radius: 0;
        border: none;
        width: 100vw;
        height: 100vh;
        max-width: none;
      }
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
      <img src="{{ asset('assets/jokisure-logo.png') }}" alt="JokiSure" height="28">
      <input type="text" class="form-control form-control-sm rounded-pill" placeholder="Search..." style="max-width: 140px; font-size: 12px;">
      <a href="#" class="icon-btn position-relative">
        <i class="bi bi-cart3" style="font-size: 20px;"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">1</span>
      </a>
    </div>

    <!-- BODY -->
    <div class="container px-3">

      <!-- Banner -->
      <div class="card-block p-0 overflow-hidden mt-2 mb-3">
        <img src="{{ asset('assets/banner-naruto.jpg') }}" class="w-100" alt="Banner" style="height: 140px; object-fit: cover;">
      </div>

      <!-- Boost Games -->
      <div class="section-title">
        Boost Games
        <a href="{{ url('/games') }}">See All →</a>
      </div>
      <div class="scroll-x mb-4">
        @foreach (['Genshin Impact', 'Roblox', 'Mobile Legends', 'Honkai Star Rail', 'Free Fire', 'VALORANT'] as $game)
          <a href="#" class="game-card">
            <img src="{{ asset('assets/' . str()->slug($game) . '.jpg') }}" alt="{{ $game }}">
            <div class="label">{{ $game }}</div>
          </a>
        @endforeach
      </div>

      <!-- Boosters -->
      <div class="section-title">
        1000+ Boosters
        <a href="{{ url('/boosters') }}">See All →</a>
      </div>
      <div class="scroll-x mb-4">
        @php
          $boosters = [
            ['tier'=>'Gold Booster', 'name'=>'SealW', 'games'=>'Mobile Legends, VALORANT, Genshin Impact', 'img'=>'sealw.jpg'],
            ['tier'=>'Diamond Booster', 'name'=>'BangBoost', 'games'=>'Genshin Impact, Zenless Zone Zero, Honkai Star Rail', 'img'=>'bangboost.jpg', 'tag'=>'May Best Seller'],
            ['tier'=>'Diamond Booster', 'name'=>'MOBALovers', 'games'=>'Mobile Legends, DOTA, League of Legends', 'img'=>'mobalovers.jpg'],
          ];
        @endphp

        @foreach ($boosters as $b)
          <a href="{{ route('booster.profile') }}" class="booster-card">
            <img src="{{ asset('assets/' . $b['img']) }}" alt="{{ $b['name'] }}">
            <div class="booster-info">
              <div>
                <span class="badge bg-warning text-dark">{{ $b['tier'] }}</span>
                @if(isset($b['tag']))
                  <span class="badge bg-primary">{{ $b['tag'] }}</span>
                @endif
              </div>
              <div class="name">
                {{ $b['name'] }}
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#0066cc"><path d="M10.5 1.5H4.605c-.606 0-1.122.233-1.5.612-.389.378-.605.894-.605 1.5v16.776c0 .606.233 1.122.612 1.5.378.389.894.605 1.5.605h14.776c.606 0 1.122-.233 1.5-.612.389-.378.605-.894.605-1.5V11.5M10.5 1.5v8m0-8L21 10.5m-10.5-9h8.25"/></svg>
              </div>
              <div class="games">{{ $b['games'] }}</div>
            </div>
          </a>
        @endforeach
      </div>

      <!-- For You Section -->
      <div class="section-title">For You</div>
      <div class="service-grid mb-5">
        @for ($i = 0; $i < 6; $i++)
          <a href="{{ route('service.detail.confirm') }}" class="service-card">
            <img src="{{ asset('assets/abyss.jpg') }}" alt="Service">
            <div class="content">
              <span class="badge bg-primary">Open</span>
              <div class="title">Genshin Impact | Abyss</div>
              <div class="variant">Variant: Floor 9–12</div>
              <div class="footer">
                <div class="booster-info">
                  <span>BangBoost</span>
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="#0066cc"><path d="M10.5 1.5H4.605c-.606 0-1.122.233-1.5.612-.389.378-.605.894-.605 1.5v16.776c0 .606.233 1.122.612 1.5.378.389.894.605 1.5.605h14.776c.606 0 1.122-.233 1.5-.612.389-.378.605-.894.605-1.5V11.5M10.5 1.5v8m0-8L21 10.5m-10.5-9h8.25"/></svg>
                </div>
                <div class="price">Rp60,000+</div>
              </div>
              <div class="rating">300 sold ★ 4.8 (120)</div>
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
    <a class="tab" href="{{ url('/games') }}">
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