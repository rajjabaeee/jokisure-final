{{-- resources/views/marketplace/cart.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>JokiSure • Cart</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    * {
      font-family: 'Inter', sans-serif;
    }

    body {
      background-color: #f5f5f5;
    }

    .preview-center {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 20px;
      background: #000;
    }

    .device-frame {
      width: 100%;
      max-width: 375px;
      height: 812px;
      background: white;
      border-radius: 40px;
      padding: 12px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.3);
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    .status-bar {
      height: 44px;
      background: white;
      padding: 0 16px;
      font-size: 14px;
    }

    .battery {
      width: 24px;
      height: 12px;
      border: 1.5px solid #000;
      border-radius: 2px;
      position: relative;
    }
    .battery::after {
      content: '';
      position: absolute;
      top: 50%;
      right: -4px;
      width: 2px;
      height: 4px;
      background: #000;
      transform: translateY(-50%);
    }

    .safe-area {
      background: white;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      flex: 1;
    }

    .appbar {
      height: 56px;
      padding: 0 16px;
      border-bottom: 1px solid #e0e0e0;
    }

    .appbar a {
      cursor: pointer;
    }

    .title-appbar {
      font-size: 16px;
      font-weight: 600;
      flex: 1;
      text-align: center;
    }

    .home-indicator {
      height: 34px;
      background: white;
      position: relative;
      display: flex;
      align-items: flex-end;
      justify-content: center;
      padding-bottom: 8px;
    }

    .home-indicator::after {
      content: '';
      width: 120px;
      height: 4px;
      background: #000;
      border-radius: 2px;
    }

    .content {
      padding: 16px;
      padding-bottom: 16px;
      flex: 1;
      overflow-y: auto;
    }

    .cart-header {
      font-size: 18px;
      font-weight: 700;
      margin-bottom: 16px;
    }

    .cart-container {
      border: none;
      border-radius: 16px;
      padding: 16px;
      margin-bottom: 16px;
    }

    .seller-name {
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 12px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .seller-edit {
      font-size: 12px;
      color: #999;
      cursor: pointer;
    }

    .cart-item {
      display: flex;
      gap: 12px;
      padding: 12px 0;
    }

    .cart-item-checkbox {
      width: 20px;
      height: 20px;
      margin-top: 4px;
      flex-shrink: 0;
      cursor: pointer;
    }

    .cart-item-image {
      width: 70px;
      height: 70px;
      border-radius: 12px;
      object-fit: cover;
      flex-shrink: 0;
    }

    .cart-item-details {
      flex: 1;
    }

    .cart-item-title {
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 4px;
    }

    .cart-item-variant {
      font-size: 12px;
      color: #666;
      margin-bottom: 8px;
      line-height: 1.4;
    }

    .cart-item-price {
      font-size: 14px;
      font-weight: 700;
      color: #000;
    }

    .bottom-section {
      position: relative;
      background: white;
      padding: 16px;
      border-top: 1px solid #e0e0e0;
      display: flex;
      gap: 12px;
      align-items: center;
      flex-shrink: 0;
    }

    .coupon-btn {
      background: #e8e8e8;
      border: none;
      border-radius: 20px;
      padding: 10px 16px;
      font-size: 12px;
      font-weight: 500;
      color: #333;
      cursor: pointer;
      white-space: nowrap;
      flex-shrink: 0;
    }

    .price-display {
      flex: 1;
      font-size: 16px;
      font-weight: 700;
    }

    .pay-btn {
      background: #ff3b6d;
      color: white;
      border: none;
      border-radius: 20px;
      padding: 10px 24px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      white-space: nowrap;
      flex-shrink: 0;
    }

    .pay-btn:hover {
      background: #e8306a;
    }

    .navbar-bottom {
      display: flex;
      justify-content: space-around;
      align-items: center;
      height: 60px;
      border-top: 1px solid #e0e0e0;
      margin-top: 16px;
      flex-shrink: 0;
    }

    .navbar-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 4px;
      text-decoration: none;
      color: #666;
      font-size: 10px;
      cursor: pointer;
    }

    .navbar-item.active {
      color: #ff3b6d;
    }

    .navbar-icon {
      width: 24px;
      height: 24px;
    }
  </style>
</head>
<body class="preview-center">
<main class="device-frame">

  {{-- Status bar --}}
  <div class="status-bar d-flex align-items-center justify-content-between">
    <div class="fw-semibold">9:41</div>
    <div class="d-flex align-items-center gap-2"><div class="battery"></div></div>
  </div>

  {{-- Safe area --}}
  <section class="safe-area">
    {{-- App bar --}}
    <div class="appbar d-flex align-items-center justify-content-between">
      <a href="{{ url()->previous() }}" class="text-dark text-decoration-none" aria-label="Back">
        <svg width="22" height="22" fill="none" aria-hidden="true"><path d="M14 5l-6 6 6 6" stroke="#000" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
      <div class="title-appbar">Cart</div>
      <svg width="22" height="22" fill="none" aria-hidden="true"><circle cx="11" cy="11" r="10" stroke="#000" stroke-width="2"/><text x="11" y="15" text-anchor="middle" font-size="10" font-family="Inter, sans-serif" fill="#000">?</text></svg>
    </div>

    <div class="content">
      {{-- Cart Header --}}
      <div class="cart-header">My Cart</div>

      {{-- Cart Container --}}
      <div class="cart-container">
        <div class="seller-name">
          <span>BangBoost</span>
          <span class="seller-edit">Edit</span>
        </div>

        {{-- Cart Item --}}
        <div class="cart-item">
          <input type="checkbox" class="cart-item-checkbox" checked>
          <img src="{{ asset('assets/genshin boss.png') }}" class="cart-item-image" alt="Genshin Weekly Boss">
          <div class="cart-item-details">
            <div class="cart-item-title">Genshin Weekly Boss</div>
            <div class="cart-item-variant">Variant: Childe, Raiden, The Knave</div>
            <div class="cart-item-price">Rp120.000</div>
          </div>
        </div>
      </div>
    </div>

    {{-- Bottom action bar --}}
    <div class="bottom-section">
      <button class="coupon-btn">No Coupons</button>
      <div class="price-display">Rp120.000</div>
      <button class="pay-btn">Pay</button>
    </div>

    <div class="navbar-bottom">
      <a href="/home" class="navbar-item">
        <svg class="navbar-icon" viewBox="0 0 24 24" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
        Home
      </a>
      <a href="/cart" class="navbar-item active">
        <svg class="navbar-icon" viewBox="0 0 24 24" fill="currentColor"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
        Cart
      </a>
      <a href="/chat" class="navbar-item">
        <svg class="navbar-icon" viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
        Message
      </a>
      <a href="#" class="navbar-item">
        <svg class="navbar-icon" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
        Notification
      </a>
      <a href="/profile" class="navbar-item">
        <svg class="navbar-icon" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
        Profile
      </a>
    </div>
  </section>

  <div class="home-indicator"></div>
</main>

</body>
</html>
