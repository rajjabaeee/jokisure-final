<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>JokiSure • My Profile</title>

  <!-- Bootstrap (sesuai file kamu) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS kamu (taruh di public/css/my-profile.css) -->
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
      <a href="#" class="icon-btn" aria-label="Back">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M6 12h12M10 8l-4 4 4 4" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
      <div class="fw-semibold">My Profile</div>

      <!-- Gear polos -->
      <a href="#" class="gear-btn" aria-label="Settings">
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z"/>
          <path d="M19.4 13.5a7.6 7.6 0 0 0 0-3l2.1-1.6-2-3.4-2.6 1a7.5 7.5 0 0 0-2.6-1.5l-.4-2.8H10l-.4 2.8c-.9.3-1.8.8-2.6 1.5l-2.6-1-2 3.4 2.1 1.6a7.6 7.6 0 0 0 0 3L2.4 15l2 3.4 2.6-1a7.5 7.5 0 0 0 2.6 1.5l.4 2.8h4.2l.4-2.8c.9-.3 1.8-.8 2.6-1.5l2.6 1 2-3.4-2.1-1.5Z"/>
        </svg>
      </a>
    </div>

    <!-- BODY -->
    <div class="container px-3 pb-5">

      <!-- Profile -->
      <div class="card-block p-3 d-flex align-items-center gap-3 mt-2">
        <img src="{{ asset('assets/images/Tamago.jpg') }}" class="avatar" alt="avatar">
        <div class="flex-grow-1">
          <div class="fw-semibold">Tamago</div>
          <div class="text-muted small">@dppgroup2</div>
        </div>
        <button class="edit-btn" onclick="window.location.href='{{ route('profile.edit') }}'">
          <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M3 17.25V21h3.75L18.81 8.94l-3.75-3.75L3 17.25Z" />
            <path d="M20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83Z" />
          </svg>
        </button>
      </div>

      <!-- My Orders -->
      <div class="card-block orders-card p-0 mt-3">
        <div class="orders-card-head d-flex align-items-center justify-content-between px-3 py-2">
          <div class="fw-bold orders-title">My Orders</div>
          <a href="{{ route('orders.index')}}" class="orders-see-all text-decoration-none">
            <span>See all</span>
            <svg width="14" height="14" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </div>
        <hr class="card-divider my-0">
        <div class="p-2">
          <div class="orders-grid">
            <a class="order-chip text-decoration-none" href="{{ route('orders.detail.waitlist') }}">
              <div class="ico"><svg viewBox="0 0 24 24"><path d="M5 6h14v12H5zM5 10h14" stroke="#0a0a0a" stroke-width="2" fill="none"/></svg></div>
              <span class="label">Waitlist</span>
            </a>
            <a class="order-chip text-decoration-none" href="{{ route('orders.detail.pending') }}">
              <div class="ico"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke="#0a0a0a" stroke-width="2" fill="none"/><path d="M12 7v6l4 2" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round"/></svg></div>
              <span class="label">Pending</span>
            </a>
            <a class="order-chip text-decoration-none" href="{{ route('orders.detail.progress') }}">
              <div class="ico"><svg viewBox="0 0 24 24"><path d="M6 19l4-10 4 6 4-12" stroke="#0a0a0a" stroke-width="2" fill="none"/></svg></div>
              <span class="label">On-Progress</span>
            </a>
            <a class="order-chip text-decoration-none" href="{{ route('orders.detail.completed') }}">
              <div class="ico"><svg viewBox="0 0 24 24"><rect x="5" y="5" width="14" height="14" rx="2" fill="none" stroke="#0a0a0a" stroke-width="2"/><path d="M9 12l2.5 2.5L15 11" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
              <span class="label">Completed</span>
            </a>
          </div>
        </div>
      </div>

      <!-- Review -->
      <div class="d-flex align-items-center justify-content-between mt-3 mb-2">
        <div class="fw-semibold">Review</div>
        <a href="#" class="small text-decoration-none text-muted">See all
          <svg width="14" height="14" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
      </div>
      <div class="card-block p-2">
        <div class="d-flex gap-2">
          <img class="review-thumb" src="{{ asset('assets/images/genshin boss.png') }}" alt="thumb">
          <div class="flex-grow-1">
            <div class="text-muted small mb-1">18 April 2025</div>
            <div class="fw-semibold small">Genshin Weekly Boss</div>
            <div class="text-muted small">Variant: Childe, Raiden, The Knave</div>
            <div class="stars mt-1">
              <svg viewBox="0 0 24 24" class="star"><path d="M12 17.3l6.18 3.7-1.64-7.03L21 9.24l-7.19-.61L12 2 10.19 8.63 3 9.24l4.46 4.73L5.82 21z"/></svg>
              <svg viewBox="0 0 24 24" class="star"><path d="M12 17.3l6.18 3.7-1.64-7.03L21 9.24l-7.19-.61L12 2 10.19 8.63 3 9.24l4.46 4.73L5.82 21z"/></svg>
              <svg viewBox="0 0 24 24" class="star"><path d="M12 17.3l6.18 3.7-1.64-7.03L21 9.24l-7.19-.61L12 2 10.19 8.63 3 9.24l4.46 4.73L5.82 21z"/></svg>
              <svg viewBox="0 0 24 24" class="star"><path d="M12 17.3l6.18 3.7-1.64-7.03L21 9.24l-7.19-.61L12 2 10.19 8.63 3 9.24l4.46 4.73L5.82 21z"/></svg>
              <svg viewBox="0 0 24 24" class="star off"><path d="M12 17.3l6.18 3.7-1.64-7.03L21 9.24l-7.19-.61L12 2 10.19 8.63 3 9.24l4.46 4.73L5.82 21z"/></svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Actions (1 row) -->
      <div class="card-block p-3 mt-3">
        <div class="qa-one-row">
          <a href="#" class="qa2">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" fill="none" stroke="#0a0a0a" stroke-width="2"/><path d="M12 8.5a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5Zm0 3v3" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round"/></svg>
            <span>Help Center</span>
          </a>
          <a href="#" class="qa2">
            <svg viewBox="0 0 24 24"><path d="M8.5 16a3.5 3.5 0 1 1 0-7h2.2a5 5 0 1 1 0 7H8.5Z" fill="none" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>Support</span>
          </a>
          <a href="#" class="qa2">
            <svg viewBox="0 0 24 24"><path d="M5 10l1.5-5h11L19 10H5Zm0 0v9h14v-9" fill="none" stroke="#0a0a0a" stroke-width="2" stroke-linejoin="round"/></svg>
            <span>Favorite Boosters</span>
          </a>
          <a href="#" class="qa2">
            <svg viewBox="0 0 24 24"><rect x="4" y="7" width="16" height="10" rx="2" fill="none" stroke="#0a0a0a" stroke-width="2"/><path d="M8 12h8" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round"/></svg>
            <span>Coupon</span>
          </a>
          <a href="#" class="qa2">
            <svg viewBox="0 0 24 24"><path d="M12 21s-6-3.5-6-8.5A4.5 4.5 0 0 1 12 8a4.5 4.5 0 0 1 6 4.5C18 17.5 12 21 12 21Z" fill="none" stroke="#0a0a0a" stroke-width="2"/></svg>
            <span>Favorite</span>
          </a>
        </div>
      </div>

    </div>
  </section>

  <!-- TAB BAR -->
  <nav class="tabbar">
    <a class="tab" href="#">
      <svg viewBox="0 0 24 24"><path d="M3 10l9-7 9 7v8a2 2 0 0 1-2 2h-3v-5H8v5H5a2 2 0 0 1-2-2v-8Z"/></svg>
      <span>Home</span>
    </a>
    <a class="tab" href="#">
      <svg viewBox="0 0 24 24"><path d="M6 7h12l-1 11a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2L6 7Z" fill="none" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 7V5a3 3 0 0 1 6 0v2" fill="none"/></svg>
      <span>Cart</span>
    </a>
    <a class="tab" href="#">
      <svg viewBox="0 0 24 24"><path d="M21 12a8.5 8.5 0 1 1-17 0 8.5 8.5 0 0 1 17 0Zm-8.5-5v5l3 2" fill="none"/></svg>
      <span>Message</span>
    </a>
    <a class="tab" href="#">
      <svg viewBox="0 0 24 24"><path d="M6 9a6 6 0 0 1 12 0v5l1.5 1.5a1 1 0 0 1-.7 1.7H5.2a1 1 0 0 1-.7-1.7L6 14V9Z" fill="none"/><path d="M10 19a2 2 0 1 0 4 0" fill="none"/></svg>
      <span>Notification</span>
    </a>
    <a class="tab active" href="{{ route('profile.show') }}">
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
