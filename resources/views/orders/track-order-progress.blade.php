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
      {{-- Header Order ID --}}
      <div class="box mb-3 header-meta">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="small text-muted">
              Order ID: <strong>#12346</strong>
              <button class="copy-btn ms-2" type="button"
                      onclick="navigator.clipboard.writeText('#12346')" aria-label="Copy Order ID">
                <img src="{{ asset('assets/Images/copy.png') }}" alt="Copy">
              </button>
            </div>
            <div class="small text-muted">10 June 2025, 9:41 WIB</div>
          </div>
          <span class="pill-status status-progress">On-Progress</span>
        </div>
      </div>

      {{-- ETA + slider + icons --}}
      <div class="box mb-3">
        <div class="small fw-semibold mb-1">Estimated time of completion:</div>
        <div class="small text-muted mb-2">22 June 2025</div>

        <div class="d-flex justify-content-between align-items-center stage-labels mb-1">
          <img src="{{ asset('assets/Images/pending.png') }}"  alt="Pending">
          <img src="{{ asset('assets/Images/progress.png') }}" alt="On-Progress">
          <img src="{{ asset('assets/Images/completed.png') }}" alt="Completed">
        </div>

        <div class="position-relative mb-1">
          <div class="progress-rail"></div>
          <div class="progress-fill" style="width:50%"></div>
          <div class="handle" style="left:50%"></div>
        </div>
      </div>

      {{-- Timeline --}}
      <div class="box">
        <div class="d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center gap-2">
            <img class="avatar" src="{{ asset('assets/Images/pp.jpg') }}" alt="">
            <div class="fw-semibold">BangBoost</div>
          </div>
          <svg class="icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M21 15a4 4 0 0 1-4 4H8l-5 3 1-5a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4h13a4 4 0 0 1 4 4v8z" stroke="#111" stroke-width="2"/>
          </svg>
        </div>
        <hr class="my-2">

        <div class="timeline" style="--progress:.6">
          <div class="tl-item done">
            <span class="tl-dot"></span>
            <div class="tl-content"><div class="date">22 April 2025</div><div class="desc">Account logged out</div></div>
          </div>
          <div class="tl-item done">
            <span class="tl-dot"></span>
            <div class="tl-content"><div class="date">22 April 2025</div><div class="desc">Abyss level 12 cleared</div></div>
          </div>
          <div class="tl-item todo">
            <span class="tl-dot"></span>
            <div class="tl-content"><div class="date">21 April 2025</div><div class="desc">Abyss level 9, 10, 11 cleared</div></div>
          </div>
          <div class="tl-item todo">
            <span class="tl-dot"></span>
            <div class="tl-content"><div class="date">21 April 2025</div><div class="desc">Account logged in by booster</div></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Bottom actions --}}
  <div class="action-wrap">
    <div class="action-bar px-3">
      <button class="btn-cta btn-red">Track Order</button>
      <button class="btn-cta btn-blue">Complete Order</button>
    </div>
  </div>

  <div class="home-indicator"></div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
