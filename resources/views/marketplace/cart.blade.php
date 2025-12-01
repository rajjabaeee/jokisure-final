
@extends('layouts.app')

@section('title', 'Cart')

@section('appbar-title', 'Cart')

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
        background: white;
        padding: 16px;
        border-top: 1px solid #e0e0e0;
        display: flex;
        gap: 12px;
        align-items: center;
        margin-top: 16px;
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
    </style>

    <!-- BODY -->
    <div class="px-3 pb-5 mt-3">

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

      {{-- Bottom action bar --}}
      <div class="bottom-section">
        <button class="coupon-btn">No Coupons</button>
        <div class="price-display">Rp120.000</div>
        <a href="{{ route('boost.request') }}" class="pay-btn">Pay</a>
      </div>
    </div>

@endsection
