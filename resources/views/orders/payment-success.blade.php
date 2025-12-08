{{-- resources/views/orders/payment-success.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>JokiSure • Payment Successful</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/payment-success.css') }}" rel="stylesheet">
</head>
<body class="preview-center">
<main class="device-frame" role="main" aria-label="Payment Successful">

  <div class="status-bar d-flex align-items-center justify-content-between px-3">
    <div class="time">9:41</div>
    <div class="status-icons d-flex align-items-center gap-2">
      {{-- icons --}}
      <svg width="20" height="12" viewBox="0 0 20 12" fill="none" aria-hidden="true"><rect x="1" y="7" width="2" height="4" rx=".75" fill="#0a0a0a"/><rect x="5" y="5" width="2" height="6" rx=".75" fill="#0a0a0a"/><rect x="9" y="3" width="2" height="8" rx=".75" fill="#0a0a0a"/><rect x="13" y="1" width="2" height="10" rx=".75" fill="#0a0a0a"/></svg>
      <svg width="18" height="12" viewBox="0 0 18 12" fill="none" aria-hidden="true"><path d="M9 9.5c.7 0 1.25.55 1.25 1.25S9.7 12 9 12 7.75 11.45 7.75 10.75 8.3 9.5 9 9.5Z" fill="#0a0a0a"/><path d="M3 6.5c3.9-3.2 8.1-3.2 12 0" stroke="#0a0a0a" stroke-width="1.6" stroke-linecap="round"/><path d="M5.6 8c2.53-2.05 4.27-2.05 6.8 0" stroke="#0a0a0a" stroke-width="1.6" stroke-linecap="round"/></svg>
      <svg width="26" height="12" viewBox="0 0 26 12" fill="none" aria-hidden="true"><rect x="1" y="1" width="20" height="10" rx="2" stroke="#0a0a0a" stroke-width="1.5"/><rect x="3" y="3" width="16" height="6" rx="1.5" fill="#0a0a0a"/><rect x="22" y="4" width="3" height="4" rx="1" fill="#0a0a0a"/></svg>
    </div>
  </div>

  <section class="safe-area d-flex flex-column">
    <div class="appbar d-flex align-items-center justify-content-between px-3">
      <a href="{{ route('home') }}" class="icon-btn">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
          <path d="M15 6l-6 6 6 6" stroke="#0a0a0a" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
      <div class="fw-semibold">Payment</div>
      <a href="#" class="icon-btn">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
          <circle cx="12" cy="12" r="10" stroke="#0a0a0a" stroke-width="2"/>
          <path d="M12 17v-5" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round"/>
          <circle cx="12" cy="8" r="1.2" fill="#0a0a0a"/>
        </svg>
      </a>
    </div>
    <div class="appbar-divider"></div>

    <div class="container px-3 py-4 d-flex flex-column align-items-center text-center">
      <div class="success-icon mb-4" aria-hidden="true">
        <svg width="156" height="156" viewBox="0 0 156 156" fill="none">
          <circle cx="78" cy="78" r="72" fill="#2D9E41"/>
          <circle cx="78" cy="78" r="56" fill="#fff"/>
          <circle cx="78" cy="78" r="44" fill="#2D9E41"/>
          <path d="M58 80l13 13 27-27" stroke="#fff" stroke-width="10" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>

      <h2 class="fw-bold mb-2">Payment<br>Successful!</h2>
      <div class="fw-bold mb-2">ID : {{ $paymentResult['order_id'] ?? '0000' }}</div>

      <p class="small text-muted mb-4" style="max-width:290px">
        Thank you for your order! You will receive a confirmation
        shortly. You can view your order details or return to the
        homepage.
      </p>

      <div class="d-flex gap-3 w-100 justify-content-center">
        <a href="{{ route('home') }}" class="btn btn-back w-50">Back to Homepage</a>
        <a href="{{ route('orders.index') }}" class="btn btn-cta w-50">View Order</a>
      </div>
    </div>
  </section>

  <div class="home-indicator" aria-hidden="true"></div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
