
@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <style>
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
        background: white;
        border: 1px solid #e9e9e9;
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
        border-bottom: 1px solid #f0f0f0;
      }

      .cart-item:last-child {
        border-bottom: none;
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
        background: #f0f0f0;
      }

      .cart-item-details {
        flex: 1;
        display: flex;
        flex-direction: column;
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
        margin-bottom: 8px;
      }

      .cart-item-actions {
        display: flex;
        gap: 8px;
        align-items: center;
      }

      .remove-btn {
        background: #ff6b6b;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 11px;
        cursor: pointer;
        text-decoration: none;
      }

      .remove-btn:hover {
        background: #ff5252;
      }

      .empty-cart {
        text-align: center;
        padding: 40px 20px;
        color: #999;
      }

      .empty-cart-icon {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
      }

      .empty-cart-text {
        font-size: 14px;
        margin-bottom: 24px;
      }

      .empty-cart-btn {
        background: #0066cc;
        color: white;
        border: none;
        border-radius: 20px;
        padding: 10px 24px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
      }

      .bottom-section {
        background: white;
        padding: 16px;
        border-top: 1px solid #e0e0e0;
        display: flex;
        gap: 12px;
        align-items: center;
        position: fixed;
        bottom: 84px; /* Height of tabbar */
        left: 50%;
        transform: translateX(-50%);
        width: calc(100% - 32px);
        max-width: 375px;
        box-sizing: border-box;
        z-index: 100;
        border-radius: 16px 16px 0 0;
        box-shadow: 0 -4px 16px rgba(0,0,0,0.1);
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
        text-decoration: none;
      }

      .pay-btn:hover {
        background: #e8306a;
      }

      .pay-btn:disabled {
        background: #ccc;
        cursor: not-allowed;
      }

      .toast-message {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: #333;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 14px;
        z-index: 1000;
        animation: slideDown 0.3s ease;
      }

      @keyframes slideDown {
        from { transform: translate(-50%, -100%); opacity: 0; }
        to { transform: translate(-50%, 0); opacity: 1; }
      }

      /* Mobile responsive adjustments */
      @media (max-width: 576px) {
        .bottom-section {
          left: 0;
          transform: none;
          width: 100%;
          max-width: none;
          border-radius: 0;
          bottom: 84px; /* Ensure it stays above the navbar on mobile too */
        }
      }
    </style>

    <!-- BODY -->
    <div class="px-3 mt-3" style="overflow: hidden; height: calc(100% - 50px - 16px); padding-bottom: 120px;">

      @if(session('success'))
        <div class="toast-message">{{ session('success') }}</div>
      @endif

      @if(session('error'))
        <div class="toast-message">{{ session('error') }}</div>
      @endif

      @if($cartItems->isEmpty())
        <div class="empty-cart">
          <div class="empty-cart-icon">🛒</div>
          <div class="empty-cart-text">No items in your cart yet</div>
          <a href="{{ route('home') }}" class="empty-cart-btn">Continue Shopping</a>
        </div>
      @else
        {{-- Cart Header --}}
        <div class="cart-header">My Cart</div>

        {{-- Group items by seller --}}
        @php
          $groupedItems = $cartItems->groupBy(function($item) {
            return $item->service->booster->booster_id;
          });
        @endphp

        @foreach($groupedItems as $sellerName => $items)
          {{-- Cart Container --}}
          <div class="cart-container">
            <div class="seller-name">
              <span>{{ $items->first()->service->booster->user->user_name ?? 'Unknown Seller' }}</span>
              <span class="seller-edit">Edit</span>
            </div>

            {{-- Cart Items --}}
            @foreach($items as $cartItem)
              <div class="cart-item">
                <input type="checkbox" class="cart-item-checkbox" checked data-item-id="{{ $cartItem->service_id }}">
                <img src="{{ asset('assets/' . (strtolower(str_replace(' ', '-', $cartItem->service->game->game_name)) . '.jpg')) }}" class="cart-item-image" alt="{{ $cartItem->service->game->game_name ?? 'Service' }}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2270%22 height=%2270%22%3E%3Crect fill=%22%23f0f0f0%22 width=%2270%22 height=%2270%22/%3E%3C/svg%3E'">
                <div class="cart-item-details">
                  <div class="cart-item-title">{{ $cartItem->service->game->game_name ?? 'Service' }}</div>
                  <div class="cart-item-variant">Variant: {{ $cartItem->service->service_desc ?? 'Standard' }}</div>
                  <div class="cart-item-price">Rp {{ number_format($cartItem->service->service_price, 0, ',', '.') }}</div>
                  <div class="cart-item-actions">
                    <form action="{{ route('cart.remove', ['cartId' => $cartItem->cart_id, 'serviceId' => $cartItem->service_id]) }}" method="POST" style="display: inline;">
                      @csrf
                      @method('POST')
                      <button type="submit" class="remove-btn">Remove</button>
                    </form>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endforeach

        {{-- Bottom action bar --}}
        <div class="bottom-section">
          <button class="coupon-btn">No Coupons</button>
          <div class="price-display" id="totalPrice">Rp {{ number_format($cartItems->sum(fn($item) => $item->service->service_price), 0, ',', '.') }}</div>
          <a href="#" onclick="handlePay(event)" class="pay-btn">Pay</a>
        </div>
      @endif
    </div>

    <script>
      // Auto-calculate total price based on checked items
      document.querySelectorAll('.cart-item-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateTotal);
      });

      function updateTotal() {
        let total = 0;
        document.querySelectorAll('.cart-item-checkbox:checked').forEach(checkbox => {
          const price = parseInt(
            checkbox.closest('.cart-item')
              .querySelector('.cart-item-price')
              .textContent.replace(/[^0-9]/g, '')
          );
          total += price;
        });
        
        const priceDisplay = document.getElementById('totalPrice');
        priceDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
      }

      // Handle checkout navigation
      function handlePay(e) {
        e.preventDefault();
        const selectedServices = [];
        document.querySelectorAll('.cart-item-checkbox:checked').forEach(checkbox => {
          const serviceId = checkbox.getAttribute('data-item-id');
          selectedServices.push(serviceId);
        });

        if (selectedServices.length === 0) {
          alert('Please select at least one item to proceed');
          return;
        }

        // Redirect to checkout with selected services (array format)
        const queryString = selectedServices.map(id => 'services[]=' + id).join('&');
        window.location.href = '{{ route("boost.request") }}?' + queryString;
      }
    </script>

@endsection
