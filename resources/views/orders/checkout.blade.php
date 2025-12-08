{{-- resources/views/orders/checkout.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Checkout • JokiSure</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/boost-request.css') }}" rel="stylesheet">
</head>
<body class="preview-center">

<main class="device-frame">

  {{-- SAFE AREA --}}
  <section class="safe-area">

    {{-- TOP BAR --}}
    <div class="appbar d-flex align-items-center justify-content-between px-3">
      <a href="{{ route('cart.index') }}" class="text-dark text-decoration-none">
        <svg width="22" height="22" fill="none">
          <path d="M14 5l-6 6 6 6" stroke="#000" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>

      <div class="title-appbar">Checkout</div>

      <svg width="22" height="22" fill="none">
        <circle cx="11" cy="11" r="10" stroke="#000" stroke-width="2"/>
        <text x="11" y="15" text-anchor="middle" font-size="10" font-family="Inter, sans-serif" fill="#000">?</text>
      </svg>
    </div>

    <div class="divider"></div>

    {{-- FORM --}}
    <form id="checkoutForm" class="container px-3 pb-5" method="post" action="{{ route('checkout.store') }}" novalidate>
      @csrf

      {{-- ORDER SUMMARY --}}
      <h2 class="section-head mt-3">Order Summary</h2>
      <div style="background: #fff; border: 1px solid #e9e9e9; border-radius: 12px; padding: 12px; margin-bottom: 20px;">
        @foreach($cartItems as $item)
          <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
            <div>
              <div style="font-size: 13px; font-weight: 600;">{{ $item->service->game->game_name ?? 'Service' }}</div>
              <div style="font-size: 11px; color: #666; margin-top: 2px;">{{ $item->service->service_desc ?? 'Standard' }}</div>
            </div>
            <div style="text-align: right;">
              <div style="font-size: 13px; font-weight: 700;">Rp {{ number_format($item->service->service_price, 0, ',', '.') }}</div>
            </div>
          </div>
        @endforeach

        <div style="padding: 12px 0; border-top: 1px solid #e9e9e9; margin-top: 8px;">
          <div style="display: flex; justify-content: space-between; align-items: center; font-weight: 700; font-size: 14px;">
            <span>Total:</span>
            <span style="color: #ff3b6d;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
          </div>
        </div>
      </div>

      {{-- GAME CREDENTIALS --}}
      <h2 class="section-head mt-4">Game Details</h2>

      <div class="mb-3">
        <label class="form-label required">Game Username / ID</label>
        <input type="text" class="form-control input-lg" name="game_username" placeholder="Your game username or ID" required>
        @error('game_username')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label required">Game Password</label>
        <input type="password" class="form-control input-lg" name="game_password" placeholder="Your game password" required>
        @error('game_password')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <p class="helper mb-3">We will contact you for the 2FA verification via direct messages</p>

      {{-- BOOST PRIORITY --}}
      <h2 class="section-head mt-4">Boost Priority</h2>

      <div class="form-check rb">
        <input class="form-check-input" type="radio" name="boost_priority_id" id="priority_vip_plus" value="aaaaaaaa-bbbb-cccc-dddd-000000000001" required>
        <label class="form-check-label" for="priority_vip_plus">VIP+ (&gt;6 Hours)</label>
      </div>

      <div class="form-check rb">
        <input class="form-check-input" type="radio" name="boost_priority_id" id="priority_vip" value="aaaaaaaa-bbbb-cccc-dddd-000000000002">
        <label class="form-check-label" for="priority_vip">VIP (&lt;6 Hours)</label>
      </div>

      <div class="form-check rb">
        <input class="form-check-input" type="radio" name="boost_priority_id" id="priority_same_day" value="aaaaaaaa-bbbb-cccc-dddd-000000000003">
        <label class="form-check-label" for="priority_same_day">Same Day (1 Day)</label>
      </div>

      <div class="form-check rb mb-4">
        <input class="form-check-input" type="radio" name="boost_priority_id" id="priority_regular" value="aaaaaaaa-bbbb-cccc-dddd-000000000004">
        <label class="form-check-label" for="priority_regular">Regular (1–2 Days)</label>
      </div>

      {{-- CONSENT --}}
      <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" id="consent" name="consent" required>
        <label class="form-check-label agree" for="consent">
          I confirm that the game credentials provided are correct and I understand the order cannot be modified once submitted
        </label>
      </div>

      {{-- SUBMIT BUTTON --}}
      <button type="submit" class="btn btn-lg w-100 fw-semibold" style="background: #ff3b6d; color: #fff; border: none; border-radius: 20px; padding: 12px; font-size: 14px;">
        Proceed to Payment
      </button>

      {{-- Hidden field for selected services --}}
      <input type="hidden" name="selected_services" value="{{ $selectedServicesJson ?? '[]' }}">
    </form>
  </section>

  <div class="home-indicator"></div>
</main>

<script>
  document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const consent = document.getElementById('consent');
    if (!consent.checked) {
      e.preventDefault();
      alert('Please agree to the terms before proceeding');
    }
  });
</script>

</body>
</html>
