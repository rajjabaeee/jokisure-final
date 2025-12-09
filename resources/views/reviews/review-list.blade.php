<!-- 5026231002 | Aisya Candra Kirana Dewi (Velyven) -->
<!-- 5026231057 | Siti Qalimatus Zahra (SitiQalimatusZahra) -->

@extends('layouts.app')

@section('title', 'Review')

@section('content')
<style>
    .review-header {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 16px;
    }

    .review-container {
        border: none;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 16px;
        background: white;
        border: 1px solid #e9e9e9;
    }

    .review-item {
        display: flex;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
        align-items: flex-start;
    }

    .review-item:last-child {
        border-bottom: none;
    }

    .review-item-image {
        width: 70px;
        height: 70px;
        border-radius: 12px;
        object-fit: cover;
        flex-shrink: 0;
        background: #f0f0f0;
    }

    .review-item-details {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .review-item-date {
        font-size: 12px;
        color: #999;
        margin-bottom: 4px;
    }

    .review-item-title {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .review-item-variant {
        font-size: 12px;
        color: #666;
        margin-bottom: 8px;
        line-height: 1.4;
    }

    .review-item-status {
        font-size: 11px;
        color: #999;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .review-item-rating {
        display: flex;
        gap: 2px;
        align-items: center;
    }

    .review-item-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .review-btn {
        background: #007aff;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 11px;
        cursor: pointer;
        text-decoration: none;
        font-weight: 600;
    }

    .review-btn:hover {
        background: #0056b3;
    }

    .complete-btn {
        background: #4caf50;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 11px;
        cursor: pointer;
        text-decoration: none;
        font-weight: 600;
    }

    .complete-btn:hover {
        background: #45a049;
    }

    .empty-review {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }

    .empty-review-icon {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-review-text {
        font-size: 14px;
        margin-bottom: 24px;
    }

    .demo-notice {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 16px;
        font-size: 13px;
        color: #856404;
    }
</style>

<div style="padding: 20px 16px; background: #f8f9fa; min-height: calc(100vh - 60px); padding-bottom: 100px;">
    
    {{-- Demo Mode Notice --}}
    <div class="demo-notice">
        <strong>Demo Mode:</strong> Click "Mark Complete" to change order status for testing review functionality.
    </div>
    
    @if($completedOrders->isEmpty())
        <div class="empty-review">
            <div class="empty-review-icon">📋</div>
            <div class="empty-review-text">No Orders</div>
            <div style="font-size: 12px;">Complete a booster service to leave a review.</div>
        </div>
    @else
        {{-- Review Header --}}
        <div class="review-header">My Orders</div>

        {{-- Review Container --}}
        <div class="review-container">
            @foreach($completedOrders as $order)
                @php
                    $item = $order->orderItems->first();
                    if (!$item) continue;
                    
                    $service = $item->service;
                    $game = $service->game;
                    
                    // Determine service image based on service description
                    $serviceImage = 'genshin boss.png'; // default
                    $serviceName = strtolower($service->service_desc ?? '');
                    
                    if (str_contains($serviceName, 'natlan')) {
                        $serviceImage = 'Natlan.png';
                    } elseif (str_contains($serviceName, 'inazuma')) {
                        $serviceImage = 'Inazuma.png';
                    } elseif (str_contains($serviceName, 'sumeru')) {
                        $serviceImage = 'Sumeru.png';
                    } elseif (str_contains($serviceName, 'fontaine')) {
                        $serviceImage = 'fontaine.png';
                    } elseif (str_contains($serviceName, 'liyue')) {
                        $serviceImage = 'liyue.png';
                    } elseif (str_contains($serviceName, 'mondstadt')) {
                        $serviceImage = 'Monstandt.png';
                    } elseif (str_contains($serviceName, 'dragonspine')) {
                        $serviceImage = 'Dragonspine.png';
                    } elseif (str_contains($serviceName, 'enkanomiya')) {
                        $serviceImage = 'enkanomiya.png';
                    } elseif (str_contains($serviceName, 'chasm')) {
                        $serviceImage = 'Chasm.png';
                    } elseif (str_contains($serviceName, 'weekly') || str_contains($serviceName, 'boss')) {
                        $serviceImage = 'genshin boss.png';
                    } elseif (str_contains($serviceName, 'abyss')) {
                        $serviceImage = 'abyss.jpg';
                    }
                @endphp
                
                <!-- Review Item -->
                <div class="review-item">
                    <img src="{{ asset('assets/' . $serviceImage) }}" class="review-item-image" alt="{{ $service->service_name }}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2270%22 height=%2270%22%3E%3Crect fill=%22%23f0f0f0%22 width=%2270%22 height=%2270%22/%3E%3C/svg%3E'">
                    <div class="review-item-details">
                        <div class="review-item-date">{{ $order->created_at ? $order->created_at->format('d M Y') : 'N/A' }}</div>
                        <div class="review-item-title">{{ $game->game_name }} - {{ $service->service_name }}</div>
                        <div class="review-item-variant">Variant: {{ $service->service_desc ?? 'Standard' }}</div>
                        <div class="review-item-status">Status: <span style="font-weight: 600;">{{ $order->orderStatus->order_status_name }}</span></div>
                        
                        <!-- Rating Stars -->
                        <div class="review-item-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="#FFD700" stroke="none">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            @endfor
                        </div>

                        <!-- Action Buttons -->
                        <div style="margin-top: 8px;">
                            @if($order->orderStatus->order_status_name === 'Completed')
                                <!-- Write Review Button -->
                                <a href="{{ route('reviews.create', $order->order_id) }}" class="review-btn">Write Review</a>
                            @else
                                <!-- Mark as Complete Button (Demo) -->
                                <form action="{{ route('orders.mark-complete', $order->order_id) }}" method="POST" style="margin: 0; margin-bottom: 8px;">
                                    @csrf
                                    <button type="submit" class="complete-btn">Mark Complete</button>
                                </form>
                                <!-- Write Review Button Below -->
                                <a href="{{ route('reviews.create', $order->order_id) }}" class="review-btn">Write Review</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    
</div>

<style>
    /* Mobile optimizations */
    @media (max-width: 768px) {
        .device-frame {
            overflow: hidden !important;
        }
        
        .safe-area {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 60px !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }
        
        .navbar {
            position: fixed !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 1000 !important;
        }
    }
</style>
@endsection