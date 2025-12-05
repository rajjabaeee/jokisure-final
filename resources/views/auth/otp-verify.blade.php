<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>JokiSure • Verify Code</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/login.css') }}" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
</head>
<body class="preview-center">
  <main class="device-frame" role="main" aria-label="OTP Verify">

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
          <a href="/signup" class="btn-back" style="position: absolute; left: 24px; background: none; border: none; padding: 8px;" aria-label="Back">
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
          <h1 class="h4 fw-bold mb-2">Verify Code</h1>
          <p class="text-muted mb-4 small">Check your SMS message. We've sent you the code at <span class="text-dark fw-semibold">+62 ********0000</span></p>

          @if($errors->has('otp'))
            <div class="alert alert-danger small mb-3">{{ $errors->first('otp') }}</div>
          @endif
          @if(session('otp_code'))
            <div class="alert alert-info small mb-3">Demo OTP: <strong>{{ session('otp_code') }}</strong></div>
          @endif

          <form method="POST" action="{{ route('otp.verify') }}">
            @csrf
            
            <div class="d-flex justify-content-center gap-3 mb-4">
              <input type="text" inputmode="numeric" maxlength="1" name="d1" value="{{ old('d1') }}" class="form-control text-center fw-bold" style="width: 60px; height: 60px; font-size: 24px;" aria-label="Digit 1" autocomplete="off">
              <input type="text" inputmode="numeric" maxlength="1" name="d2" value="{{ old('d2') }}" class="form-control text-center fw-bold" style="width: 60px; height: 60px; font-size: 24px;" aria-label="Digit 2" autocomplete="off">
              <input type="text" inputmode="numeric" maxlength="1" name="d3" value="{{ old('d3') }}" class="form-control text-center fw-bold" style="width: 60px; height: 60px; font-size: 24px;" aria-label="Digit 3" autocomplete="off">
              <input type="text" inputmode="numeric" maxlength="1" name="d4" value="{{ old('d4') }}" class="form-control text-center fw-bold" style="width: 60px; height: 60px; font-size: 24px;" aria-label="Digit 4" autocomplete="off">
            </div>

            <div class="text-center mb-4">
              <small class="text-muted">Send code <a href="#" class="link-red text-decoration-none">again</a></small>
            </div>

            <input type="hidden" name="otp" id="otp-value" value="{{ old('otp') }}">
            <button type="submit" class="btn btn-cta w-100 mb-3">Verify Code</button>
          </form>
        </div>
      </div>
    </section>

    <div class="home-indicator" aria-hidden="true"></div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (function(){
      const inputs = document.querySelectorAll('input[name^="d"]');
      const otpHidden = document.getElementById('otp-value');
      
      if (inputs.length > 0 && otpHidden) {
        inputs.forEach((input, idx) => {
          input.addEventListener('input', (e) => {
            // Only allow numbers
            input.value = input.value.replace(/[^0-9]/g, '');
            
            if (input.value.length === 1 && idx < inputs.length - 1) {
              inputs[idx + 1].focus();
            }
            
            // Update hidden field
            otpHidden.value = Array.from(inputs).map(i => i.value || '').join('');
          });

          input.addEventListener('keydown', (e) => {
            // Handle backspace
            if (e.key === 'Backspace' && !input.value && idx > 0) {
              inputs[idx - 1].focus();
            }
          });

          // Handle paste
          input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');
            
            pastedData.split('').forEach((char, i) => {
              if (idx + i < inputs.length) {
                inputs[idx + i].value = char;
              }
            });
            
            const nextIdx = Math.min(idx + pastedData.length, inputs.length - 1);
            inputs[nextIdx].focus();
            
            otpHidden.value = Array.from(inputs).map(i => i.value || '').join('');
          });
        });

        // Auto-focus first input
        if (inputs[0]) inputs[0].focus();
      }
    })();
  </script>
</body>
</html>
