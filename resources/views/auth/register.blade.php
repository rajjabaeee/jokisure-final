<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>JokiSure • Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/login.css') }}" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
</head>
<body class="preview-center">
  <main class="device-frame" role="main" aria-label="Sign Up screen">

    <!-- Status bar -->
    <div class="status-bar d-flex align-items-center justify-content-between px-3">
      <div class="time">9:41</div>
      <div class="status-icons d-flex align-items-center gap-2">
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

    <!-- SAFE AREA -->
    <section class="safe-area d-flex flex-column">

      <!-- HEADER ABU-ABU (belakang logo) -->
      <header class="header">
        <div class="container d-flex align-items-center" style="min-height:90px;">
          <a href="/login" class="btn-back" style="position: absolute; left: 24px; background: none; border: none; padding: 8px;" aria-label="Back">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M15 6l-6 6 6 6" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
          <img src="./assets/logo.png" class="brand mx-auto" alt="JokiSure logo">
        </div>
        <!-- transisi ke blok putih -->
        <div class="header-bottom"></div>
      </header>

      <!-- BLOK FORM PUTIH -->
      <div class="content-wrap">
        <div class="container">
          <h1 class="h4 fw-bold mb-3">Sign Up</h1>

          @if($errors->any())
            <div class="alert alert-danger small mb-3">
              @foreach($errors->all() as $err)
                {{ $err }}
              @endforeach
            </div>
          @endif

          {{-- Always show the same form, but enable/disable Sign Up button based on verification --}}
          <form method="POST" action="{{ session('signup.phone_verified') ? route('signup.perform') : route('signup.verify.phone') }}">
            @csrf
            
            <label class="form-label mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') ?: session('signup.data.email') }}" class="form-control mb-3" placeholder="Enter Your Email" required {{ session('signup.phone_verified') ? 'readonly style=background:#f8f9fa;' : '' }}>

            <label class="form-label mb-1">Password</label>
            <input type="password" name="password" value="{{ session('signup.phone_verified') ? session('signup.data.password') : '' }}" class="form-control mb-3" placeholder="Enter Your Password" required {{ session('signup.phone_verified') ? 'readonly style=background:#f8f9fa;' : '' }}>

            <label class="form-label mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" value="{{ session('signup.phone_verified') ? session('signup.data.password') : '' }}" class="form-control mb-3" placeholder="Confirm Your Password" required {{ session('signup.phone_verified') ? 'readonly style=background:#f8f9fa;' : '' }}>

            <label class="form-label mb-1">Phone Number</label>
            <div class="input-group mb-2">
              <span class="input-group-text">+62</span>
              <input type="tel" name="phone" value="{{ old('phone') ?: session('signup.data.phone') }}" class="form-control" placeholder="Enter Your Phone Number" required {{ session('signup.phone_verified') ? 'readonly style=background:#f8f9fa;' : '' }}>
            </div>
            
            @if(!session('signup.phone_verified'))
              <div class="text-end mb-3">
                <button type="submit" class="btn btn-link p-0 link-red text-decoration-none small">Verify Phone Number</button>
              </div>
              <button type="button" class="btn btn-cta w-100 mb-3" disabled style="background: #ffb3c1; cursor: not-allowed;">Sign Up</button>
            @else
              <button type="submit" class="btn btn-cta w-100 mb-3">Sign Up</button>
            @endif
          </form>

          <div class="terms text-center mt-3">
            <small class="text-muted">
              By joining, you agree to the <a href="#" class="link-red text-decoration-none">Terms & Conditions</a> and <a href="#" class="link-red text-decoration-none">Privacy Policy</a>
            </small>
          </div>
        </div>
      </div>
    </section>

    <div class="home-indicator" aria-hidden="true"></div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
