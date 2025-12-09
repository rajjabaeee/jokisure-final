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

    <!-- Home Navbar -->
    <nav class="navbar navbar-light" style="background-color: #fff; border-bottom: 1px solid #e9e9e9; padding: 12px 16px; position: relative; z-index: 100;">
      <div class="container-fluid" style="padding: 0; display: flex; align-items: center; gap: 12px;">
        <!-- Menu Toggle Button - Sebelah Kiri -->
        <button class="btn btn-light" type="button" id="menuToggleBtn" style="border: none; padding: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 6h18M3 12h18M3 18h18"/>
          </svg>
        </button>

        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('home') }}" style="margin: 0; display: flex; align-items: center; flex-shrink: 0;">
          <img src="{{ asset('assets/logo.png') }}" alt="JokiSure" height="30">
        </a>

        <!-- Search Bar -->
        <div style="flex-grow: 1; max-width: 200px; position: relative;">
          <input type="text" id="homeSearch" class="form-control rounded-pill" placeholder="Search..." style="height: 30px; font-size: 12px;" oninput="filterHomeContent()">
          <div id="searchDropdown" style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #e9e9e9; border-top: none; border-radius: 0 0 12px 12px; max-height: 300px; overflow-y: auto; display: none; z-index: 1000; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div id="searchResults" style="padding: 8px 0;"></div>
          </div>
        </div>

        <!-- Cart Icon -->
        <a href="{{ route('cart.index') }}" class="position-relative" style="text-decoration: none; color: #0a0a0a; flex-shrink: 0; margin-left: auto;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
          </svg>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px; padding: 2px 6px;">1</span>
        </a>
      </div>
    </nav>

    <!-- Overlay Menu Modal -->
    <div id="navbarOverlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); z-index: 999; display: none;" onclick="closeNavbarMenu()"></div>

    <style>
      /* Reset and fix mobile layout structure */
      .device-frame {
        overflow: hidden !important;
        position: relative !important;
      }
      
      .safe-area {
        position: absolute !important;
        top: var(--status) !important;
        bottom: 84px !important;
        left: 0 !important;
        right: 0 !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        background: #f2f2f2 !important;
      }
      
      /* Navbar fixed at bottom */
      .tabbar {
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        z-index: 100 !important;
      }
      
      /* Home indicator */
      .home-indicator {
        position: absolute !important;
        bottom: -20px !important;
        z-index: 101 !important;
      }
      
      /* Sidebar fixed within mobile frame */
      #navbarMenu {
        position: absolute !important;
        z-index: 1000 !important;
      }
      
      #navbarOverlay {
        position: absolute !important;
        z-index: 999 !important;
      }
      
      /* Content area scrollable */
      .container {
        padding-bottom: 20px !important;
      }
    </style>

    <!-- Sidebar Menu -->
    <div id="navbarMenu" style="position: absolute; top: 0; left: -100%; width: 260px; height: 100%; background: #fff; z-index: 1000; transition: left 0.3s ease; overflow-y: auto; border-top-right-radius: 20px; border-bottom-right-radius: 20px; box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);">
      
      <!-- Close Button -->
      <div style="padding: 40px 16px 16px 16px; display: flex; justify-content: flex-end;">
        <button type="button" onclick="closeNavbarMenu()" style="border: none; background: none; padding: 6px; cursor: pointer; color: #666;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 6L6 18M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <!-- User Profile Section -->
      @auth
      <div style="padding: 0 16px 20px 16px; text-align: center;">
        <img src="{{ asset('assets/tamago.jpg') }}" alt="Profile" style="width: 60px; height: 60px; border-radius: 12px; object-fit: cover; margin-bottom: 8px;">
        <div style="font-size: 16px; font-weight: 700; color: #000; margin-bottom: 2px;">{{ Auth::user()->user_name ?? 'User' }}</div>
        <div style="font-size: 13px; color: #666; margin-bottom: 16px;">{{ Auth::user()->user_email ?? 'user@example.com' }}</div>
        <button onclick="handleLogout()" style="background: #ff6b6b; color: white; border: none; padding: 8px 24px; border-radius: 20px; font-size: 14px; font-weight: 600; cursor: pointer;">
          Log Out
        </button>
      </div>
      @endauth

      <!-- Main Menu Items -->
      <div style="padding: 0 16px;">
        <div onclick="window.location.href='{{ route('profile.show') }}'; closeNavbarMenu();" style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 10px; padding: 12px 16px; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s;">
          <span style="font-size: 14px; font-weight: 500; color: #000;">Account</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M7 17L17 7M17 7H7M17 7V17"/>
          </svg>
        </div>

        <div onclick="window.location.href='{{ route('boosters') }}'; closeNavbarMenu();" style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 10px; padding: 12px 16px; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s;">
          <span style="font-size: 14px; font-weight: 500; color: #000;">Boosters</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M7 17L17 7M17 7H7M17 7V17"/>
          </svg>
        </div>

        <div onclick="window.location.href='{{ route('games.index') }}'; closeNavbarMenu();" style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 10px; padding: 12px 16px; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s;">
          <span style="font-size: 14px; font-weight: 500; color: #000;">Games</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M7 17L17 7M17 7H7M17 7V17"/>
          </svg>
        </div>

        <div onclick="window.location.href='{{ route('orders') }}'; closeNavbarMenu();" style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 10px; padding: 12px 16px; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s;">
          <span style="font-size: 14px; font-weight: 500; color: #000;">My Orders</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M7 17L17 7M17 7H7M17 7V17"/>
          </svg>
        </div>

        <div onclick="window.location.href='{{ route('reviews') }}'; closeNavbarMenu();" style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 10px; padding: 12px 16px; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s;">
          <span style="font-size: 14px; font-weight: 500; color: #000;">Review</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M7 17L17 7M17 7H7M17 7V17"/>
          </svg>
        </div>

        <div onclick="window.location.href='{{ route('profile.edit') }}'; closeNavbarMenu();" style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 10px; padding: 12px 16px; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s;">
          <span style="font-size: 14px; font-weight: 500; color: #000;">Settings</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M7 17L17 7M17 7H7M17 7V17"/>
          </svg>
        </div>

        <div onclick="window.location.href='{{ route('notifications') }}'; closeNavbarMenu();" style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 10px; padding: 12px 16px; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s;">
          <span style="font-size: 14px; font-weight: 500; color: #000;">Terms of Service</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M7 17L17 7M17 7H7M17 7V17"/>
          </svg>
        </div>

        <div onclick="window.location.href='{{ route('chat.index') }}'; closeNavbarMenu();" style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s;">
          <span style="font-size: 14px; font-weight: 500; color: #000;">Contact Us</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M7 17L17 7M17 7H7M17 7V17"/>
          </svg>
        </div>
      </div>
    </div>

    <style>
      /* Hover effects for menu items */
      #navbarMenu div[onclick]:hover {
        background: #e9ecef !important;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
      }
    </style>

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

      function handleLogout() {
        if (confirm('Yakin ingin keluar?')) {
          fetch('{{ route("logout") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
          }).then(response => {
            if (response.ok) {
              window.location.href = '{{ route("login") }}';
            }
          }).catch(error => {
            console.error('Error:', error);
            window.location.href = '{{ route("login") }}';
          });
        }
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
      <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1" fill="none"/><circle cx="20" cy="21" r="1" fill="none"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" fill="none"/></svg>
      <span>Cart</span>
    </a>
    <a class="tab{{ Route::currentRouteName() === 'chat.index' ? ' active' : '' }}" href="{{ route('chat.index') }}">
      <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" fill="none"/></svg>
      <span>Message</span>
    </a>
    <a class="tab{{ Route::currentRouteName() === 'notifications' ? ' active' : '' }}" href="{{ route('notifications') }}">
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
