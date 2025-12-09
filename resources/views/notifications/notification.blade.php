@extends('layouts.app')

@section('title', 'Notifications')

@section('appbar-left')
  <a href="{{ url()->previous() }}" class="icon-btn" aria-label="Back">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M6 12h12M10 8l-4 4 4 4" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
  </a>
@endsection

@section('appbar-center')
  <div class="fw-semibold">Notification</div>
@endsection

@section('appbar-right')
  <a href="#" class="icon-btn" aria-label="Help">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
      <circle cx="12" cy="12" r="9" stroke="#0a0a0a" stroke-width="2"/>
      <path d="M12 8.5a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5Zm0 3v3" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round"/>
    </svg>
  </a>
@endsection

@section('content')
<div class="notification-page">
  <!-- Notification List -->
  <div class="notification-list">
    @foreach($notifications as $notification)
    <div class="notification-item {{ $notification['is_read'] ? 'read' : 'unread' }}">
      <div class="notification-icon">
        <img src="{{ asset('assets/' . $notification['icon']) }}" alt="notification icon" onerror="console.log('Image failed to load: {{ asset('assets/' . $notification['icon']) }}')">
        @if(!$notification['is_read'])
          <span class="notification-badge"></span>
        @endif
      </div>
      <div class="notification-content">
        <div class="notification-title">{{ $notification['title'] }}</div>
        <div class="notification-message">{{ $notification['message'] }}</div>
      </div>
    </div>
    @endforeach
  </div>

    <!-- Order Status Section -->
    <div class="order-status-section">
    <a href="{{ route('orders') }}" class="section-header-link">
      <div class="section-header">
        <span class="section-title">Order Status</span>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
          <path d="M9 18l6-6-6-6" stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
    </a>
    
    <div class="order-status-card">
      <div class="order-image">
        <img src="{{ asset('assets/' . $orderStatus['image']) }}" alt="order image" onerror="console.log('Order image failed to load: {{ asset('assets/' . $orderStatus['image']) }}')">
      </div>
      <div class="order-details">
        <div class="order-status-title">{{ $orderStatus['title'] }}</div>
        <div class="order-status-message">{{ $orderStatus['message'] }}</div>
        <div class="order-action">
          <span class="action-text">{{ $orderStatus['action_text'] }}</span>
          <a href="{{ route('orders') }}" class="review-btn">{{ $orderStatus['action_button'] }}</a>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
/* Notification Page Styles */
.notification-page {
  background: #f5f5f7;
  min-height: calc(100vh - 140px);
}

.notification-list {
  background: #fff;
  margin-bottom: 12px;
}

.notification-item {
  display: flex;
  align-items: flex-start;
  padding: 16px;
  border-bottom: 1px solid #f0f0f0;
  position: relative;
  background: #fff;
}

.notification-item:last-child {
  border-bottom: none;
}

.notification-icon {
  position: relative;
  margin-right: 12px;
  flex-shrink: 0;
}

.notification-icon img {
  width: 40px;
  height: 40px;
  border-radius: 20px;
  object-fit: cover;
  background: #f0f0f0; /* fallback background */
}

.notification-badge {
  position: absolute;
  top: -2px;
  right: -2px;
  width: 10px;
  height: 10px;
  background: #ff4961;
  border-radius: 50%;
  border: 2px solid #fff;
}

.notification-content {
  flex: 1;
}

.notification-title {
  font-weight: 600;
  font-size: 16px;
  color: #0a0a0a;
  margin-bottom: 4px;
}

.notification-message {
  font-size: 14px;
  color: #666;
  line-height: 1.4;
}

.notification-item.read .notification-title {
  color: #666;
}

.notification-item.read .notification-message {
  color: #999;
}

/* Order Status Section */
.order-status-section {
  padding: 0 16px;
  margin-top: 12px;
}

.section-header-link {
  text-decoration: none;
  color: inherit;
  display: block;
  cursor: pointer;
}

.section-header-link:hover .section-title {
  color: #ff4961;
  transition: color 0.2s ease;
}

.section-header-link:hover svg path {
  stroke: #ff4961;
  transition: stroke 0.2s ease;
}

.section-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 12px;
  padding: 0 4px;
}

.section-title {
  font-weight: 600;
  font-size: 16px;
  color: #0a0a0a;
}

.order-status-card {
  background: #fff;
  border-radius: 12px;
  padding: 16px;
  display: flex;
  align-items: flex-start;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  border: 1px solid #e5e5e7;
}

.order-image {
  margin-right: 12px;
  flex-shrink: 0;
}

.order-image img {
  width: 60px;
  height: 60px;
  border-radius: 8px;
  object-fit: cover;
  background: #f0f0f0; /* fallback background */
}

.order-details {
  flex: 1;
}

.order-status-title {
  font-weight: 600;
  font-size: 16px;
  color: #0a0a0a;
  margin-bottom: 4px;
}

.order-status-message {
  font-size: 14px;
  color: #666;
  margin-bottom: 12px;
}

.order-action {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.action-text {
  font-size: 12px;
  color: #666;
  flex: 1;
  margin-right: 12px;
}

.review-btn {
  background: #ffa500;
  color: #fff;
  border: none;
  border-radius: 16px;
  padding: 6px 16px;
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
  text-decoration: none;
  display: inline-block;
}

.review-btn:hover {
  background: #e6940a;
  color: #fff;
  text-decoration: none;
}
</style>

@endsection