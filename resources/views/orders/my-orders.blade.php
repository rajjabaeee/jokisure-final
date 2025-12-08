@extends('layouts.app')

@push('styles')
    <style>
        .badge-status {
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        .badge-status.waitlist {
            background-color: #d8b4fe;
            color: #fff;
        }

        .badge-status.pending {
            background-color: #ffa500;
            color: #fff;
        }

        .badge-status.on-progress, .badge-status.progress {
            background-color: #336791;
            color: #fff;
        }

        .badge-status.completed {
            background-color: #32cd32;
            color: #fff;
        }

        .order-card-new {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 16px;
            padding: 16px;
            border: 1px solid #f0f0f0;
        }

        .card-header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .booster-name {
            font-weight: 700;
            font-size: 1rem;
            color: #000;
        }

        .order-date {
            font-size: 0.75rem;
            color: #888;
        }

        .card-divider {
            height: 1px;
            background-color: #eee;
            margin: 0 -16px;
        }

        .card-body-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
        }

        .game-thumb {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            background-color: #ddd;
        }

        .service-title {
            font-weight: 600;
            font-size: 0.95rem;
            color: #333;
        }

        .card-footer-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 12px;
        }

        .price-label {
            font-size: 0.75rem;
            color: #888;
        }

        .price-value {
            font-weight: 500;
            font-size: 1rem;
            color: #000;
        }

        .btn-track {
            background-color: #e0e0e0;
            color: #757575;
            font-size: 0.8rem;
            padding: 6px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            border: none;
            display: inline-block;
            text-align: center;
        }

        .btn-track:hover {
            background-color: #d0d0d0;
            color: #000;
        }

        .btn-ori {
            color: #333;
            font-size: 1.3 rem;
            padding: 6px 16px;
            text-decoration: none;
            font-weight: 900;
            border: none;
        }

        .nav-underline .nav-link {
            color: #666;
            font-weight: 500;
        }

        .nav-underline .nav-link.active {
            color: #000;
            font-weight: 700;
            border-bottom-color: #000;
        }

        .no-wrap {
            white-space: nowrap;
        }
    </style>
@endpush

@section('appbar-title', 'My Orders')

@section('content')
    <div class="px-3 mt-2">
        <div class="input-group mb-3">
            <span class="input-group-text bg-white border-end-0">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8d8d8d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </span>
            <input type="search" class="form-control border-start-0 ps-0" placeholder="Search">
        </div>
    </div>

    <div class="tabs-text px-3 overflow-auto">
        <ul class="nav nav-underline flex-nowrap" id="ordersTab" role="tablist">
            @foreach(['all' => 'All', 'waitlist' => 'Waitlist', 'pending' => 'Pending', 'on-progress' => 'On Progress', 'completed' => 'Completed'] as $key => $label)
                <li class="nav-item" role="presentation">
                    <button class="nav-link no-wrap {{ $key == 'all' ? 'active' : '' }}"
                            id="tab-btn-{{ $key }}"
                            data-bs-toggle="tab"
                            data-bs-target="#tab-{{ $key }}"
                            type="button" role="tab">
                        {{ $label }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="tab-content mt-3 pb-5">

        @foreach(['all', 'waitlist', 'pending', 'on-progress', 'completed'] as $tabKey)

            <div class="tab-pane fade {{ $tabKey == 'all' ? 'show active' : '' }}" id="tab-{{ $tabKey }}" role="tabpanel">

                @php
                    $filteredOrders = $ordersnya->filter(function($order) use ($tabKey) {
                        if ($tabKey == 'all') return true;
                        $statusName = strtolower(str_replace(' ', '-', $order->orderStatus->order_status_name));
                        return $statusName == $tabKey;
                    });
                @endphp

                @forelse($filteredOrders as $order)
                    @php
                        $item = $order->orderItems->first();
                        $gameName = $item->service->game->game_name ?? 'Unknown Game';
                        $serviceName = $item->service->service_desc ?? 'Service';
                        $fullTitle = $gameName . ' - ' . $serviceName;
                        $thumb = asset('assets/default-thumb.png');
                        $boosterName = $item->service->booster->user->user_name ?? 'Waiting for Booster';
                        $rawStatus = $order->orderStatus->order_status_name ?? 'Unknown';
                        $statusClass = strtolower(str_replace(' ', '-', $rawStatus));
                        $date = \Carbon\Carbon::parse($order->order_date)->format('d F Y');
                        $isCompleted = (strtolower($rawStatus) == 'completed');
                    @endphp

                    <div class="order-card-new">
                        <div class="card-header-row">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <img src="{{ asset('assets/' . str()->slug($boosterName) . '.jpg') }}" alt="{{ $boosterName }}" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;" onerror="this.src='{{ asset('assets/avatar-placeholder.jpg') }}'">
                                <div>
                                    <div class="booster-name">{{ $boosterName }}</div>
                                    <div class="order-date">{{ $date }}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge-status {{ $statusClass }}">
                                    {{ $rawStatus }}
                                </span>
                                <a href="{{ route('orders.show', $order->order_id) }}" class="btn-ori text-decoration-none">
                                    <i class="bi bi-chevron-right" style="font-size: 0.9rem;"></i>
                                </a>
                            </div>
                        </div>

                        <div class="card-divider"></div>

                        <div class="card-body-row">
                            <img src="{{ asset('assets/' . str()->slug($gameName) . '.jpg') }}" class="game-thumb" alt="{{ $gameName }}" onerror="this.src='{{ asset('assets/default-thumb.png') }}'">
                            <div class="service-title">
                                {{ $fullTitle }}
                            </div>
                        </div>

                        <div class="card-divider"></div>

                        <div class="card-footer-row">
                            <div>
                                <div class="price-label">Total Price:</div>
                                <div class="price-value">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</div>
                            </div>

                            <div class="d-flex gap-2">
                                @if($isCompleted)
                                    <a href="{{ url('/') }}" class="btn-track">Joki Again</a>
                                    <a href="{{ route('reviews.create', $order->order_id) }}" class="btn-track">Review</a>
                                @else
                                    <a href="{{ route('orders.track', $order->order_id) }}" class="btn-track">Track Order</a>
                                @endif
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="py-5 text-center text-muted">
                        <div class="mb-2">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="3" y1="9" x2="21" y2="9"></line>
                                <line x1="9" y1="21" x2="9" y2="9"></line>
                            </svg>
                        </div>
                        <small>No orders found in {{ ucfirst(str_replace('-', ' ', $tabKey)) }}.</small>
                    </div>
                @endforelse

            </div>
        @endforeach

    </div>
@endsection