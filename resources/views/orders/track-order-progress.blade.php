{{-- resources/views/orders/track-order-progress.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/><meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Track Order • On-Progress</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/track-order.css') }}" rel="stylesheet">
</head>
<body class="preview-center">
<main class="device-frame">
  {{-- Status bar --}}
  <div class="status-bar d-flex align-items-center justify-content-between px-3">
    <div class="time">9:41</div><div></div>
  </div>

  <section class="safe-area">
    {{-- App bar --}}
    <div class="appbar d-flex align-items-center justify-content-between px-3">
      <div class="d-flex align-items-center gap-2">
        <a href="{{ url()->previous() }}" class="text-dark text-decoration-none" aria-label="Back">
          <svg class="icon" viewBox="0 0 24 24" fill="none"><path d="M15 6l-6 6 6 6" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
        <strong>Track Order</strong>
      </div>
      <svg class="icon" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="9.5" stroke="#111" stroke-width="2"/></svg>
    </div>

    <div class="p-3">
      @php
        $orderDate = optional($order->order_date);
        $statusName = $order->orderStatus->order_status_name ?? 'On-Progress';
        $events = $order->events->sortBy('created_at');
        $payments = $order->payments ?? collect();
        // assign a progress percent for UI (can be improved with real data)
        $progressPercent = 60;
      @endphp

      {{-- Header Order ID --}}
      <div class="box mb-3 header-meta">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="small text-muted">
              Order ID: <strong>#{{ $order->order_id }}</strong>
              <button class="copy-btn ms-2" type="button" onclick="navigator.clipboard.writeText('#{{ $order->order_id }}')" aria-label="Copy Order ID">
                <img src="{{ asset('assets/copy.png') }}" alt="Copy">
              </button>
            </div>
            <div class="small text-muted">{{ $orderDate->format('d F Y, H:i') }}</div>
          </div>
          <span class="pill-status status-progress">{{ $statusName }}</span>
        </div>
      </div>

      {{-- ETA + slider + icons --}}
      <div class="box mb-3">
        <div class="small fw-semibold mb-1">Estimated time of completion:</div>
        <div class="small text-muted mb-2">{{ optional($order->eta_date)->format('d F Y') ?? '-' }}</div>

        <div class="d-flex justify-content-between align-items-center stage-labels mb-1">
          <img src="{{ asset('assets/pending.png') }}"  alt="Pending">
          <img src="{{ asset('assets/progress.png') }}" alt="On-Progress">
          <img src="{{ asset('assets/completed.png') }}" alt="Completed">
        </div>

        <div class="position-relative mb-1">
          <div class="progress-rail"></div>
          <div class="progress-fill" style="width:{{ $progressPercent }}%"></div>
          <div class="handle" style="left:{{ $progressPercent }}%"></div>
        </div>
      </div>

      {{-- Timeline --}}
      <div class="box">
        <div class="d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center gap-2">
            <img class="avatar" src="{{ asset('assets/pp.jpg') }}" alt="">
            <div class="fw-semibold">{{ $order->orderItems->first()->service->booster->user->user_name ?? 'Booster' }}</div>
          </div>
          <svg class="icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M21 15a4 4 0 0 1-4 4H8l-5 3 1-5a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4h13a4 4 0 0 1 4 4v8z" stroke="#111" stroke-width="2"/>
          </svg>
        </div>
        <hr class="my-2">

        <div class="timeline" style="--progress:.6">
          @if($events->isEmpty() && $payments->isEmpty())
            <div class="tl-item todo">
              <span class="tl-dot"></span>
              <div class="tl-content"><div class="date">{{ $orderDate->format('d F Y') }}</div><div class="desc">Order started</div></div>
            </div>
          @else
            @foreach($payments as $p)
              <div class="tl-item done">
                <span class="tl-dot"></span>
                <div class="tl-content"><div class="date">{{ optional($p->payment_date)->format('d F Y') }}</div><div class="desc">Payment received ({{ $p->payment_method->method_name ?? 'N/A' }})</div></div>
              </div>
            @endforeach
            @foreach($events as $ev)
              <div class="tl-item {{ $ev->created_at ? 'done' : 'todo' }}">
                <span class="tl-dot"></span>
                <div class="tl-content"><div class="date">{{ optional($ev->created_at)->format('d F Y') }}</div><div class="desc">{{ $ev->description }}</div></div>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </section>

  {{-- Bottom actions --}}
  <div class="action-wrap">
    <div class="action-bar px-3">
      <a href="{{ route('orders.show', $order->order_id) }}" class="btn-cta btn-red">View Order</a>
      <button class="btn-cta btn-blue" data-bs-toggle="modal" data-bs-target="#addEventModal">Add Event</button>
    </div>
  </div>

  <!-- Add Event Modal -->
  <div class="modal fade" id="addEventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-bottom">
      <div class="modal-content">
        <form method="post" action="{{ route('orders.track.event.store', $order->order_id) }}">
          @csrf
          <div class="modal-body p-3">
            <div class="mb-2 fw-semibold">Add timeline event</div>
            <div class="mb-2">
              <label class="form-label small">Type</label>
              <select name="event_type" class="form-select form-select-sm">
                <option value="note">Note</option>
                <option value="payment">Payment</option>
                <option value="status">Status</option>
              </select>
            </div>
            <div>
              <label class="form-label small">Description</label>
              <textarea name="description" class="form-control form-control-sm" rows="3" required></textarea>
            </div>
          </div>
          <div class="modal-footer p-2">
            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary btn-sm">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="home-indicator"></div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
