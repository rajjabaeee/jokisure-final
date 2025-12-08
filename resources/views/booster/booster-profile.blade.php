<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>JokiSure • Booster Profile</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  {{-- pastikan file ini ada di public/css/ --}}
  <link href="{{ asset('css/booster-profile.css') }}" rel="stylesheet">
</head>
<body class="preview-center">
<main class="device-frame" role="main" aria-label="Booster Profile">

  {{-- Status bar --}}
  <div class="status-bar d-flex align-items-center justify-content-between px-3">
    <div class="time">9:41</div>
    <div class="status-icons d-flex align-items-center gap-2">
      <svg width="20" height="12" viewBox="0 0 20 12" fill="none" aria-hidden="true">
        <rect x="1" y="7" width="2" height="4" rx=".75" fill="#0a0a0a"/>
        <rect x="5" y="5" width="2" height="6" rx=".75" fill="#0a0a0a"/>
        <rect x="9" y="3" width="2" height="8" rx=".75" fill="#0a0a0a"/>
        <rect x="13" y="1" width="2" height="10" rx=".75" fill="#0a0a0a"/>
      </svg>
      <svg width="18" height="12" viewBox="0 0 18 12" fill="none" aria-hidden="true">
        <path d="M9 9.5c.7 0 1.25.55 1.25 1.25S9.7 12 9 12 7.75 11.45 7.75 10.75 8.3 9.5 9 9.5Z" fill="#0a0a0a"/>
        <path d="M3 6.5c3.9-3.2 8.1-3.2 12 0" stroke="#0a0a0a" stroke-width="1.6" stroke-linecap="round"/>
        <path d="M5.6 8c2.53-2.05 4.27-2.05 6.8 0" stroke="#0a0a0a" stroke-width="1.6" stroke-linecap="round"/>
      </svg>
      <svg width="26" height="12" viewBox="0 0 26 12" fill="none" aria-hidden="true">
        <rect x="1" y="1" width="20" height="10" rx="2" stroke="#0a0a0a" stroke-width="1.5"/>
        <rect x="3" y="3" width="16" height="6" rx="1.5" fill="#0a0a0a"/>
        <rect x="22" y="4" width="3" height="4" rx="1" fill="#0a0a0a"/>
      </svg>
    </div>
  </div>

  <section class="safe-area">
    {{-- COVER --}}
    <div class="cover">
      <img class="cover-img" src="{{ $booster['banner'] }}" alt="cover">
      <div class="cover-gradient"></div>

      <a href="{{ url()->previous() }}" class="btn-back" aria-label="Back">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
          <path d="M15 6l-6 6 6 6" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
    </div>

    {{-- HEADER PROFILE --}}
    <div class="container px-3 profile-header">
      <div class="d-flex align-items-end gap-2">
        <img class="avatar" src="{{ $booster['avatar'] }}" alt="avatar">

        <div class="flex-grow-1">
          <div class="d-flex align-items-center gap-1">
            <h1 class="h5 fw-bold mb-0">{{ $booster['name'] }}</h1>
            @if($booster['verified'])
            <span class="verify-badge" title="Verified">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="10" fill="#1DA1F2"/>
                <path d="M7 12.5l3 3 7-7" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
            @endif
          </div>
          <div class="small text-success fw-semibold">
            {{ $booster['online'] ? 'Online' : 'Offline' }}
          </div>
        </div>

        <div class="d-flex align-items-center gap-1">
          <button class="icon-btn" title="Share">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
              <path d="M4 12v7a1 1 0 001 1h14a1 1 0 001-1v-7M16 6l-4-4-4 4M12 2v14" stroke="#1572A0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
          <button class="icon-btn" title="Favorite">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
              <path d="M20.8 4.6a5.5 5.5 0 00-7.8 0L12 5.6l-1-1a5.5 5.5 0 10-7.8 7.8l1 1L12 22l7.8-8.6 1-1a5.5 5.5 0 000-7.8z" stroke="#ff4961" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
          <a href="{{ route('chat.index') }}" class="icon-btn" title="Chat">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" stroke="#1572A0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
        </div>
      </div>

      {{-- Badges --}}
      <div class="mt-2 d-flex gap-2 flex-wrap">
        @foreach($booster['badges'] as $b)
          <span class="chip chip-blue">{{ $b }}</span>
        @endforeach
      </div>

      {{-- About --}}
      <div class="mt-3">
        <h3 class="h6 fw-bold">About</h3>
        <p class="mb-0 small text-muted">{!! $booster['about'] !!}</p>
      </div>

      {{-- Stats --}}
      <div class="stats-card mt-3">
        <div class="row g-0 align-items-center">
          <div class="col-6">
            <div class="stat-row">
              <span class="stat-ico">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M3 12h18M12 3v18" stroke="#ff4961" stroke-width="2" stroke-linecap="round"/></svg>
              </span>
              <span class="stat-name">Work Hours</span>
            </div>
          </div>
          <div class="col-6 text-end small text-muted">{{ $booster['work_hours'] }}</div>

          <div class="col-6 mt-2">
            <div class="stat-row">
              <span class="stat-ico">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 21s-8-4.5-8-11A5 5 0 0112 5a5 5 0 018 5c0 6.5-8 11-8 11z" stroke="#ff4961" stroke-width="2"/></svg>
              </span>
              <span class="stat-name">Satisfaction</span>
            </div>
          </div>
          <div class="col-6 mt-2 text-end small text-muted">{{ $booster['satisfaction'] }}</div>

          <div class="col-6 mt-2">
            <div class="stat-row">
              <span class="stat-ico">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M7 21V7m0 0l5-3 5 3v14" stroke="#ff4961" stroke-width="2" stroke-linecap="round"/></svg>
              </span>
              <span class="stat-name">Customers</span>
            </div>
          </div>
          <div class="col-6 mt-2 text-end small text-muted">{{ $booster['customers'] }}</div>
        </div>
      </div>

      {{-- CTA --}}
      <div class="d-flex gap-3 mt-3">
        <a class="btn btn-cta flex-fill" href="#">Work Queue</a>
        <a class="btn btn-cta flex-fill" href="#">Reviews</a>
      </div>
    </div>

    <hr class="section-divider">

    {{-- Booster Games --}}
    <div class="container px-3">
      <h3 class="h6 fw-bold mb-2">Booster Games</h3>
      <div class="games-scroll">
        @foreach($games as $g)
          <a class="game-card" href="{{ route('games.show', $g['game_id']) }}">
            <img src="{{ $g['poster'] }}" alt="{{ $g['game_name'] }}">
            <span class="game-title">{!! str_replace(' ', '<br>', e($g['game_name'])) !!}</span>
          </a>
        @endforeach
      </div>
    </div>

    <hr class="section-divider">

    {{-- Services --}}
    <div class="container px-3 pb-5">
      <h3 class="h6 fw-bold mb-2">Services</h3>

      <div class="d-flex align-items-center gap-2 mb-2">
        <form method="GET" action="{{ route('booster.profile', $booster_id) }}" style="display: flex; align-items: center; gap: 8px;">
          <!-- Filter by Rating -->
          <select name="filter" onchange="this.form.submit()" style="display:inline-flex; align-items:center; gap:6px; height:34px; padding:0 10px; background:#EAF4FA; color:#1572A0; border:1px solid #C9E2F1; border-radius:10px; font-weight:700; font-size: 14px; cursor: pointer;">
            <span style="display: none;">Filter</span>
            <option value="">Filter</option>
            <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All</option>
            <option value="rank" {{ request('filter') == 'rank' ? 'selected' : '' }}>Rank Boost</option>
            <option value="winrate" {{ request('filter') == 'winrate' ? 'selected' : '' }}>Winrate</option>
            <option value="other" {{ request('filter') == 'other' ? 'selected' : '' }}>Other</option>
          </select>

          <!-- Sort By -->
          <select name="sort" onchange="this.form.submit()" style="display:inline-flex; align-items:center; gap:6px; height:34px; padding:0 10px; background:#EAF4FA; color:#1572A0; border:1px solid #C9E2F1; border-radius:10px; font-weight:700; font-size: 14px; cursor: pointer;">
            <span style="display: none;">Sort</span>
            <option value="">Sort</option>
            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
            <option value="rating_asc" {{ request('sort') == 'rating_asc' ? 'selected' : '' }}>Rating (Low to High)</option>
            <option value="rating_desc" {{ request('sort') == 'rating_desc' ? 'selected' : '' }}>Rating (High to Low)</option>
          </select>
        </form>
      </div>

      <div class="row g-3">
        @foreach($services as $s)
          <div class="col-6">
            <a class="srv-card" href="#">
              <div class="srv-thumb">
                <img src="{{ $s['thumb'] }}" alt="">
                <span class="srv-badge {{ strtolower($s['status']) === 'open' ? 'open' : 'closed' }}">
                  {{ strtolower($s['status']) === 'open' ? 'Open' : 'Closed' }}
                </span>
              </div>
              <div class="srv-body">
                <div class="srv-title">{{ $s['service_name'] }}</div>
                <div class="srv-sub">{{ $s['game_name'] }}</div>
                <div class="srv-price">Rp{{ number_format($s['price'], 0, ',', '.') }}+</div>
                <div class="srv-meta"><span>{{ $s['sold'] }}</span><span>{{ $s['rating'] }}</span></div>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    </div>

  </section>

  <div class="home-indicator" aria-hidden="true"></div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
