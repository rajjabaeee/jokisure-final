<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>JokiSure • Sign Up</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
</head>
<body class="preview-center">
  <main class="device-frame" role="main" aria-label="Sign up screen">
    <div class="status-bar d-flex align-items-center justify-content-between px-3">
      <div class="time">9:41</div>
      <div class="status-icons d-flex align-items-center gap-2">
        <svg width="20" height="12" viewBox="0 0 20 12" fill="none"><rect x="1" y="7" width="2" height="4" rx="0.75" fill="#0a0a0a"/><rect x="5" y="5" width="2" height="6" rx="0.75" fill="#0a0a0a"/><rect x="9" y="3" width="2" height="8" rx="0.75" fill="#0a0a0a"/><rect x="13" y="1" width="2" height="10" rx="0.75" fill="#0a0a0a"/></svg>
        <svg width="18" height="12" viewBox="0 0 18 12" fill="none"><path d="M9 9.5c.7 0 1.25.55 1.25 1.25S9.7 12 9 12 7.75 11.45 7.75 10.75 8.3 9.5 9 9.5z" fill="#0a0a0a"/><path d="M3 6.5c3.9-3.2 8.1-3.2 12 0" stroke="#0a0a0a" stroke-width="1.6" stroke-linecap="round"/><path d="M5.6 8c2.53-2.05 4.27-2.05 6.8 0" stroke="#0a0a0a" stroke-width="1.6" stroke-linecap="round"/></svg>
      </div>
    </div>

    <section class="safe-area d-flex flex-column">
      <header class="header container-fluid">
        <div class="row align-items-center">
          <div class="col-2">
            <a href="{{ route('login') }}" class="btn-back" aria-label="Back">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M15 6l-6 6 6 6" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
          </div>
          <div class="col-8 d-flex justify-content-center">
            <img src="{{ asset('assets/logo.png') }}" class="brand" alt="JokiSure logo">
          </div>
          <div class="col-2"></div>
        </div>
      </header>

      <div class="content-wrap">
        <div class="container">
          <h1 class="h4 fw-bold mb-3">Sign Up</h1>

          @if(session('status'))
            <div class="alert alert-success small">{{ session('status') }}</div>
          @endif

          @if(session('signup.otp_verified'))
            <div class="alert alert-success small">✓ Phone number verified — you can now complete sign up.</div>
          @endif

          @if($errors->any())
            <div class="alert alert-danger small">
              @foreach($errors->all() as $err)
                <div>{{ $err }}</div>
              @endforeach
            </div>
          @endif

          @if(session('signup.otp_verified'))
            {{-- Step 3: Final Sign Up (after OTP verified) --}}
            <form method="POST" action="{{ route('signup.perform') }}">
              @csrf
              <div class="alert alert-info small mb-3">
                Click Sign Up below to save your account and proceed to login.
              </div>
              <button type="submit" class="btn btn-cta w-100 mb-3">Sign Up</button>
            </form>
          @else
            {{-- Step 1: Fill form and Verify Phone Number --}}
            <form method="POST" action="{{ route('signup.verify.phone') }}">
              @csrf

              <label class="form-label mb-1">Full name</label>
              <input type="text" name="name" value="{{ session('signup.data.name', old('name')) }}" class="form-control mb-3" placeholder="Enter Your Full Name" required>

              <label class="form-label mb-1">Email</label>
              <input type="email" name="email" value="{{ session('signup.data.email', old('email')) }}" class="form-control mb-3" placeholder="Enter Your Email" required>

              <label class="form-label mb-1">Password</label>
              <input type="password" name="password" value="{{ session('signup.data.password', '') }}" class="form-control mb-3" placeholder="Enter Your Password" required>

              <label class="form-label mb-1">Confirm Password</label>
              <input type="password" name="password_confirmation" value="{{ session('signup.data.password', '') }}" class="form-control mb-3" placeholder="Confirm Your Password" required>

              <label class="form-label mb-1">Phone Number</label>
              <div class="input-group mb-1">
                <span class="input-group-text">+62</span>
                <input type="tel" name="phone" value="{{ session('signup.data.phone', old('phone')) }}" class="form-control" placeholder="Enter Your Phone Number">
              </div>
              
              <button type="submit" class="btn btn-outline-danger w-100 mt-2 mb-3">Verify Phone Number</button>
            </form>
          @endif
        </div>
      </div>
    </section>

    <div class="home-indicator" aria-hidden="true"></div>
  </main>
</body>
</html>
