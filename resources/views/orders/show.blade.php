@extends('layouts.app')

@push('styles')
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Inter', sans-serif;
        }

        .mobile-container {
            max-width: 480px;
            margin: 0 auto;
            background: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }


        .header-wrap {
            padding: 20px 20px 10px 20px;
            display: flex;
            align-items: center;
        }

        .badge-status {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.75rem;
            color: #fff;
            display: inline-block;
            margin-bottom: 15px;
            text-transform: capitalize;
        }

        .st-waitlist { background-color: #a855f7; }
        .st-pending { background-color: #ff6b6b; }
        .st-progress { background-color: #0ea5e9; }
        .st-completed { background-color: #22c55e; }


        .content-padding {
            padding: 0 20px;
        }

        .section-divider {
            height: 1px;
            background-color: #eee;
            margin: 15px 0;
        }


        .booster-row {
            display: flex;
            align-items: center;
            padding: 10px 0;
        }

        .service-row {
            display: flex;
            align-items: flex-start;
            padding: 10px 0;
        }

        .thumb-img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 15px;
            background-color: #f0f0f0;
        }

        .text-label { font-size: 0.85rem; color: #666; }
        .text-val-bold { font-size: 0.9rem; font-weight: 700; color: #000; }
        .text-small-grey { font-size: 0.8rem; color: #888; }

        .detail-list {
            padding-left: 20px;
            margin: 5px 0 0 0;
        }
        .detail-list li {
            font-size: 0.85rem;
            color: #333;
            margin-bottom: 4px;
        }

        .bottom-action-bar {
            margin-top: auto;
            padding: 20px;
            display: flex;
            gap: 12px;
            background: #fff;
        }

        .btn-custom {
            flex: 1;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-gray { background-color: #c4c4c4; color: #fff; pointer-events: none; }
        .btn-pink { background-color: #ff2d55; color: #fff; }
        .btn-blue { background-color: #007aff; color: #fff; }
        .btn-yellow { background-color: #ffcc00; color: #000; }

        .btn-pink:hover { background-color: #e02448; }
        .btn-blue:hover { background-color: #0066d6; }
        .btn-yellow:hover { background-color: #e6b800; }

    </style>
@endpush

@section('appbar-title', 'Order Detail')

@section('content')
    @php
        $rawStatus = strtolower($order->orderStatus->order_status_name);
        $statusClass = 'st-waitlist';
        if (str_contains($rawStatus, 'pending')) $statusClass = 'st-pending';
        if (str_contains($rawStatus, 'progress')) $statusClass = 'st-progress';
        if (str_contains($rawStatus, 'completed')) $statusClass = 'st-completed';

        $item = $order->orderItems->first();
    @endphp

    <div class="mobile-container mt-1">

        <div class="header-wrap">
            <a href="{{ route('orders') }}" class="text-dark me-3 text-decoration-none">
                <i class="bi bi-arrow-left fs-4"></i>
            </a>
            <h5 class="mb-0 fw-bold flex-grow-1">Order Detail</h5>
            <i class="bi bi-question-circle fs-5 text-dark"></i>
        </div>

        <div class="content-padding">
            <div>
                <span class="badge-status {{ $statusClass }}">
                    {{ $order->orderStatus->order_status_name }}
                </span>
            </div>

            <div class="mb-2">
                <div class="fw-bold fs-5 mb-1">
                    Order ID: #{{ str_replace('ORD-', '', $order->order_id) }}
                    <i class="bi bi-copy text-muted ms-2" style="font-size:0.7em; cursor:pointer;"></i>
                </div>
                <div class="text-muted small">
                    {{ \Carbon\Carbon::parse($order->created_at)->format('d F Y, H:i') }} WIB
                </div>
            </div>

            <div class="section-divider"></div>

            <div class="booster-row">
                <img src="{{ asset('assets/' . str()->slug($item->service->booster->user->user_name) . '.jpg') }}" class="rounded-circle me-3" width="40" height="40" style="background:#eee; object-fit: cover;" onerror="this.src='{{ asset('assets/avatar-placeholder.jpg') }}'">
                <div class="flex-grow-1">
                    <div class="fw-bold text-dark">{{ $item->service->booster->user->user_name }}</div>
                </div>
                <i class="bi bi-chat-dots fs-4 text-dark"></i>
            </div>

            <div class="section-divider"></div>

            <div class="service-row">
                @php
                    // Get service-specific image based on content
                    $serviceContent = strtolower(($item->service->service_name ?? '') . ' ' . ($item->service->service_desc ?? ''));
                    
                    if (str_contains($serviceContent, 'abyss')) {
                        $imageName = 'abyss.jpg';
                    } elseif (str_contains($serviceContent, 'natlan')) {
                        $imageName = 'natlan.jpg';
                    } elseif (str_contains($serviceContent, 'inazuma')) {
                        $imageName = 'inazuma.jpg';
                    } elseif (str_contains($serviceContent, 'liyue')) {
                        $imageName = 'liyue.jpg';
                    } elseif (str_contains($serviceContent, 'mondstadt')) {
                        $imageName = 'Monstandt.png';
                    } elseif (str_contains($serviceContent, 'fontaine')) {
                        $imageName = 'fontaine.jpg';
                    } elseif (str_contains($serviceContent, 'sumeru')) {
                        $imageName = 'sumeru.jpg';
                    } elseif (str_contains($serviceContent, 'enkanomiya')) {
                        $imageName = 'enkanomiya.jpg';
                    } elseif (str_contains($serviceContent, 'dragonspine')) {
                        $imageName = 'dragonspine.jpg';
                    } elseif (str_contains($serviceContent, 'chasm')) {
                        $imageName = 'chasm.jpg';
                    } else {
                        $imageName = str()->slug($item->service->game->game_name) . '.jpg';
                    }
                @endphp
                <img src="{{ asset('assets/' . $imageName) }}" class="thumb-img" onerror="this.src='{{ asset('assets/default-thumb.png') }}'">
                <div>
                    <div class="fw-bold text-dark">{{ $item->service->game->game_name }}</div>
                    <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $item->service->service_desc }}</div>
                    <div class="text-small-grey mt-1">Variant: Floor 9, Floor 10, Floor 12</div>
                </div>
            </div>

            <div class="section-divider"></div>

            <div class="mb-4">
                <div class="fw-bold small text-dark">Details:</div>
                <ul class="detail-list">
                    <li>Story unlocked</li>
                    <li>Request: Live stream</li>
                </ul>
            </div>

            <div class="mb-3">
                <div class="fw-bold small text-dark mb-2">Payment Detail:</div>

                <div class="d-flex justify-content-between mb-1">
                    <span class="text-small-grey">Payment Method</span>
                    <span class="text-small-grey text-end">VISA/MasterCard</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-small-grey">Subtotal</span>
                    <span class="text-small-grey">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-small-grey">Discount</span>
                    <span class="text-small-grey text-danger">-Rp10.000</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-small-grey">Tax & Services</span>
                    <span class="text-small-grey">Rp5.000</span>
                </div>

                <div class="d-flex justify-content-between mt-2">
                    <span class="fw-bold text-dark">Total</span>
                    <span class="fw-bold text-dark">Rp{{ number_format($order->total_amount - 5000, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="bottom-action-bar">
            @if (str_contains($rawStatus, 'waitlist'))
                <button class="btn-custom btn-gray">Track Order</button>
                <button class="btn-custom btn-gray">Complete Order</button>

            @elseif(str_contains($rawStatus, 'pending'))
                <a href="{{ route('orders.track', $order->order_id) }}" class="btn-custom btn-pink">Track Order</a>
                <button class="btn-custom btn-gray">Complete Order</button>

            @elseif(str_contains($rawStatus, 'progress'))
                <a href="{{ route('orders.track', $order->order_id) }}" class="btn-custom btn-pink">Track Order</a>
                <button class="btn-custom btn-blue">Complete Order</button>

            @elseif(str_contains($rawStatus, 'completed'))
                <a href="{{ route('orders.track', $order->order_id) }}" class="btn-custom btn-pink">Track Order</a>
                <a href="{{ route('reviews.create', $order->order_id) }}" class="btn-custom btn-yellow">Review</a>
            @endif
        </div>

    </div>
@endsection