@extends('layouts.app')

@push('styles')
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }

        .mobile-container {
            max-width: 480px;
            margin: 0 auto;
            min-height: 100vh;
            padding-bottom: 40px;
        }

        .custom-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            border: 1px solid #f0f0f0;
        }

        .header-wrap {
            padding: 20px 0;
            display: flex;
            align-items: center;
        }

        .stepper-container {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 25px;
            padding: 0;
        }

        .stepper-track-bg {
            position: absolute;
            top: 15px;
            left: 16px;
            right: 16px;
            height: 3px;
            background: #e5e7eb;
            z-index: 0;
            border-radius: 2px;
        }

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

@section('appbar-title', 'Track Order')

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