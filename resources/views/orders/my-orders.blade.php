{{-- resources/views/orders/my-orders.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>JokiSure • My Orders</title>

  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- Page CSS --}}
  <link href="{{ asset('css/my-orders.css') }}" rel="stylesheet">
</head>
<body class="preview-center">
<main class="device-frame" role="main" aria-label="My Orders">

  {{-- STATUS BAR --}}
  <div class="status-bar d-flex align-items-center justify-content-between px-3">
    <div class="time">9:41</div>
    <div class="status-icons d-flex align-items-center gap-2">
      <svg width="20" height="12" viewBox="0 0 20 12" fill="none"><rect x="1" y="7" width="2" height="4" rx=".75" fill="#0a0a0a"/><rect x="5" y="5" width="2" height="6" rx=".75" fill="#0a0a0a"/><rect x="9" y="3" width="2" height="8" rx=".75" fill="#0a0a0a"/><rect x="13" y="1" width="2" height="10" rx=".75" fill="#0a0a0a"/></svg>
      <svg width="18" height="12" viewBox="0 0 18 12" fill="none"><path d="M9 9.5c.7 0 1.25.55 1.25 1.25S9.7 12 9 12 7.75 11.45 7.75 10.75 8.3 9.5 9 9.5Z" fill="#0a0a0a"/><path d="M3 6.5c3.9-3.2 8.1-3.2 12 0" stroke="#0a0a0a" stroke-width="1.6" stroke-linecap="round"/><path d="M5.6 8c2.53-2.05 4.27-2.05 6.8 0" stroke="#0a0a0a" stroke-width="1.6" stroke-linecap="round"/></svg>
      <svg width="26" height="12" viewBox="0 0 26 12" fill="none"><rect x="1" y="1" width="20" height="10" rx="2" stroke="#0a0a0a" stroke-width="1.5"/><rect x="3" y="3" width="16" height="6" rx="1.5" fill="#0a0a0a"/><rect x="22" y="4" width="3" height="4" rx="1" fill="#0a0a0a"/></svg>
    </div>
  </div>

  {{-- SAFE AREA --}}
  <section class="safe-area">

    {{-- APP BAR --}}
    <div class="appbar d-flex align-items-center justify-content-between px-3">
      <a href="{{ route('profile.show') }}" class="icon-btn" aria-label="Back">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M6 12h12M10 8l-4 4 4 4" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
      <div class="fw-semibold">My Orders</div>
      <a href="#" class="icon-btn" aria-label="Help">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="#0a0a0a" stroke-width="2"/><path d="M9.5 9a2.5 2.5 0 1 1 4.33 1.67c-.6.6-1.33.97-1.83 1.58-.3.36-.5.75-.5 1.25v.5" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="17" r="1" fill="#0a0a0a"/></svg>
      </a>
    </div>

      {{-- ALL --}}
      <div class="tab-pane fade show active" id="tab-all" role="tabpanel" tabindex="0">
        <div class="container px-3">
          @php
            /** helper for currency formatting */
            function format_rp($v) { return 'Rp' . number_format($v, 0, ',', '.'); }
          @endphp
{{-- resources/views/orders/my-orders.blade.php --}}
@php
use Illuminate\Support\Str;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>JokiSure • My Orders</title>

  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- Page CSS --}}
  <link href="{{ asset('css/my-orders.css') }}" rel="stylesheet">
