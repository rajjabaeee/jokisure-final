{{-- resources/views/orders/boost-request.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Boost Request • JokiSure</title>

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

      <div class="title-appbar">Boost Request</div>

      <svg width="22" height="22" fill="none">
        <circle cx="11" cy="11" r="10" stroke="#000" stroke-width="2"/>
        <text x="11" y="15" text-anchor="middle" font-size="10" font-family="Inter, sans-serif" fill="#000">?</text>
      </svg>
    </div>

    <div class="divider"></div>

    {{-- FORM --}}
    <form id="boostForm" class="container px-3 pb-5" method="post" action="{{ route('boost.request.store') }}" novalidate>
      @csrf

      <h2 class="section-head mt-3">Contact</h2>

      <div class="mb-3">
        <label class="form-label required">Name</label>
        <input type="text" class="form-control input-lg" name="name" placeholder="Name / Nickname" required>
      </div>

      <div class="mb-3">
        <label class="form-label required">Contact Details</label>
        <input type="email" class="form-control input-lg" name="email" placeholder="Enter your email" required>
      </div>

      <div class="mb-3">
        <label class="form-label required">Phone Number</label>
        <input type="tel" class="form-control input-lg" name="phone" placeholder="Enter your phone number" required>
      </div>

      <h2 class="section-head mt-4">Game Details</h2>

      <div class="mb-3">
        <label class="form-label required">Username / ID</label>
        <input type="text" class="form-control input-lg" name="username" placeholder="Username / ID" required>
      </div>

      <div class="mb-1">
        <label class="form-label required">Password</label>
        <input type="text" class="form-control input-lg" name="password" placeholder="Enter your password" required>
      </div>

      <p class="helper mb-3">We will contact you for the 2FA Verification by direct messages</p>

      <div class="mb-2">
        <label class="form-label required d-block">Boost Priority</label>

        <div class="form-check rb">
          <input class="form-check-input" type="radio" name="priority" id="p1" value="vip_plus">
          <label class="form-check-label" for="p1">VIP+ (&gt;6 Hours)</label>
        </div>

        <div class="form-check rb">
          <input class="form-check-input" type="radio" name="priority" id="p2" value="vip">
          <label class="form-check-label" for="p2">VIP (&lt;6 Hours)</label>
        </div>

        <div class="form-check rb">
          <input class="form-check-input" type="radio" name="priority" id="p3" value="same_day">
          <label class="form-check-label" for="p3">Same Day (1 Day)</label>
        </div>

        <div class="form-check rb mb-2">
          <input class="form-check-input" type="radio" name="priority" id="p4" value="regular">
          <label class="form-check-label" for="p4">Regular (1–2 Day)</label>
        </div>
      </div>

      <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" id="consent">
        <label class="form-check-label agree" for="consent">
          I understand that submitting this request does not guarantee booster will accept my commission
        </label>
      </div>

      <button type="submit" id="submitBtn" class="btn submit w-100 fw-semibold" aria-disabled="true">
        Submit
      </button>

    </form>
  </section>

</main>

<script>
  const form      = document.getElementById('boostForm');
  const submitBtn = document.getElementById('submitBtn');
  const consent   = document.getElementById('consent');

  const reqNames = ['name','email','phone','username','password'];

  function isValid() {
    const filled = reqNames.every(n => (form.elements[n]?.value || '').trim().length > 0);
    const chosen = [...form.querySelectorAll('input[name="priority"]')].some(r => r.checked);
    return filled && chosen && consent.checked;
  }

  function syncBtn(){
    if (isValid()) {
      submitBtn.classList.add('enabled');
      submitBtn.setAttribute('aria-disabled','false');
    } else {
      submitBtn.classList.remove('enabled');
      submitBtn.setAttribute('aria-disabled','true');
    }
  }

  form.addEventListener('input', syncBtn);
  form.addEventListener('change', syncBtn);
  form.addEventListener('submit', (e)=>{ if (!isValid()) e.preventDefault(); });
  syncBtn();
</script>

</body>
</html>
