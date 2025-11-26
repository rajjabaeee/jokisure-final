<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>JokiSure • Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/login.css') }}" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
</head>
<body class="preview-center">
  <main class="device-frame" role="main" aria-label="Login screen">

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
          <img src="./assets/logo.png" class="brand mx-auto" alt="JokiSure logo">
        </div>
        <!-- transisi ke blok putih -->
        <div class="header-bottom"></div>
      </header>

      <!-- BLOK FORM PUTIH -->
      <div class="content-wrap">
        <div class="container">
          <h1 class="h4 fw-bold mb-3">Login</h1>

          <label class="form-label mb-1">Email or username</label>
          <input type="text" class="form-control mb-3" placeholder="Enter Your Email or Username">

          <div class="d-flex align-items-center justify-content-between">
            <label class="form-label mb-1">Password</label>
            <a href="{{ route('reset') }}" class="link-red small text-decoration-none">Forgot your password?</a>
          </div>
          <input type="password" class="form-control mb-3" placeholder="Enter Your Password">

          <button class="btn btn-cta w-100 mb-3">Log In</button>

          <div class="divider my-3"><span class="text-muted small">Or login with</span></div>

          <button class="btn btn-social w-100 mb-2">
            <svg width="20" height="20" viewBox="0 0 48 48" aria-hidden="true">
              <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.9 32.6 29.4 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3 0 5.7 1.1 7.8 2.9l5.7-5.7C33.6 6.4 29 4.5 24 4.5 13 4.5 4.5 13 4.5 24S13 43.5 24 43.5 43.5 35 43.5 24c0-1.1-.1-2.1-.3-3.1z"/>
              <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.5 16.2 18.9 13.5 24 13.5c3 0 5.7 1.1 7.8 2.9l5.7-5.7C33.6 6.4 29 4.5 24 4.5 16.2 4.5 9.4 8.8 6.3 14.7z"/>
              <path fill="#4CAF50" d="M24 43.5c5.3 0 10.1-2 13.7-5.2l-6.3-5.2C29.4 36 26.8 37.5 24 37.5c-5.3 0-9.8-3.4-11.4-8.1l-6.5 5.1C9.1 39.3 16.2 43.5 24 43.5z"/>
              <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-1.2 3.5-4.6 6-8.3 6-5.3 0-9.8-3.4-11.4-8.1l-6.5 5.1C9.1 39.3 16.2 43.5 24 43.5 33.5 43.5 41.5 36 41.5 24c0-1.1-.1-2.1-.3-3.1z"/>
            </svg>
            <span>Continue with Google</span>
          </button>

          <button class="btn btn-social w-100">
            <svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true">
              <path fill="#000" d="M16.365 1.43c0 1.14-.45 2.243-1.184 3.053-.76.84-2.02 1.487-3.128 1.405-.14-1.11.44-2.29 1.172-3.1.78-.85 2.11-1.46 3.14-1.358zM20.89 17.3c-.59 1.36-.88 1.98-1.65 3.2-1.07 1.68-2.58 3.78-4.45 3.79-1.67.02-2.11-1.1-4.41-1.09-2.3.01-2.78 1.11-4.46 1.09-1.87-.02-3.31-1.92-4.38-3.6-3-4.72-3.32-10.25-1.47-13.18 1.31-2.09 3.38-3.41 5.73-3.43 1.79-.03 3.48 1.2 4.41 1.2.92 0 2.54-1.47 4.29-1.25.73.03 2.78.29 4.1 2.18-0.11.07-2.44 1.42-2.41 4.22.03 3.36 2.98 4.47 3.01 4.49-.03.07-.48 1.7-1.36 3.09z"/>
            </svg>
            <span>Continue with Apple</span>
          </button>

          <p class="text-center mt-3 small text-muted mb-0">
            Don't have an account? <a href="{{ route('signup') }}" class="link-red text-decoration-none">Sign Up</a>
          </p>
        </div>
      </div>
    </section>

    <div class="home-indicator" aria-hidden="true"></div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
