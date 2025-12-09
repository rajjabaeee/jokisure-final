<!-- 5026231002 | Aisya Candra Kirana Dewi (Velyven) -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>JokiSure • Booster Profile</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  {{-- Make sure this file exists in public/css/ --}}
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

      @php
        $backUrl = route('home'); // Default to home
        if ($referrer === 'boosters') {
          $backUrl = route('boosters');
        } elseif ($referrer === 'game') {
          $backUrl = url()->previous(); // For game detail, use previous URL
        }
      @endphp
      <a href="{{ $backUrl }}" class="btn-back" aria-label="Back">
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
          <a href="{{ route('chat.show', $booster['user_id']) }}" class="icon-btn" title="Chat">
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
        <button class="btn btn-cta flex-fill" onclick="openOverlay('work-queue')" style="border: none; background: #ff4961; color: #fff; padding: 0; cursor: pointer; font-weight: 700; transition: all 0.2s ease;" onmousedown="this.style.background='#fff'; this.style.color='#ff4961'; this.style.border='2px solid #ff4961';" onmouseup="this.style.background='#ff4961'; this.style.color='#fff'; this.style.border='none';" onmouseleave="this.style.background='#ff4961'; this.style.color='#fff'; this.style.border='none';">Work Queue</button>
        <button class="btn btn-cta flex-fill" onclick="openOverlay('reviews')" style="border: none; background: #ff4961; color: #fff; padding: 0; cursor: pointer; font-weight: 700; transition: all 0.2s ease;" onmousedown="this.style.background='#fff'; this.style.color='#ff4961'; this.style.border='2px solid #ff4961';" onmouseup="this.style.background='#ff4961'; this.style.color='#fff'; this.style.border='none';" onmouseleave="this.style.background='#ff4961'; this.style.color='#fff'; this.style.border='none';">Reviews</button>
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
        <form method="GET" action="{{ route('booster.profile', $booster_id) }}" style="display: flex; align-items: center; gap: 8px; width: 100%;">
          <input type="hidden" name="referrer" value="{{ $referrer }}">>
          <!-- Filter by Rating -->
          <select name="filter" onchange="this.form.submit()" style="display:inline-flex; align-items:center; gap:6px; height:34px; padding:0 10px; background:#EAF4FA; color:#1572A0; border:1px solid #C9E2F1; border-radius:10px; font-weight:700; font-size: 14px; cursor: pointer; z-index: 10; position: relative;">
            <span style="display: none;">Filter</span>
            <option value="">Filter</option>
            <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All</option>
            <option value="rank" {{ request('filter') == 'rank' ? 'selected' : '' }}>Rank Boost</option>
            <option value="winrate" {{ request('filter') == 'winrate' ? 'selected' : '' }}>Winrate</option>
            <option value="other" {{ request('filter') == 'other' ? 'selected' : '' }}>Other</option>
          </select>

          <!-- Sort By -->
          <select name="sort" onchange="this.form.submit()" style="display:inline-flex; align-items:center; gap:6px; height:34px; padding:0 10px; background:#EAF4FA; color:#1572A0; border:1px solid #C9E2F1; border-radius:10px; font-weight:700; font-size: 14px; cursor: pointer; z-index: 10; position: relative;">
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
            <a class="srv-card" href="{{ route('service.detail.confirm', $s['service_id']) }}">
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

  {{-- Overlays --}}
  <div id="work-queue-overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); z-index: 1000; padding: 16px;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; border-radius: 16px; padding: 24px; max-width: 90%; width: 340px; max-height: 80vh; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); overflow-y: auto;">
      <button onclick="closeOverlay('work-queue')" style="position: absolute; top: 12px; right: 12px; background: none; border: none; font-size: 24px; cursor: pointer; color: #999;">&times;</button>
      <h2 style="margin: 0 0 16px 0; font-size: 18px; font-weight: 700; color: #0a0a0a;">Work Queue</h2>
      
      @php
        $statusCounts = [
          'all' => $workQueueOrders->count(),
          'waitlist' => $workQueueOrders->filter(function($o) { return strtolower(str_replace(' ', '-', $o->orderStatus->order_status_name)) === 'waitlist'; })->count(),
          'pending' => $workQueueOrders->filter(function($o) { return strtolower(str_replace(' ', '-', $o->orderStatus->order_status_name)) === 'pending'; })->count(),
          'on-progress' => $workQueueOrders->filter(function($o) { return strtolower(str_replace(' ', '-', $o->orderStatus->order_status_name)) === 'on-progress'; })->count(),
          'completed' => $workQueueOrders->filter(function($o) { return strtolower(str_replace(' ', '-', $o->orderStatus->order_status_name)) === 'completed'; })->count(),
        ];
      @endphp
      
      <!-- Filter Bar -->
      <div style="display: flex; gap: 8px; margin-bottom: 16px;">
        <select id="statusFilter" onchange="filterByStatus()" style="padding: 8px 16px; background: #e3f2fd; color: #1976d2; border: none; border-radius: 20px; font-size: 13px; font-weight: 600; cursor: pointer;">
          <option value="all">All</option>
          <option value="waitlist">Waitlist</option>
          <option value="pending">Pending</option>
          <option value="on-progress">On Progress</option>
          <option value="completed">Completed</option>
        </select>
      </div>

      <!-- Status Summary Bars -->
      @php
        $statusLabels = [
          'waitlist' => 'Waitlist',
          'pending' => 'Pending',
          'on-progress' => 'On Progress',
          'completed' => 'Completed'
        ];
        $statusColors = [
          'waitlist' => '#d8b4fe',
          'pending' => '#ffa500',
          'on-progress' => '#336791',
          'completed' => '#32cd32'
        ];
      @endphp

      @foreach($statusLabels as $statusKey => $statusLabel)
        @if($statusCounts[$statusKey] > 0)
          <div style="margin-bottom: 10px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
              <span style="font-size: 13px; font-weight: 600; color: #333;">{{ $statusLabel }}</span>
              <span style="font-size: 12px; color: #999;">{{ $statusCounts[$statusKey] }}</span>
            </div>
            <div style="height: 10px; background: #f0f0f0; border-radius: 5px; overflow: hidden;">
              <div style="height: 100%; background: {{ $statusColors[$statusKey] }}; width: {{ ($statusCounts[$statusKey] / $statusCounts['all']) * 100 }}%; transition: width 0.3s ease;"></div>
            </div>
          </div>
        @endif
      @endforeach

      <div style="height: 1px; background: #e9e9e9; margin: 16px 0;"></div>
      
      @if($workQueueOrders && $workQueueOrders->count() > 0)
        @foreach($workQueueOrders as $order)
          @php
            $item = $order->orderItems->first();
            $gameName = $item->service->game->game_name ?? 'Unknown Game';
            $serviceName = $item->service->service_desc ?? 'Service';
            $fullTitle = $gameName . ' - ' . $serviceName;
            $buyerName = $item->buyer->user->user_name ?? 'Buyer';
            $rawStatus = $order->orderStatus->order_status_name ?? 'Unknown';
            $statusClass = strtolower(str_replace(' ', '-', $rawStatus));
            $date = \Carbon\Carbon::parse($order->order_date)->format('d F Y');
          @endphp
          <div class="work-queue-item" data-status="{{ $statusClass }}" style="background: #f9f9f9; border-radius: 12px; padding: 12px; margin-bottom: 12px; border: 1px solid #e9e9e9;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
              <div>
                <div style="font-weight: 700; font-size: 14px; color: #0a0a0a;">{{ $buyerName }}</div>
                <div style="font-size: 12px; color: #888;">{{ $date }}</div>
              </div>
              <span style="padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; color: #fff; background-color: {{ $statusClass === 'waitlist' ? '#d8b4fe' : ($statusClass === 'pending' ? '#ffa500' : ($statusClass === 'on-progress' ? '#336791' : '#32cd32')) }};">
                {{ $rawStatus }}
              </span>
            </div>
            <div style="font-size: 13px; color: #333; margin-bottom: 8px;">{{ $fullTitle }}</div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <div style="font-size: 13px; color: #0a0a0a; font-weight: 600;">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</div>
              <a href="{{ route('orders.show', $order->order_id) }}" style="font-size: 12px; color: #0066cc; text-decoration: none; font-weight: 600;">View Details →</a>
            </div>
          </div>
        @endforeach
      @else
        <p style="color: #999; text-align: center; padding: 20px 0;">No work queue items available.</p>
      @endif
    </div>
  </div>

  <div id="reviews-overlay" style="display: none; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); z-index: 1000; border-radius: 40px; padding: 20px;">
    <div style="position: absolute; top: 80px; left: 20px; right: 20px; bottom: 60px; background: #fff; border-radius: 20px; overflow-y: auto; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);"
      <!-- Header -->
      <div style="position: sticky; top: 0; background: #fff; padding: 16px 20px 12px; border-bottom: 1px solid #eee; z-index: 10; border-radius: 20px 20px 0 0;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
          <h2 style="margin: 0; font-size: 18px; font-weight: 700; color: #0a0a0a;">Reviews</h2>
          <button onclick="closeOverlay('reviews')" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #999; padding: 0; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        
        <!-- Booster Name -->
        <div style="display: flex; align-items: center; gap: 10px; margin-top: 12px;">
          <img src="{{ asset('assets/' . str()->slug($booster['name']) . '.jpg') }}" alt="{{ $booster['name'] }}" style="width: 36px; height: 36px; border-radius: 8px; object-fit: cover;">
          <span style="font-size: 16px; font-weight: 600; color: #0a0a0a;">{{ $booster['name'] }}</span>
        </div>

        <!-- Filter Bar -->
        <div style="display: flex; gap: 8px; margin-top: 16px;">
          <select id="reviewFilter" onchange="filterReviews()" style="padding: 6px 14px; background: #e3f2fd; color: #1976d2; border: none; border-radius: 18px; font-size: 13px; font-weight: 600; cursor: pointer; min-width: 70px;">
            <option value="all">All</option>
            <option value="5">5 Stars</option>
            <option value="4">4 Stars</option>
            <option value="3">3 Stars</option>
            <option value="2">2 Stars</option>
            <option value="1">1 Star</option>
          </select>
          <select style="padding: 6px 14px; background: #f5f5f5; color: #666; border: none; border-radius: 18px; font-size: 13px; font-weight: 600; min-width: 70px;">
            <option>Star</option>
          </select>
        </div>

        <!-- Rating Statistics -->
        @if($rating_stats['total'] > 0)
        <div style="margin-top: 16px;">
          @for($i = 5; $i >= 1; $i--)
          <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
            <span style="font-size: 14px; font-weight: 600; width: 10px;">{{ $i }}</span>
            <div style="flex: 1; height: 8px; background: #f0f0f0; border-radius: 4px; overflow: hidden;">
              @php
                $percentage = $rating_stats['total'] > 0 ? ($rating_stats['distribution'][$i] / $rating_stats['total']) * 100 : 0;
              @endphp
              <div style="height: 100%; background: #ff4961; width: {{ $percentage }}%; transition: width 0.3s ease;"></div>
            </div>
          </div>
          @endfor
        </div>
        @endif
      </div>

      <!-- Reviews List -->
      <div style="padding: 0 20px 80px;">
        @if($reviews && $reviews->count() > 0)
          @foreach($reviews as $review)
          <div class="review-item" data-rating="{{ $review['rating'] }}" style="padding: 16px 0; border-bottom: 1px solid #f0f0f0;">
            <!-- User Header -->
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
              <div style="width: 36px; height: 36px; background: {{ ['#ff4961', '#2196f3', '#4caf50', '#ff9800', '#9c27b0'][array_rand(['#ff4961', '#2196f3', '#4caf50', '#ff9800', '#9c27b0'])] }}; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700;">
                {{ $review['user_initial'] }}
              </div>
              <span style="font-size: 16px; font-weight: 600; color: #0a0a0a;">{{ $review['user_name'] }}</span>
            </div>

            <!-- Rating Stars -->
            <div style="display: flex; align-items: center; gap: 2px; margin-bottom: 10px;">
              @for($i = 1; $i <= 5; $i++)
                @if($i <= $review['rating'])
                  <span style="color: #ffd700; font-size: 16px;">★</span>
                @else
                  <span style="color: #ddd; font-size: 16px;">★</span>
                @endif
              @endfor
            </div>

            <!-- Review Text -->
            <p style="margin: 0 0 10px 0; font-size: 14px; line-height: 1.4; color: #333;">{{ $review['review_text'] }}</p>
            
            <!-- Service Info -->
            <p style="margin: 0; font-size: 12px; color: #888; font-weight: 600;">Order: {{ $review['service_name'] }}</p>
          </div>
          @endforeach
        @else
          <div style="text-align: center; padding: 50px 20px; color: #999;">
            <p style="margin: 0; font-size: 16px;">No reviews available yet.</p>
          </div>
        @endif
      </div>
    </div>
  </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openOverlay(overlayId) {
  const overlay = document.getElementById(overlayId + '-overlay');
  if (overlay) {
    overlay.style.display = 'block';
    document.body.style.overflow = 'hidden'; // Prevent background scroll
  }
}

