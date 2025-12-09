<!-- 5026231003 | Kanayya Shafa Amelia (kanayya shafa) -->

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
        <div class="container px-4">
          <h1 class="h4 fw-bold mb-4">Sign Up</h1>

          @if($errors->any())
            <div class="alert alert-danger small">
              @foreach($errors->all() as $err)
                <div>{{ $err }}</div>
              @endforeach
            </div>
          @endif

          <!-- Main Form -->
          <form method="POST" action="{{ route('signup.verify.phone') }}" id="signupForm">
            @csrf
            
            <!-- Username Field -->
            <div class="mb-3">
              <label class="form-label fw-medium text-dark" style="font-size: 14px;">Username</label>
              <input 
                type="text" 
                name="username" 
                value="{{ session('signup.data.username', old('username')) }}" 
                class="form-control" 
                placeholder="Enter Your Username" 
                style="padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;"
                required>
            </div>
            
            <!-- Email Field -->
            <div class="mb-3">
              <label class="form-label fw-medium text-dark" style="font-size: 14px;">Email</label>
              <input 
                type="email" 
                name="email" 
                value="{{ session('signup.data.email', old('email')) }}" 
                class="form-control" 
                placeholder="Enter Your Email" 
                style="padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;"
                required>
            </div>

            <!-- Password Field -->
            <div class="mb-3">
              <label class="form-label fw-medium text-dark" style="font-size: 14px;">Password</label>
              <input 
                type="password" 
                name="password" 
                class="form-control" 
                placeholder="Enter Your Password" 
                style="padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;"
                required>
            </div>

            <!-- Confirm Password Field -->
            <div class="mb-3">
              <label class="form-label fw-medium text-dark" style="font-size: 14px;">Confirm Password</label>
              <input 
                type="password" 
                name="password_confirmation" 
                class="form-control" 
                placeholder="Confirm Your Password" 
                style="padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;"
                required>
            </div>

            <!-- Phone Number Field -->
            <div class="mb-3">
              <label class="form-label fw-medium text-dark" style="font-size: 14px;">Phone Number</label>
              <div class="input-group">
                <span class="input-group-text" style="border: 1px solid #ddd; background: white; font-size: 14px;">+62</span>
                <input 
                  type="tel" 
                  name="phone" 
                  value="{{ session('signup.data.phone', old('phone')) }}" 
                  class="form-control" 
                  placeholder="Enter Your Phone Number" 
                  style="border: 1px solid #ddd; font-size: 14px; padding: 12px;"
                  required>
              </div>
            </div>

            <!-- Verify Phone Number Link -->
            <div class="text-end mb-4">
              <a 
                href="javascript:void(0)" 
                onclick="document.getElementById('signupForm').submit()" 
                style="color: #ff2d55; font-size: 14px; text-decoration: none; font-weight: 500;">
                Verify Phone Number
              </a>
            </div>

          </form>

          <!-- Sign Up Form -->
          <form method="POST" action="{{ route('signup.perform') }}" id="finalSignupForm">
            @csrf
            
            <!-- Sign Up Button -->
            @if(session('signup.otp_verified'))
              <button type="submit" class="btn w-100 mb-4" style="background-color: #ff2d55; color: white; padding: 14px; font-weight: 600; border-radius: 8px; border: none; font-size: 16px;">
                Sign Up
              </button>
            @else
              <button type="button" class="btn w-100 mb-4" disabled style="background-color: #e0e0e0; color: #9e9e9e; padding: 14px; font-weight: 600; border-radius: 8px; border: none; font-size: 16px; cursor: not-allowed;">
                Sign Up
              </button>
            @endif
          </form>
          
          <!-- Terms -->
          <p class="small text-muted text-center" style="font-size: 12px;">
            By joining, you agree to the 
            <a href="#" class="text-decoration-none" style="color: #ff2d55;">Terms & Conditions</a> 
            and 
            <a href="#" class="text-decoration-none" style="color: #ff2d55;">Privacy Policy</a>
          </p>
        </div>
      </div>
    </section>

    <div class="home-indicator" aria-hidden="true"></div>
  </main>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
