{{-- resources/views/marketplace/cart.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h5 class="fw-bold mb-3">My Cart</h5>

    {{-- Cart Item --}}
    <div class="card shadow-sm border-0 p-3 mb-3 d-flex flex-row align-items-center">
        <img src="/images/mlbb.png" class="rounded me-3" width="55" alt="Mobile Legends">

        <div class="flex-grow-1">
            <h6 class="fw-bold mb-1">Mobile Legends</h6>
            <p class="small text-muted mb-1">Rank Boost • Epic → Mythic</p>
            <span class="fw-bold">Rp 120.000</span>
        </div>

        <button class="btn btn-outline-danger btn-sm">Remove</button>
    </div>

    {{-- Cart Item 2 --}}
    <div class="card shadow-sm border-0 p-3 mb-3 d-flex flex-row align-items-center">
        <img src="/images/valorant.png" class="rounded me-3" width="55" alt="Valorant">

        <div class="flex-grow-1">
            <h6 class="fw-bold mb-1">Valorant</h6>
            <p class="small text-muted mb-1">Winrate • 10 Matches</p>
            <span class="fw-bold">Rp 75.000</span>
        </div>

        <button class="btn btn-outline-danger btn-sm">Remove</button>
    </div>

    {{-- Summary --}}
    <div class="card shadow-sm border-0 p-3 mt-4">
        <h6 class="fw-bold mb-2">Order Summary</h6>

        <div class="d-flex justify-content-between mb-1">
            <span class="text-muted small">Subtotal</span>
            <span class="small">Rp 195.000</span>
        </div>

        <div class="d-flex justify-content-between mb-3">
            <span class="text-muted small">Service Fee</span>
            <span class="small">Rp 5.000</span>
        </div>

        <div class="d-flex justify-content-between">
            <span class="fw-bold">Total</span>
            <span class="fw-bold">Rp 200.000</span>
        </div>
    </div>

    <div class="d-grid mt-3">
        <button class="btn btn-primary btn-lg">Proceed to Checkout</button>
    </div>
</div>
@endsection
