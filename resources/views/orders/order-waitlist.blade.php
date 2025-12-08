{{-- resources/views/orders/order-waitlist.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Order Detail • Waitlisted</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/order-detail.css') }}" rel="stylesheet">
</head>
<body class="preview-center">
<main class="device-frame">

  {{-- Status bar --}}
  <div class="status-bar d-flex align-items-center justify-content-between px-3">
    <div>9:41</div>
    <div class="d-flex align-items-center gap-2">
      <svg width="20" height="12" viewBox="0 0 20 12"><rect x="1" y="7" width="2" height="4" rx=".75"/><rect x="5" y="5" width="2" height="6" rx=".75"/><rect x="9" y="3" width="2" height="8" rx=".75"/><rect x="13" y="1" width="2" height="10" rx=".75"/></svg>
      <svg width="18" height="12" viewBox="0 0 18 12" fill="none"><path d="M3 6.5c3.9-3.2 8.1-3.2 12 0" stroke="#000" stroke-width="1.6" stroke-linecap="round"/><path d="M5.6 8c2.53-2.05 4.27-2.05 6.8 0" stroke="#000" stroke-width="1.6" stroke-linecap="round"/><circle cx="9" cy="10.5" r="1.2" fill="#000"/></svg>
      <svg width="26" height="12" viewBox="0 0 26 12" fill="none"><rect x="1" y="1" width="20" height="10" rx="2" stroke="#000" stroke-width="1.5"/><rect x="3" y="3" width="16" height="6" rx="1.5" fill="#000"/><rect x="22" y="4" width="3" height="4" rx="1" fill="#000"/></svg>
    </div>
  </div>

  <section class="safe-area">
    {{-- App bar --}}
    <div class="appbar d-flex align-items-center justify-content-between px-3">
      <a href="{{ url()->previous() }}" class="icon-ghost" aria-label="Back">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M15 6l-6 6 6 6" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
      <div class="app-title">Order Detail</div>
      <a href="#" class="icon-ghost" aria-label="Help">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="#111" stroke-width="1.8"/><path d="M9.5 9a2.5 2.5 0 015 0c0 1.8-2 2-2 3.5" stroke="#111" stroke-width="1.8" stroke-linecap="round"/><circle cx="12" cy="17" r="1.2" fill="#111"/></svg>
      </a>
    </div>

    <div class="section pt-3">
      @php
        use Illuminate\Support\Str;
        $statusName = $order->orderStatus->order_status_name ?? 'Waitlisted';
        $item = $order->orderItems->first();
        $boosterName = $item?->service?->booster?->user?->user_name ?? ($item?->service?->booster?->booster_desc ?? 'Booster');
        $thumb = $item?->service?->game ? asset('assets/' . Str::slug($item->service->game->game_name) . '.png') : asset('assets/Natlan.png');
        $payment = $order->payments->first();
        $paymentMethod = $payment?->paymentMethod?->method_name ?? 'Not specified';
        $subtotal = $order->subtotal_amount ?? 0;
        $discount = $order->discount_amount ?? 0;
        $total = $order->total_amount ?? 0;
      @endphp

      <span class="badge-chip badge-wait">{{ $statusName }}</span>

      <div class="mt-3 title-md">Order ID: <span class="fw-bold">#{{ $order->order_id }}</span>
        <svg width="16" height="16" viewBox="0 0 24 24" class="ms-1" aria-hidden="true"><rect x="4" y="4" width="12" height="14" rx="2" stroke="#444" stroke-width="1.8"/><path d="M8 2h8a2 2 0 012 2v14a2 2 0 01-2 2H8" stroke="#444" stroke-width="1.8"/></svg>
      </div>
      <div class="text-decoration-underline mt-2 mb-2 muted">{{ optional($order->order_date)->format('d F Y, H:i') }}</div>
      <div class="hr-soft"></div>

      {{-- Booster row --}}
      <div class="card-soft booster-row">
        <img src="{{ asset('assets/pp.jpg') }}" class="avatar" alt="Booster">
        <div class="name">{{ $boosterName }}</div>
        <button class="msg-btn" title="Message">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 8a6 6 0 016-6h4a6 6 0 016 6v2a6 6 0 01-6 6h-3l-4 3v-3H10a6 6 0 01-6-6V8z" stroke="#111" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
      </div>

      {{-- Service --}}
      <div class="card-soft">
        <div class="d-flex align-items-center gap-2">
          <img src="{{ $thumb }}" class="thumb" alt="">
          <div>
            <div class="fw-bold">{{ $item?->service?->service_desc ?? ($item?->service?->game?->game_name ?? 'Service') }}</div>
            <small class="muted">{{ $item?->service?->service_desc ?? '' }}</small>
          </div>
        </div>
        <div class="hr-soft mt-2"></div>
        @if(!empty($item?->service?->service_desc))
        <div class="fw-bold mt-2">Details:</div>
        <ul class="mb-0 mt-1">
          <li class="muted">{{ $item?->service?->service_desc }}</li>
        </ul>
        @endif
      </div>

      {{-- Payment --}}
      <div class="card-soft">
        <div class="fw-bold mb-2">Payment Detail:</div>
        <div class="kv"><small>Payment Method</small><small>{{ $paymentMethod }}</small></div>
        <div class="kv"><small>Subtotal</small><small>Rp{{ number_format($subtotal,0,',','.') }}</small></div>
        <div class="kv"><small>Discount</small><small>-Rp{{ number_format($discount,0,',','.') }}</small></div>
        <div class="kv"><b>Total</b><b>Rp{{ number_format($total,0,',','.') }}</b></div>
      </div>
    </div>

    {{-- Bottom actions --}}
    <div class="action-bar">
      <div class="d-flex gap-2">
        <button class="btn btn-gray btn-pill w-50" disabled>Track Order</button>
        <button class="btn btn-gray btn-pill w-50" disabled>Complete Order</button>
      </div>
    </div>
  </section>
  <div class="home-indicator"></div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
