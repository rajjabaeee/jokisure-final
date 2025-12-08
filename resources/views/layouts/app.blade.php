<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>@yield('title', 'JokiSure')</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Page CSS -->
  <link href="{{ asset('css/my-profile.css') }}" rel="stylesheet">
</head>

<body class="preview-center">
<main class="device-frame">

  <!-- STATUS BAR -->
  <div class="status-bar d-flex align-items-center justify-content-between px-3">
    <div class="time">9:41</div>
    <div class="status-icons d-flex align-items-center gap-2">
      <svg width="20" height="12" viewBox="0 0 20 12" fill="none"><rect x="1" y="7" width="2" height="4" rx=".75" fill="#0a0a0a"/><rect x="5" y="5" width="2" height="6" rx=".75" fill="#0a0a0a"/><rect x="9" y="3" width="2" height="8" rx=".75" fill="#0a0a0a"/><rect x="13" y="1" width="2" height="10" rx=".75" fill="#0a0a0a"/></svg>
      <svg width="18" height="12" viewBox="0 0 18 12" fill="none"><path d="M9 9.5c.7 0 1.25.55 1.25 1.25S9.7 12 9 12 7.75 11.45 7.75 10.75 8.3 9.5 9 9.5Z" fill="#0a0a0a"/><path d="M3 6.5c3.9-3.2 8.1-3.2 12 0" stroke="#0a0a0a" stroke-width="1.6" stroke-linecap="round"/><path d="M5.6 8c2.53-2.05 4.27-2.05 6.8 0" stroke="#0a0a0a" stroke-width="1.6" stroke-linecap="round"/></svg>
      <svg width="26" height="12" viewBox="0 0 26 12" fill="none"><rect x="1" y="1" width="20" height="10" rx="2" stroke="#0a0a0a" stroke-width="1.5"/><rect x="3" y="3" width="16" height="6" rx="1.5" fill="#0a0a0a"/><rect x="22" y="4" width="3" height="4" rx="1" fill="#0a0a0a"/></svg>
    </div>
  </div>

  <!-- SAFE AREA -->
  <section class="safe-area">

    <!-- APP BAR -->
    <div class="appbar d-flex align-items-center justify-content-between px-3">
      <a href="{{ route('home') }}" class="icon-btn" aria-label="Back">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M6 12h12M10 8l-4 4 4 4" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
      <div class="fw-semibold">@yield('title', 'JokiSure')</div>
      <button type="button" class="icon-btn" aria-label="Help" onclick="openHelpOverlay()" style="border: none; background: none; padding: 0; cursor: pointer;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
        </svg>
      </button>
    </div>

    <!-- Help Overlay -->
    <div id="helpOverlay" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); z-index: 1000; display: none; align-items: center; justify-content: center;" onclick="closeHelpOverlay(event)">
      <div style="background: #fff; width: 90%; max-width: 500px; border-radius: 16px; padding: 20px; max-height: 70vh; overflow-y: auto;" onclick="event.stopPropagation()">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
          <h5 style="margin: 0; font-weight: 600;">About</h5>
          <button type="button" onclick="closeHelpOverlay()" style="border: none; background: none; padding: 0; cursor: pointer; font-size: 20px;">×</button>
        </div>
        @yield('help-content')
      </div>
    </div>

    <script>
      function openHelpOverlay() {
        document.getElementById('helpOverlay').style.display = 'flex';
      }
      
      function closeHelpOverlay(event) {
        if (!event || event.target.id === 'helpOverlay') {
          document.getElementById('helpOverlay').style.display = 'none';
        }
      }
    </script>

    <!-- BODY -->
    <div class="container px-3 pb-5">
      @yield('content')
    </div>

  </section>

  <!-- TAB BAR -->
  <nav class="tabbar">
    <a class="tab{{ Route::currentRouteName() === 'home' ? ' active' : '' }}" href="{{ route('home') }}">
      <svg viewBox="0 0 24 24"><path d="M3 10l9-7 9 7v8a2 2 0 0 1-2 2h-3v-5H8v5H5a2 2 0 0 1-2-2v-8Z"/></svg>
      <span>Home</span>
    </a>
    <a class="tab{{ Route::currentRouteName() === 'cart.index' ? ' active' : '' }}" href="{{ route('cart.index') }}">
      <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1" fill="none"/><circle cx="20" cy="21" r="1" fill="none"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" fill="none"/></svg>
      <span>Cart</span>
    </a>
    <a class="tab{{ Route::currentRouteName() === 'chat.index' ? ' active' : '' }}" href="{{ route('chat.index') }}">
      <svg viewBox="0 0 24 24"><path d="M21 12a8.5 8.5 0 1 1-17 0 8.5 8.5 0 0 1 17 0Zm-8.5-5v5l3 2" fill="none"/></svg>
      <span>Message</span>
    </a>
    <a class="tab{{ Route::currentRouteName() === 'notification' ? ' active' : '' }}" href="#notification">
      <svg viewBox="0 0 24 24"><path d="M6 9a6 6 0 0 1 12 0v5l1.5 1.5a1 1 0 0 1-.7 1.7H5.2a1 1 0 0 1-.7-1.7L6 14V9Z" fill="none"/><path d="M10 19a2 2 0 1 0 4 0" fill="none"/></svg>
      <span>Notification</span>
    </a>
    <a class="tab{{ Route::currentRouteName() === 'profile.show' ? ' active' : '' }}" href="{{ route('profile.show') }}">
      <svg viewBox="0 0 24 24" class="profile-icon">
        <circle cx="12" cy="12" r="9" fill="none"/>
        <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-6 7a6 6 0 0 1 12 0" fill="none"/>
      </svg>
      <span>Profile</span>
    </a>
  </nav>

  <div class="home-indicator"></div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