function closeOverlay(overlayId) {
  const overlay = document.getElementById(overlayId + '-overlay');
  if (overlay) {
    overlay.style.display = 'none';
    document.body.style.overflow = 'auto'; // Restore background scroll
  }
}

function filterByStatus() {
  const filterValue = document.getElementById('statusFilter').value;
  const workQueueItems = document.querySelectorAll('.work-queue-item');
  
  workQueueItems.forEach(item => {
    if (filterValue === 'all') {
      item.style.display = 'block';
    } else {
      const status = item.getAttribute('data-status');
      if (status === filterValue) {
        item.style.display = 'block';
      } else {
        item.style.display = 'none';
      }
    }
  });
}

function filterReviews() {
  const filterValue = document.getElementById('reviewFilter').value;
  const reviewItems = document.querySelectorAll('.review-item');
  
  reviewItems.forEach(item => {
    if (filterValue === 'all') {
      item.style.display = 'block';
    } else {
      const rating = item.getAttribute('data-rating');
      if (rating === filterValue) {
        item.style.display = 'block';
      } else {
        item.style.display = 'none';
      }
    }
  });
}

// Close overlay when clicking outside the modal
document.addEventListener('click', function(event) {
  const workQueueOverlay = document.getElementById('work-queue-overlay');
  const reviewsOverlay = document.getElementById('reviews-overlay');
  
  if (event.target === workQueueOverlay) {
    closeOverlay('work-queue');
  }
  if (event.target === reviewsOverlay) {
    closeOverlay('reviews');
  }
});
</script>
</body>
</html>
