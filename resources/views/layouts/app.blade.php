<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JokiSure')</title>

    {{-- Bootstrap 5.3 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Optional custom styles --}}
    <style>
        body {
            background-color: #f8f9fa;
            padding-bottom: 80px; /* Prevent content from hiding behind nav */
        }
        .navbar-bottom {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            border-top: 1px solid #ddd;
            z-index: 1000;
        }
        .navbar-bottom a {
            color: #6c757d;
            text-decoration: none;
            font-size: 0.85rem;
        }
        .navbar-bottom a.active {
            color: #dc3545;
        }
        .navbar-bottom i {
            font-size: 1.3rem;
        }
        .scroll-x {
            overflow-x: auto;
            white-space: nowrap;
        }
        .scroll-x::-webkit-scrollbar {
            display: none;
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- Main Content --}}
    <main class="pb-5">
        @yield('content')
    </main>

    {{-- Bottom Navigation --}}
    <nav class="navbar-bottom">
        <div class="container d-flex justify-content-around py-2">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }} text-center">
                <i class="bi bi-house-door-fill"></i><br>
                <small>Home</small>
            </a>
            <a href="{{ url('/cart') }}" class="{{ request()->is('cart') ? 'active' : '' }} text-center">
                <i class="bi bi-cart3"></i><br>
                <small>Cart</small>
            </a>
            <a href="{{ url('/messages') }}" class="{{ request()->is('messages') ? 'active' : '' }} text-center">
                <i class="bi bi-chat-dots"></i><br>
                <small>Message</small>
            </a>
            <a href="{{ url('/notifications') }}" class="{{ request()->is('notifications') ? 'active' : '' }} text-center">
                <i class="bi bi-bell"></i><br>
                <small>Notification</small>
            </a>
            <a href="{{ url('/profile') }}" class="{{ request()->is('profile') ? 'active' : '' }} text-center">
                <i class="bi bi-person"></i><br>
                <small>Profile</small>
            </a>
        </div>
    </nav>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
