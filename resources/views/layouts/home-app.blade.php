<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>@yield('title', 'JokiSure')</title>

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

    <!-- Home Navbar -->
    <nav class="navbar navbar-light" style="background-color: #fff; border-bottom: 1px solid #e9e9e9; padding: 12px 16px; position: relative; z-index: 100;">
      <div class="container-fluid" style="padding: 0; display: flex; align-items: center; gap: 12px;">
        <!-- Menu Toggle Button - Sebelah Kiri -->
        <button class="btn btn-light" type="button" id="menuToggleBtn" style="border: none; padding: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 6h18M3 12h18M3 18h18"/>
          </svg>
        </button>

        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('home') }}" style="margin: 0; display: flex; align-items: center; flex-shrink: 0;">
          <img src="{{ asset('assets/logo.png') }}" alt="JokiSure" height="32">
        </a>

        <!-- Search Bar -->
        <div style="flex-grow: 1; max-width: 300px;">
          <input type="text" class="form-control rounded-pill" placeholder="Search..." style="height: 36px; font-size: 14px;">
        </div>

        <!-- Cart Icon -->
        <a href="{{ route('cart.index') }}" class="position-relative" style="text-decoration: none; color: #0a0a0a; flex-shrink: 0;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 2a1 1 0 0 0 0 2h.01a1 1 0 0 0 0-2H9z"/><path d="M5 5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5z"/>
          </svg>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px; padding: 2px 6px;">1</span>
        </a>
      </div>
    </nav>

    <!-- Overlay Menu Modal -->
    <div id="navbarOverlay" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); z-index: 998; display: none;" onclick="closeNavbarMenu()"></div>

    <!-- Sidebar Menu -->
    <div id="navbarMenu" style="position: fixed; top: 0; left: -100%; width: 70%; max-width: 300px; height: 100vh; background: #fff; z-index: 999; transition: left 0.3s ease; overflow-y: auto; box-shadow: 2px 0 8px rgba(0, 0, 0, 0.15);">
      <!-- Close Button -->
      <div style="padding: 16px; border-bottom: 1px solid #e9e9e9; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: 600; font-size: 16px;">Menu</span>
        <button type="button" onclick="closeNavbarMenu()" style="border: none; background: none; padding: 0; cursor: pointer;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 6L6 18M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <!-- Menu Items -->
      <ul style="list-style: none; padding: 0; margin: 0;">
        <li>
          <a href="{{ route('home') }}" onclick="closeNavbarMenu()" style="display: block; padding: 16px; text-decoration: none; color: #0a0a0a; border-bottom: 1px solid #e9e9e9; font-size: 15px;">Home</a>
        </li>
        <li>
          <a href="{{ route('games.index') }}" onclick="closeNavbarMenu()" style="display: block; padding: 16px; text-decoration: none; color: #0a0a0a; border-bottom: 1px solid #e9e9e9; font-size: 15px;">Explore</a>
        </li>
        <li>
          <a href="{{ route('boosters') }}" onclick="closeNavbarMenu()" style="display: block; padding: 16px; text-decoration: none; color: #0a0a0a; border-bottom: 1px solid #e9e9e9; font-size: 15px;">Boosters</a>
        </li>
        <li>
          <a href="{{ route('chat.index') }}" onclick="closeNavbarMenu()" style="display: block; padding: 16px; text-decoration: none; color: #0a0a0a; border-bottom: 1px solid #e9e9e9; font-size: 15px;">Messages</a>
        </li>
        <li>
          <a href="{{ route('cart.index') }}" onclick="closeNavbarMenu()" style="display: block; padding: 16px; text-decoration: none; color: #0a0a0a; border-bottom: 1px solid #e9e9e9; font-size: 15px;">Cart</a>
        </li>
        <li>
          <a href="{{ route('profile.show') }}" onclick="closeNavbarMenu()" style="display: block; padding: 16px; text-decoration: none; color: #0a0a0a; font-size: 15px;">Profile</a>
        </li>
      </ul>
    </div>

    <script>
      const menuToggleBtn = document.getElementById('menuToggleBtn');
      const navbarMenu = document.getElementById('navbarMenu');
      const navbarOverlay = document.getElementById('navbarOverlay');

      menuToggleBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        navbarMenu.style.left = '0';
        navbarOverlay.style.display = 'block';
      });

      function closeNavbarMenu() {
        navbarMenu.style.left = '-100%';
        navbarOverlay.style.display = 'none';
      }

      // Close menu when pressing Escape key
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          closeNavbarMenu();
        }
      });
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
      <svg viewBox="0 0 24 24"><path d="M6 7h12l-1 11a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2L6 7Z" fill="none" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 7V5a3 3 0 0 1 6 0v2" fill="none"/></svg>
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
