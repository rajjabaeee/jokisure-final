@extends('layouts.home-app')

@section('title', 'Track Order')

@section('content')
<div style="padding: 20px 16px; background: #f8f9fa; min-height: calc(100vh - 60px); padding-bottom: 100px;">
    
    @php
        $rawStatus = strtolower($order->orderStatus->order_status_name);
        $item = $order->orderItems->first();
        $service = $item->service;
        $game = $service->game;
        $booster = $service->booster;
        
        // Determine service image based on service description
        $serviceImage = 'genshin boss.png'; // default for Genshin services
        $serviceName = strtolower($service->service_desc);
        
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
        
        $statusBadgeColor = '#666';
        if (str_contains($rawStatus, 'completed')) $statusBadgeColor = '#22c55e';
        elseif (str_contains($rawStatus, 'progress')) $statusBadgeColor = '#0ea5e9';
        elseif (str_contains($rawStatus, 'pending')) $statusBadgeColor = '#ff6b6b';
        elseif (str_contains($rawStatus, 'waitlist')) $statusBadgeColor = '#a855f7';
    @endphp
    
    <!-- Order Status Card -->
    <div style="background: white; border-radius: 16px; margin-bottom: 16px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="font-size: 12px; padding: 4px 12px; background: {{ $statusBadgeColor }}; color: white; border-radius: 20px; display: inline-block; margin-bottom: 16px; font-weight: 600; text-transform: capitalize;">
            {{ $order->orderStatus->order_status_name }}
        </div>
        <div style="font-size: 20px; font-weight: 700; margin-bottom: 8px;">
            Order ID: #{{ str_replace('ORD-', '', $order->order_id) }}
        </div>
        <div style="font-size: 14px; color: #666;">
            {{ $order->created_at->format('d F Y, H:i') }} WIB
        </div>
    </div>
    
    <!-- Booster Info -->
    <div style="background: white; border-radius: 16px; margin-bottom: 16px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: center; gap: 12px;">
            <img src="{{ asset('assets/' . str()->slug($booster->user->user_name) . '.jpg') }}" alt="{{ $booster->user->user_name }}" 
                 style="width: 50px; height: 50px; border-radius: 12px; object-fit: cover;" 
                 onerror="this.src='{{ asset('assets/Tamago.jpg') }}'">
            <div style="flex: 1;">
                <div style="font-size: 16px; font-weight: 600; color: #000;">{{ $booster->user->user_name }}</div>
            </div>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2">
                <path d="M12 2l3 6 6 1-4.5 4.5L18 20l-6-3-6 3 1.5-6.5L3 9l6-1z"/>
            </svg>
        </div>
    </div>
    
    <!-- Service Info -->
    <div style="background: white; border-radius: 16px; margin-bottom: 16px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: flex-start; gap: 12px;">
            <img src="{{ asset('assets/' . $serviceImage) }}" alt="{{ $service->service_desc }}" 
                 style="width: 60px; height: 60px; border-radius: 12px; object-fit: cover; flex-shrink: 0;">
            <div style="flex: 1; min-width: 0;">
                <div style="font-size: 16px; font-weight: 600; color: #000; margin-bottom: 4px;">
                    {{ $game->game_name }}
                </div>
                <div style="font-size: 14px; font-weight: 500; color: #000; margin-bottom: 8px;">
                    {{ $service->service_desc }}
                </div>
                <div style="font-size: 12px; color: #666;">
                    Variant: Childe, Raiden, The Knave
                </div>
            </div>
        </div>
    </div>
    
    <!-- Progress Tracking -->
    <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="font-size: 16px; font-weight: 600; color: #000; margin-bottom: 20px;">Order Progress</div>
        
        <!-- Timeline -->
        <div style="position: relative;">
            @foreach ($logs as $index => $log)
                <div style="display: flex; align-items: flex-start; gap: 16px; margin-bottom: 24px; position: relative;">
                    <!-- Timeline Line -->
                    @if(!$loop->last)
                        <div style="position: absolute; left: 12px; top: 24px; width: 2px; height: calc(100% + 24px); background: #e5e7eb; z-index: 1;"></div>
                    @endif
                    
                    <!-- Timeline Dot -->
                    <div style="width: 24px; height: 24px; border-radius: 50%; background: {{ $loop->first ? '#22c55e' : '#e5e7eb' }}; flex-shrink: 0; z-index: 2; position: relative;"></div>
                    
                    <!-- Timeline Content -->
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-size: 14px; color: #666; margin-bottom: 4px;">
                            {{ $log->date->format('d F Y') }}
                        </div>
                        <div style="font-size: 14px; font-weight: 500; color: #000;">
                            {{ $log->status }}
                        </div>
                    </div>
                </div>
            @endforeach
            
            <!-- Order Created -->
            <div style="display: flex; align-items: flex-start; gap: 16px;">
                <div style="width: 24px; height: 24px; border-radius: 50%; background: #22c55e; flex-shrink: 0; z-index: 2; position: relative;"></div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-size: 14px; color: #666; margin-bottom: 4px;">
                        {{ $order->created_at->format('d F Y') }}
                    </div>
                    <div style="font-size: 14px; font-weight: 500; color: #000;">
                        Order placed & Payment verified
                    </div>
                </div>
            </div>
        </div>
    </div>
    
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

        .stepper-track-fill {
            position: absolute;
            top: 15px;
            left: 16px;
            height: 3px;
            z-index: 1;
            border-radius: 2px;
            transition: all 0.4s ease;
        }

        .stepper-track-fill.waitlisted {
            width: 0%;
            background: transparent;
        }

        .stepper-track-fill.pending {
            width: 0%;
            background: #3b82f6;
        }

        .stepper-track-fill.progress {
            width: 50%;
            background: linear-gradient(to right, #3b82f6 0%, #ec4899 100%);
        }

        .stepper-track-fill.completed {
            width: calc(100% - 32px);
            background: linear-gradient(to right, #3b82f6 0%, #ec4899 50%, #10b981 100%);
        }

        .step-item {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 0 0 auto;
        }

        .step-icon-box {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            font-size: 14px;
            border: 3px solid #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .step-inactive {
            background: #e5e7eb;
            color: #9ca3af;
        }

        .step-active-blue {
            background: #3b82f6;
            color: white;
            transform: scale(1.15);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .step-active-pink {
            background: #ec4899;
            color: white;
            transform: scale(1.15);
            box-shadow: 0 4px 12px rgba(236, 72, 153, 0.4);
        }

        .step-active-green {
            background: #10b981;
            color: white;
            transform: scale(1.15);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        .step-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: #111;
            text-align: center;
            white-space: nowrap;
        }

        .timeline-wrapper {
            margin-top: 10px;
            padding-left: 10px;
        }

        .timeline-item {
            position: relative;
            padding-left: 35px;
            padding-bottom: 35px;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 7px;
            top: 10px;
            bottom: -10px;
            width: 2px;
            background-color: #e5e7eb;
            z-index: 0;
        }

        .timeline-item:last-child::before {
            display: none;
        }

        .timeline-item.passed::before,
        .timeline-item.current::before {
            background-color: #bfdbfe;
        }

        .bullet-point {
            position: absolute;
            left: 0;
            top: 2px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            z-index: 2;
            border: 2px solid #fff;
            box-shadow: 0 0 0 1px #e5e7eb;
            background: #e5e7eb;
        }

        .timeline-item.passed .bullet-point {
            background: #3b82f6;
            box-shadow: 0 0 0 1px #3b82f6;
        }

        .timeline-item.current .bullet-point {
            background: #3b82f6;
            box-shadow: 0 0 0 3px #bfdbfe;
        }

        .tl-date {
            font-size: 0.85rem;
            font-weight: 700;
            color: #111;
            line-height: 1.2;
        }

        .tl-desc {
            font-size: 0.85rem;
            color: #666;
            margin-top: 4px;
        }

        .divider {
            height: 1px;
            background: #f0f0f0;
            margin: 15px -20px;
        }
    </style>
@endpush

@section('title', 'Track Order')

@section('content')
@php
$rawStatus = strtolower($order->orderStatus->order_status_name);
$statusClass = 'waitlisted';
$s1 = 'step-inactive';
$s2 = 'step-inactive';
$s3 = 'step-inactive';

if(str_contains($rawStatus, 'waitlisted')) {
    $statusClass = 'waitlisted';
    $s1 = 'step-inactive';
    $s2 = 'step-inactive';
    $s3 = 'step-inactive';
}
if(str_contains($rawStatus, 'pending')) {
    $statusClass = 'pending';
    $s1 = 'step-active-blue';
}
if(str_contains($rawStatus, 'progress')) {
    $statusClass = 'progress';
    $s1 = 'step-active-blue';
    $s2 = 'step-active-pink';
}
if(str_contains($rawStatus, 'completed')) {
    $statusClass = 'completed';
    $s1 = 'step-active-blue';
    $s2 = 'step-active-pink';
    $s3 = 'step-active-green';
}

$item = $order->orderItems->first();
@endphp

<div class="mobile-container p-3">
    <div class="header-wrap">
        <a href="{{ route('orders.show', $order->order_id) }}" class="text-dark me-3 text-decoration-none">
            <i class="bi bi-arrow-left fs-4"></i>
        </a>
        <h5 class="mb-0 fw-bold flex-grow-1">Track Order</h5>
        <i class="bi bi-question-circle fs-5 text-dark"></i>
    </div>

    <div class="custom-card py-3">
        <div class="fw-bold fs-5 mb-1">
            Order ID: #{{ str_replace('ORD-', '', $order->order_id) }}
            <i class="bi bi-files ms-2 text-dark" style="font-size:0.8em; cursor:pointer;"></i>
        </div>
        <div class="text-muted small">
            {{ \Carbon\Carbon::parse($order->created_at)->format('d F Y, H:i') }} WIB
        </div>
    </div>

    <div class="custom-card">
        <div class="fw-bold small text-secondary mb-1">Estimated completion:</div>
        <div class="fw-bold fs-5 mb-3">22 June 2025</div>

        <div class="section-divider border-bottom mb-4"></div>

        <div class="stepper-container">
            <div class="stepper-track-bg"></div>
            <div class="stepper-track-fill {{ $statusClass }}"></div>

            <div class="step-item">
                <div class="step-icon-box {{ $s1 }}">
                    <i class="bi bi-clock-fill"></i>
                </div>
                <div class="step-label">Pending</div>
            </div>

            <div class="step-item">
                <div class="step-icon-box {{ $s2 }}">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="step-label">On-Progress</div>
            </div>

            <div class="step-item">
                <div class="step-icon-box {{ $s3 }}">
                    <i class="bi bi-check-lg"></i>
                </div>
                <div class="step-label">Completed</div>
            </div>
        </div>
    </div>

    <div class="custom-card p-0 overflow-hidden">
        <div class="p-3 d-flex align-items-center">
            <img src="{{ asset('assets/' . str()->slug($item->service->booster->user->user_name) . '.jpg') }}" class="rounded me-3" width="45" height="45" style="object-fit:cover; border-radius: 10px;" onerror="this.src='{{ asset('assets/avatar-placeholder.jpg') }}'">
            <div class="flex-grow-1">
                <div class="fw-bold fs-6">{{ $item->service->booster->user->user_name }}</div>
            </div>
            <i class="bi bi-chat-dots fs-4 text-dark"></i>
        </div>

        @if(!str_contains($rawStatus, 'waitlisted'))
        <div class="divider m-0"></div>

        <div class="p-4 pt-3">
            <div class="timeline-wrapper">

                @foreach ($logs as $index => $log)
                    @php $itemClass = $loop->first ? 'current' : 'passed'; @endphp

                    <div class="timeline-item {{ $itemClass }}">
                        <div class="bullet-point"></div>
                        <div class="tl-date">{{ \Carbon\Carbon::parse($log->date)->format('d F Y') }}</div>
                        <div class="tl-desc">{{ $log->status }}</div>
                    </div>
                @endforeach

                <div class="timeline-item">
                    <div class="bullet-point"></div>
                    <div class="tl-date">{{ \Carbon\Carbon::parse($order->created_at)->format('d F Y') }}</div>
                    <div class="tl-desc">Order placed & Payment verified</div>
                </div>

            </div>
        </div>
        @endif
    </div>
</div>
@endsection