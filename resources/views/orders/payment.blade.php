{{-- resources/views/orders/payment.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>JokiSure • Payment</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/service-detail.css') }}" rel="stylesheet">
</head>
<body class="preview-center">
<main class="device-frame" role="main" aria-label="Service Detail Payment">

  {{-- STATUS BAR --}}
  <div class="status-bar d-flex align-items-center justify-content-between px-3">
    <div class="time">9:41</div>
    <div class="status-icons d-flex align-items-center gap-2">
      {{-- (icons same as original) --}}
      <svg width="20" height="12" viewBox="0 0 20 12" fill="none" aria-hidden="true">
        <rect x="1" y="7" width="2" height="4" rx=".75" fill="#0a0a0a"/><rect x="5" y="5" width="2" height="6" rx=".75" fill="#0a0a0a"/>
        <rect x="9" y="3" width="2" height="8" rx=".75" fill="#0a0a0a"/><rect x="13" y="1" width="2" height="10" rx=".75" fill="#0a0a0a"/>
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

  {{-- SAFE AREA --}}
  <section class="safe-area d-flex flex-column">
    {{-- APP BAR --}}
    <div class="appbar d-flex align-items-center justify-content-between px-3">
      <a href="{{ route('boost.request') }}" class="icon-btn">
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

    {{-- CONTENT --}}
    <div class="content container px-3">
      <h1 class="display-6 title">Your Order</h1>

      <div class="order-card p-3 rounded-3 mb-3">
        <div class="small fw-bold mb-1">Pack 1</div>
        <div class="row">
          <div class="col">
            <div class="small text-muted">
              Genshin Impact | Abyss<br>
              Variant: Floor 9, Floor 10,<br>
              Floor 12
            </div>
          </div>
          <div class="col-auto align-self-start fw-semibold">Rp 60.000</div>
        </div>
      </div>

      <a href="#" class="voucher-row mb-3 d-flex align-items-center justify-content-between rounded-2 px-3 py-3 text-decoration-none">
        <span class="fw-semibold">Voucher</span>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
          <path d="M9 18l6-6-6-6" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>

      <div class="mb-2 fw-semibold">Payment Method</div>
      <form method="post" action="{{ route('payment.success') }}">
        @csrf
        <select name="method" class="form-select form-select-dark mb-3" aria-label="Select your payment" required>
          <option selected disabled value="">Select your payment</option>
          <option value="gopay">Gopay</option>
          <option value="ovo">OVO</option>
          <option value="dana">DANA</option>
          <option value="shopee">ShopeePay</option>
          <option value="card">VISA/Mastercard</option>
        </select>

        <hr class="my-3">

        <div class="price-row">
          <span>Pack Price</span><span class="fw-semibold">Rp 60.000</span>
        </div>
        <div class="price-row">
          <span>Discount</span><span class="text-danger">-Rp 10.000</span>
        </div>
        <div class="price-row mb-2">
          <span>Tax & Services</span><span>Rp 5.000</span>
        </div>

        <div class="d-flex align-items-center justify-content-between mt-1">
          <div class="fw-bold">Total Price</div>
          <span class="total-chip">Rp 55.000</span>
        </div>

        <hr class="my-3">

        <button class="btn btn-cta w-100 mt-1" type="submit">Pay</button>
      </form>
    </div>
  </section>

  <div class="home-indicator" aria-hidden="true"></div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
