<!-- 5026231003 | Kanayya Shafa Amelia (kanayya shafa) -->

@extends('layouts.app')

@section('title', 'My Profile')

@section('appbar-left')
  <a href="#" class="icon-btn" aria-label="Back">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M6 12h12M10 8l-4 4 4 4" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
  </a>
@endsection

@section('appbar-center')
  <div class="fw-semibold">My Profile</div>
@endsection

@section('appbar-right')
  <!-- Gear polos -->
  <a href="#" class="gear-btn" aria-label="Settings">
    <svg viewBox="0 0 24 24" aria-hidden="true">
      <path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z"/>
      <path d="M19.4 13.5a7.6 7.6 0 0 0 0-3l2.1-1.6-2-3.4-2.6 1a7.5 7.5 0 0 0-2.6-1.5l-.4-2.8H10l-.4 2.8c-.9.3-1.8.8-2.6 1.5l-2.6-1-2 3.4 2.1 1.6a7.6 7.6 0 0 0 0 3L2.4 15l2 3.4 2.6-1a7.5 7.5 0 0 0 2.6 1.5l.4 2.8h4.2l.4-2.8c.9-.3 1.8-.8 2.6-1.5l2.6 1 2-3.4-2.1-1.5Z"/>
    </svg>
  </a>
@endsection

@section('content')

      <!-- Profile -->
      <div class="card-block p-3 d-flex align-items-center gap-3 mt-2">
        <img src="{{ $user->user_profile_pic ? asset('storage/' . $user->user_profile_pic) : asset('assets/Tamago.jpg') }}" class="avatar" alt="avatar" style="width: 60px; height: 60px;">
        <div class="flex-grow-1">
          <div class="fw-semibold">{{ $user->user_name ?? 'User' }}</div>
          <div class="text-muted small">{{ $user->user_email ?? 'user@example.com' }}</div>
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
          <a href="{{ route('orders') }}" class="orders-see-all text-decoration-none">
            <span>See all</span>
            <svg width="14" height="14" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </div>
        <hr class="card-divider my-0">
        <div class="p-2">
          <div class="orders-grid">
            <a class="order-chip text-decoration-none" href="{{ route('orders') }}">
              <div class="ico"><svg viewBox="0 0 24 24"><path d="M5 6h14v12H5zM5 10h14" stroke="#0a0a0a" stroke-width="2" fill="none"/></svg></div>
              <span class="label">Waitlist</span>
            </a>
            <a class="order-chip text-decoration-none" href="{{ route('orders') }}">
              <div class="ico"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke="#0a0a0a" stroke-width="2" fill="none"/><path d="M12 7v6l4 2" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round"/></svg></div>
              <span class="label">Pending</span>
            </a>
            <a class="order-chip text-decoration-none" href="{{ route('orders') }}">
              <div class="ico"><svg viewBox="0 0 24 24"><path d="M6 19l4-10 4 6 4-12" stroke="#0a0a0a" stroke-width="2" fill="none"/></svg></div>
              <span class="label">On-Progress</span>
            </a>
            <a class="order-chip text-decoration-none" href="{{ route('orders') }}">
              <div class="ico"><svg viewBox="0 0 24 24"><rect x="5" y="5" width="14" height="14" rx="2" fill="none" stroke="#0a0a0a" stroke-width="2"/><path d="M9 12l2.5 2.5L15 11" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
              <span class="label">Completed</span>
            </a>
          </div>
        </div>
      </div>

      <!-- Review -->
      <div class="d-flex align-items-center justify-content-between mt-3 mb-2">
        <div class="fw-semibold">Review</div>
        <a href="{{ route('reviews') }}" class="small text-decoration-none text-muted">See all
          <svg width="14" height="14" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
      </div>
      <div class="card-block p-2">
        <div class="d-flex gap-2">
          <img class="review-thumb" src="{{ asset('assets/genshin boss.png') }}" alt="thumb">
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

@endsection
