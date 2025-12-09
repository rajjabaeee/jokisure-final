<!-- 5026231057 | Siti Qalimatus Zahra (SitiQalimatusZahra) -->

@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/track-order.css') }}">
    <style>
        .toast-notification {
            position: fixed;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.85);
            color: white;
            padding: 12px 24px;
            border-radius: 24px;
            font-size: 0.9rem;
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        
        .toast-notification.show {
            opacity: 1;
        }
    </style>
    <script>
        function copyOrderId(orderId) {
            navigator.clipboard.writeText(orderId).then(function() {
                showToast('Order ID copied!');
            }).catch(function(err) {
                console.error('Failed to copy: ', err);
                showToast('Failed to copy');
            });
        }
        
        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'toast-notification';
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.add('show');
            }, 10);
            
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 2000);
        }
    </script>
@endpush

@section('title', 'Track Order')

@section('appbar-title', '')

@section('appbar-left')
    <div style="display: flex; align-items: center; gap: 12px;">
        <a href="{{ route('orders.show', $order->order_id) }}" class="text-dark text-decoration-none">
            <i class="bi bi-arrow-left fs-4"></i>
        </a>
        <h5 class="mb-0 fw-bold">Track Order</h5>
    </div>
@endsection

@section('appbar-right')
    <i class="bi bi-question-circle fs-5 text-dark"></i>
@endsection

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
    $s3 = 'step-active-red';
}

$item = $order->orderItems->first();
@endphp

<div class="mobile-container">
    <div class="custom-card py-3">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <div class="fw-bold fs-5 mb-1">
                    Order ID: #{{ str_replace('ORD-', '', $order->order_id) }}
                </div>
                <div class="text-muted small">
                    {{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('d F Y, H:i') : \Carbon\Carbon::parse($order->order_date)->format('d F Y, H:i') }} WIB
                </div>
            </div>
            <i class="bi bi-copy text-dark" style="font-size:1.2rem; cursor:pointer;" onclick="copyOrderId('{{ $order->order_id }}')"></i>
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
                    <div class="tl-date">{{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('d F Y') : \Carbon\Carbon::parse($order->order_date)->format('d F Y') }}</div>
                    <div class="tl-desc">Order placed & Payment verified</div>
                </div>

            </div>
        </div>
        @endif
    </div>
</div>
@endsection