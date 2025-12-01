{{-- resources/views/orders/track-order-completed.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/><meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Track Order • Completed</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/track-order.css') }}" rel="stylesheet">
</head>
<body class="preview-center">
<main class="device-frame">
  <div class="status-bar d-flex align-items-center justify-content-between px-3">
    <div class="time">9:41</div><div></div>
  </div>

  <section class="safe-area">
    <div class="appbar d-flex align-items-center justify-content-between px-3">
      <div class="d-flex align-items-center gap-2">
        <a href="{{ url()->previous() }}" class="text-dark text-decoration-none" aria-label="Back">
          <svg class="icon" viewBox="0 0 24 24" fill="none"><path d="M15 6l-6 6 6 6" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
        <strong>Track Order</strong>
      </div>
      <svg class="icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <circle cx="12" cy="12" r="9.5" stroke="#111" stroke-width="2"/>
      </svg>
    </div>

    <div class="p-3">
      <div class="box mb-3 header-meta">
        @php
          use Illuminate\Support\Str;
          $orderDate = optional($order->order_date);
          $statusName = $order->orderStatus->order_status_name ?? 'Unknown';
          $booster = $order->orderItems->first()?->service?->booster?->user?->user_name ?? 'Booster';
          $events = [];
          $events[] = ['date' => $orderDate, 'desc' => 'Order placed'];
          foreach($order->payments as $p) {
              $events[] = ['date' => optional($p->latest_update), 'desc' => 'Payment: ' . ($p->paymentMethod->method_name ?? $p->gateway_reference ?? 'Paid')];
          }
          // add a completion event if status is completed
          if (str_contains(strtolower($statusName), 'complete')) {
              $completeAt = $order->payments->first()?->latest_update ?? $orderDate;
              $events[] = ['date' => optional($completeAt), 'desc' => 'Service completed'];
          }
        @endphp
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="small text-muted">
              Order ID: <strong>#{{ $order->order_id }}</strong>
              <button class="copy-btn ms-2" type="button"
                      onclick="navigator.clipboard.writeText('#{{ $order->order_id }}')" aria-label="Copy Order ID">
                <img src="{{ asset('assets/copy.png') }}" alt="">
              </button>
            </div>
            <div class="small text-muted">{{ $orderDate->format('d F Y, H:i') }}</div>
          </div>
          <span class="pill-status status-done">{{ $statusName }}</span>
        </div>
      </div>

      <div class="box mb-3">
        <div class="small fw-semibold mb-1">Estimated time of completion:</div>
        <div class="small text-muted mb-2">25 June 2025</div>

        <div class="d-flex justify-content-between align-items-center stage-labels mb-1">
          <img src="{{ asset('assets/pending.png') }}"  alt="Pending">
          <img src="{{ asset('assets/progress.png') }}" alt="On-Progress">
          <img src="{{ asset('assets/completed.png') }}" alt="Completed">
        </div>

        <div class="position-relative mb-1">
          <div class="progress-rail"></div>
          <div class="progress-fill" style="width:100%"></div>
          <div class="handle" style="left:100%"></div>
        </div>
      </div>

        <div class="box">
        <div class="d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center gap-2">
            <img class="avatar" src="{{ asset('assets/pp.jpg') }}" alt="">
            <div class="fw-semibold">{{ $booster }}</div>
          </div>
          <svg class="icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M21 15a4 4 0 0 1-4 4H8l-5 3 1-5a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4h13a4 4 0 0 1 4 4v8z" stroke="#111" stroke-width="2"/>
          </svg>
        </div>
        <hr class="my-2">
        <div class="timeline" style="--progress:1">
          @foreach($events as $ev)
            <div class="tl-item done">
              <span class="tl-dot"></span>
              <div class="tl-content"><div class="date">{{ optional($ev['date'])->format('d F Y') }}</div><div class="desc">{{ $ev['desc'] }}</div></div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  {{-- Bottom actions --}}
  <div class="action-wrap">
    <div class="action-bar px-3">
      <a href="{{ route('orders.show', $order->order_id) }}" class="btn-cta btn-red">View Order</a>
      <a href="{{ route('orders.track', $order->order_id) }}" class="btn-cta btn-blue">Refresh</a>
    </div>
  </div>

  <div class="home-indicator"></div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