</head>
<body class="preview-center">
<main class="device-frame" role="main" aria-label="My Orders">

  {{-- STATUS BAR --}}
  <div class="status-bar d-flex align-items-center justify-content-between px-3">
    <div class="time">9:41</div>
    <div class="status-icons d-flex align-items-center gap-2">
      <svg width="20" height="12" viewBox="0 0 20 12" fill="none"><rect x="1" y="7" width="2" height="4" rx=".75" fill="#0a0a0a"/><rect x="5" y="5" width="2" height="6" rx=".75" fill="#0a0a0a"/><rect x="9" y="3" width="2" height="8" rx=".75" fill="#0a0a0a"/><rect x="13" y="1" width="2" height="10" rx=".75" fill="#0a0a0a"/></svg>
      <svg width="18" height="12" viewBox="0 0 18 12" fill="none"><path d="M9 9.5c.7 0 1.25.55 1.25 1.25S9.7 12 9 12 7.75 11.45 7.75 10.75 8.3 9.5 9 9.5Z" fill="#0a0a0a"/><path d="M3 6.5c3.9-3.2 8.1-3.2 12 0" stroke="#0a0a0a" stroke-width="1.6" stroke-linecap="round"/><path d="M5.6 8c2.53-2.05 4.27-2.05 6.8 0" stroke="#0a0a0a" stroke-width="1.6" stroke-linecap="round"/></svg>
      <svg width="26" height="12" viewBox="0 0 26 12" fill="none"><rect x="1" y="1" width="20" height="10" rx="2" stroke="#0a0a0a" stroke-width="1.5"/><rect x="3" y="3" width="16" height="6" rx="1.5" fill="#0a0a0a"/><rect x="22" y="4" width="3" height="4" rx="1" fill="#0a0a0a"/></svg>
    </div>
  </div>

  {{-- SAFE AREA --}}
  <section class="safe-area">

    {{-- APP BAR --}}
    <div class="appbar d-flex align-items-center justify-content-between px-3">
      <a href="{{ route('profile.show') }}" class="icon-btn" aria-label="Back">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M6 12h12M10 8l-4 4 4 4" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
      <div class="fw-semibold">My Orders</div>
      <a href="#" class="icon-btn" aria-label="Help">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="#0a0a0a" stroke-width="2"/><path d="M9.5 9a2.5 2.5 0 1 1 4.33 1.67c-.6.6-1.33.97-1.83 1.58-.3.36-.5.75-.5 1.25v.5" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="17" r="1" fill="#0a0a0a"/></svg>
      </a>
    </div>

    {{-- SEARCH --}}
    <div class="px-3 mt-2">
      <div class="search-wrap">
        <svg viewBox="0 0 24 24"><path d="M11 19a8 8 0 1 1 6.32-3.1L22 20.6 20.6 22l-4.7-4.7A8 8 0 0 1 11 19Z" fill="#8d8d8d"/></svg>
        <input type="search" class="form-control" placeholder="Search">
      </div>
    </div>

    {{-- TABS --}}
    <div class="tabs-text px-3">
      <ul class="nav nav-underline flex-nowrap" id="ordersTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active no-wrap" data-bs-toggle="tab" data-bs-target="#tab-all" type="button" role="tab">All</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link no-wrap" data-bs-toggle="tab" data-bs-target="#tab-waitlist" type="button" role="tab">Waitlist</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link no-wrap" data-bs-toggle="tab" data-bs-target="#tab-pending" type="button" role="tab">Pending</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link no-wrap" data-bs-toggle="tab" data-bs-target="#tab-progress" type="button" role="tab">On Progress</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link no-wrap" data-bs-toggle="tab" data-bs-target="#tab-completed" type="button" role="tab">Completed</button>
        </li>
      </ul>
    </div>

    {{-- CONTENT --}}
    <div class="tab-content mt-2 pb-5">

      {{-- ALL --}}
      <div class="tab-pane fade show active" id="tab-all" role="tabpanel" tabindex="0">
        <div class="container px-3">
          @php
            function format_rp($v) { return 'Rp' . number_format($v ?? 0, 0, ',', '.'); }
          @endphp

          @forelse($orders as $order)
            @php
              $item = $order->orderItems->first();
              $serviceName = $item && $item->service && $item->service->game ? $item->service->game->game_name : ($item && $item->service ? ($item->service->service_desc ?? 'Service') : 'Order');
              $thumb = asset('assets/default-thumb.png');
              $status = $order->orderStatus->order_status_name ?? 'Unknown';
            @endphp

            <div class="order-card">
              <div class="d-flex align-items-start gap-3">
                <img class="thumb" src="{{ $thumb }}" alt="">
                <div class="flex-grow-1">
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="fw-semibold small">{{ $item && $item->service && $item->service->booster ? ($item->service->booster->user->user_name ?? 'Booster') : 'Booster' }}</div>
                    <span class="badge-status {{ Str::slug(strtolower($status)) }}">{{ $status }}</span>
                  </div>
                  <div class="muted-xxs">{{ optional($order->order_date)->format('d M Y') }}</div>
                  <div class="title">{{ $serviceName }}</div>
                  <div class="price-row"><div>Total Price:</div><div class="fw-semibold">{{ format_rp($order->total_amount) }}</div></div>
                </div>
              </div>
              <div class="mt-2 text-end"><a href="{{ route('orders.show', $order->order_id) }}" class="btn btn-outline-secondary btn-xxs">Track Order</a></div>
            </div>

          @empty
            <div class="py-4 text-center muted-xxs">You have no orders yet.</div>
          @endforelse
        </div>
      </div>

      {{-- WAITLIST --}}
      <div class="tab-pane fade" id="tab-waitlist" role="tabpanel" tabindex="0">
        <div class="container px-3">
          @php $waitlist = $orders->filter(fn($o) => str_contains(strtolower($o->orderStatus->order_status_name ?? ''),'wait')); @endphp
          @forelse($waitlist as $order)
            @php $item = $order->orderItems->first(); @endphp
            <div class="order-card">
              <div class="d-flex align-items-start gap-3">
                <img class="thumb" src="{{ asset('assets/default-thumb.png') }}" alt="">
                <div class="flex-grow-1">
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="fw-semibold small">{{ $item && $item->service && $item->service->booster ? ($item->service->booster->user->user_name ?? 'Booster') : 'Booster' }}</div>
                    <span class="badge-status waitlist">{{ $order->orderStatus->order_status_name }}</span>
                  </div>
                  <div class="muted-xxs">{{ optional($order->order_date)->format('d M Y') }}</div>
                  <div class="title">{{ $item?->service?->service_desc ?? 'Order' }}</div>
                  <div class="price-row"><div>Total Price:</div><div class="fw-semibold">{{ format_rp($order->total_amount) }}</div></div>
                </div>
              </div>
              <div class="mt-2 text-end"><a href="{{ route('orders.show', $order->order_id) }}" class="btn btn-outline-secondary btn-xxs">Track Order</a></div>
            </div>
          @empty
            <div class="py-4 text-center muted-xxs">No waitlisted orders.</div>
          @endforelse
        </div>
      </div>

      {{-- PENDING --}}
      <div class="tab-pane fade" id="tab-pending" role="tabpanel" tabindex="0">
        <div class="container px-3">
          @php $pending = $orders->filter(fn($o) => str_contains(strtolower($o->orderStatus->order_status_name ?? ''),'pending')); @endphp
          @forelse($pending as $order)
            @php $item = $order->orderItems->first(); @endphp
            <div class="order-card">
              <div class="d-flex align-items-start gap-3">
                <img class="thumb" src="{{ asset('assets/default-thumb.png') }}" alt="">
                <div class="flex-grow-1">
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="fw-semibold small">{{ $item?->service?->booster?->user->user_name ?? 'Booster' }}</div>
                    <span class="badge-status pending">{{ $order->orderStatus->order_status_name }}</span>
                  </div>
                  <div class="muted-xxs">{{ optional($order->order_date)->format('d M Y') }}</div>
                  <div class="title">{{ $item?->service?->service_desc ?? 'Order' }}</div>
                  <div class="price-row"><div>Total Price:</div><div class="fw-semibold">{{ format_rp($order->total_amount) }}</div></div>
                </div>
              </div>
              <div class="mt-2 text-end"><a href="{{ route('orders.show', $order->order_id) }}" class="btn btn-outline-secondary btn-xxs">Track Order</a></div>
            </div>
          @empty
            <div class="py-4 text-center muted-xxs">No pending orders.</div>
          @endforelse
        </div>
      </div>

      {{-- ON PROGRESS --}}
      <div class="tab-pane fade" id="tab-progress" role="tabpanel" tabindex="0">
        <div class="container px-3">
          @php $progress = $orders->filter(fn($o) => str_contains(strtolower($o->orderStatus->order_status_name ?? ''),'progress') || str_contains(strtolower($o->orderStatus->order_status_name ?? ''),'on progress')); @endphp
          @forelse($progress as $order)
            @php $item = $order->orderItems->first(); @endphp
            <div class="order-card">
              <div class="d-flex align-items-start gap-3">
                <img class="thumb" src="{{ asset('assets/default-thumb.png') }}" alt="">
                <div class="flex-grow-1">
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="fw-semibold small">{{ $item?->service?->booster?->user->user_name ?? 'Booster' }}</div>
                    <span class="badge-status progress">{{ $order->orderStatus->order_status_name }}</span>
                  </div>
                  <div class="muted-xxs">{{ optional($order->order_date)->format('d M Y') }}</div>
                  <div class="title">{{ $item?->service?->service_desc ?? 'Order' }}</div>
                  <div class="price-row"><div>Total Price:</div><div class="fw-semibold">{{ format_rp($order->total_amount) }}</div></div>
                </div>
              </div>
              <div class="mt-2 text-end"><a href="{{ route('orders.show', $order->order_id) }}" class="btn btn-outline-secondary btn-xxs">Track Order</a></div>
            </div>
          @empty
            <div class="py-4 text-center muted-xxs">No in-progress orders.</div>
          @endforelse
        </div>
      </div>

      {{-- COMPLETED --}}
      <div class="tab-pane fade" id="tab-completed" role="tabpanel" tabindex="0">
        <div class="container px-3">
          @php $completed = $orders->filter(fn($o) => str_contains(strtolower($o->orderStatus->order_status_name ?? ''),'complete')); @endphp
          @forelse($completed as $order)
            @php $item = $order->orderItems->first(); @endphp
            <div class="order-card">
              <div class="d-flex align-items-start gap-3">
                <img class="thumb" src="{{ asset('assets/default-thumb.png') }}" alt="">
                <div class="flex-grow-1">
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="fw-semibold small">{{ $item?->service?->booster?->user->user_name ?? 'Booster' }}</div>
                    <span class="badge-status completed">{{ $order->orderStatus->order_status_name }}</span>
                  </div>
                  <div class="muted-xxs">{{ optional($order->order_date)->format('d M Y') }}</div>
                  <div class="title">{{ $item?->service?->service_desc ?? 'Order' }}</div>
                  <div class="price-row"><div>Total Price:</div><div class="fw-semibold">{{ format_rp($order->total_amount) }}</div></div>
                </div>
              </div>
              <div class="mt-2 d-flex gap-2 justify-content-end">
                <a href="{{ route('orders.show', $order->order_id) }}" class="btn btn-outline-secondary btn-xxs">View</a>
                <a href="{{ route('orders.show', $order->order_id) }}" class="btn btn-outline-secondary btn-xxs">Review</a>
              </div>
            </div>
          @empty
            <div class="py-4 text-center muted-xxs">No completed orders.</div>
          @endforelse
        </div>
      </div>

    </div>
  </section>

  {{-- BOTTOM NAV --}}
  <nav class="bottom-nav">
    <a href="#" class="tab">
      <svg viewBox="0 0 24 24"><path d="M3 10.5 12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1v-10.5Z" fill="none" stroke="#777" stroke-width="1.8"/></svg>
      <span>Home</span>
    </a>
    <a href="#" class="tab">
      <svg viewBox="0 0 24 24"><path d="M7 7h10l1 10H6l1-10Zm2 0V5a3 3 0 1 1 6 0v2" fill="none" stroke="#777" stroke-width="1.8" stroke-linecap="round"/></svg>
      <span>Cart</span>
    </a>
    <a href="#" class="tab">
      <svg viewBox="0 0 24 24"><path d="M20 16a4 4 0 0 1-4 4H6l-2 2V8a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v8Z" fill="none" stroke="#777" stroke-width="1.8"/></svg>
      <span>Message</span>
    </a>
    <a href="#" class="tab">
      <svg viewBox="0 0 24 24"><path d="M12 5V3m6 10a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" fill="none" stroke="#777" stroke-width="1.8"/></svg>
      <span>Notification</span>
    </a>
    <a href="{{ route('profile.show') }}" class="tab active">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" fill="none" stroke="#ff4961" stroke-width="1.8"/><path d="M4 21a8 8 0 0 1 16 0" fill="none" stroke="#ff4961" stroke-width="1.8"/></svg>
      <span class="active">Profile</span>
    </a>
  </nav>

  <div class="home-indicator" aria-hidden="true"></div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
      <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" fill="none" stroke="#ff4961" stroke-width="1.8"/><path d="M4 21a8 8 0 0 1 16 0" fill="none" stroke="#ff4961" stroke-width="1.8"/></svg>
      <span class="active">Profile</span>
    </a>
  </nav>

  <div class="home-indicator" aria-hidden="true"></div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
