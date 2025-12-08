@extends('layouts.app')

@push('styles')
    <style>
        body { background-color: #f5f5f5; font-family: 'Inter', sans-serif; }

        .mobile-container {
            max-width: 480px;
            margin: 0 auto;
            background: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
        }

        .header-wrap { padding: 20px 20px 10px 20px; display: flex; align-items: center; }
        .badge-status { padding: 5px 10px; border-radius: 4px; font-weight: 600; font-size: 0.75rem; color: #fff; display: inline-block; margin-bottom: 15px; text-transform: capitalize; }
        .st-waitlist { background-color: #a855f7; }
        .st-pending { background-color: #ff6b6b; }
        .st-progress { background-color: #0ea5e9; }
        .st-completed { background-color: #22c55e; }

        .content-padding { padding: 0 20px; flex-grow: 1; }
        .section-divider { height: 1px; background-color: #eee; margin: 15px 0; }
        .booster-row, .service-row { display: flex; align-items: center; padding: 10px 0; }
        .thumb-img { width: 60px; height: 60px; border-radius: 8px; object-fit: cover; margin-right: 15px; background-color: #f0f0f0; }
        .detail-list { padding-left: 20px; margin: 5px 0 0 0; }
        .detail-list li { font-size: 0.85rem; color: #333; margin-bottom: 4px; }
        .text-small-grey { font-size: 0.8rem; color: #888; }

        .bottom-action-bar { padding: 20px; display: flex; gap: 12px; background: #fff; margin-top: auto; }
        .btn-custom { flex: 1; padding: 14px; border-radius: 12px; font-weight: 600; font-size: 0.9rem; border: none; text-align: center; text-decoration: none; cursor: pointer; transition: 0.2s; }
        .btn-gray { background-color: #c4c4c4; color: #fff; pointer-events: none; }
        .btn-pink { background-color: #ff2d55; color: #fff; }
        .btn-blue { background-color: #007aff; color: #fff; }
        .btn-yellow { background-color: #ffcc00; color: #000; }

        .mobile-modal-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 100;
            display: none;
            align-items: flex-end;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .mobile-modal-overlay.active {
            display: flex;
            opacity: 1;
        }

        .mobile-modal-box {
            background: #fff;
            width: 100%;
            max-height: 85%;

            border-radius: 24px 24px 0 0;

            padding: 20px 25px 30px 25px;
            position: relative;

            transform: translateY(100%);
            transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);

            overflow-y: auto;
            box-shadow: 0 -5px 25px rgba(0,0,0,0.1);
        }

        .mobile-modal-overlay.active .mobile-modal-box {
            transform: translateY(0);
        }

        .modal-handle-bar {
            width: 40px;
            height: 4px;
            background-color: #e0e0e0;
            border-radius: 2px;
            margin: 0 auto 20px auto;
        }

        .modal-service-img { width: 50px; height: 50px; border-radius: 8px; object-fit: cover; margin-right: 15px; }
        .modal-service-title { font-weight: 700; font-size: 0.9rem; color: #000; }
        .modal-service-variant { font-size: 0.75rem; color: #666; }

        .star-rating { display: flex; justify-content: center; gap: 8px; margin: 15px 0; direction: rtl; }
        .star-rating input { display: none; }
        .star-rating label { font-size: 36px; color: #e0e0e0; cursor: pointer; transition: color 0.2s; line-height: 1; }
        .star-rating label:before { content: '★'; }
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label { color: #ffc107; }

        .form-label-bold { font-weight: 700; font-size: 0.9rem; margin-bottom: 8px; display: block; }
        .form-control-custom { border: 1px solid #eee; background-color: #fafafa; border-radius: 12px; padding: 14px; font-size: 0.9rem; width: 100%; resize: none; font-family: inherit;}
        .form-control-custom:focus { outline: none; border-color: #ff2d55; background-color: #fff; }

        .photo-upload-box { border: 1px dashed #ccc; border-radius: 12px; padding: 15px; display: flex; align-items: center; justify-content: center; color: #888; cursor: pointer; background: #fafafa; }
        .photo-upload-box:hover { background: #f0f0f0; }

        .btn-send-review { background-color: #ff2d55; color: #fff; width: 100%; padding: 16px; border-radius: 14px; border: none; font-weight: 700; margin-top: 15px; cursor: pointer; font-size: 1rem; }
        .btn-send-review:hover { background-color: #e02448; }

        .btn-close-absolute { position: absolute; top: 20px; right: 20px; background: #f0f0f0; border: none; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #555; cursor: pointer; }

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

    <div class="mobile-container">

        <div class="header-wrap">
            <a href="{{ route('orders.index') }}" class="text-dark me-3 text-decoration-none">
                <i class="bi bi-arrow-left fs-4"></i>
            </a>
            <h5 class="mb-0 fw-bold flex-grow-1">Order Detail</h5>
            <i class="bi bi-question-circle fs-5 text-dark"></i>
        </div>

        <div class="content-padding">
            <div><span class="badge-status {{ $statusClass }}">{{ $order->orderStatus->order_status_name }}</span></div>
            <div class="mb-2">
                <div class="fw-bold fs-5 mb-1">
                    Order ID: #{{ str_replace('ORD-', '', $order->order_id) }}
                    <i class="bi bi-copy text-muted ms-2" style="font-size:0.7em; cursor:pointer;"></i>
                </div>
                <div class="text-muted small">{{ \Carbon\Carbon::parse($order->created_at)->format('d F Y, H:i') }} WIB</div>
            </div>
            <div class="section-divider"></div>


            <div class="booster-row">
                <img src="{{ asset('images/avatar1.png') }}" class="rounded-circle me-3" width="40" height="40" style="background:#eee; object-fit: cover;">
                <div class="flex-grow-1"><div class="fw-bold text-dark">{{ $item->service->booster->user->user_name }}</div></div>
                <i class="bi bi-chat-dots fs-4 text-dark"></i>
            </div>
            <div class="section-divider"></div>

            <div class="service-row">
                <img src="{{ asset('assets/default-thumb.png') }}" class="thumb-img">
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
                <div class="d-flex justify-content-between mb-1"><span class="text-small-grey">Subtotal</span><span class="text-small-grey">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span></div>
                <div class="d-flex justify-content-between mb-1"><span class="text-small-grey">Discount</span><span class="text-small-grey text-danger">-Rp10.000</span></div>
                <div class="d-flex justify-content-between mt-2"><span class="fw-bold text-dark">Total</span><span class="fw-bold text-dark">Rp{{ number_format($order->total_amount - 5000, 0, ',', '.') }}</span></div>
            </div>
        </div>

        <div class="bottom-action-bar">
            @if(str_contains($rawStatus, 'completed'))
                <a href="{{ route('orders.track', $order->order_id) }}" class="btn-custom btn-pink">Track Order</a>
                <button type="button" class="btn-custom btn-yellow" onclick="openReviewModal()">
                    Review
                </button>
            @elseif(str_contains($rawStatus, 'pending') || str_contains($rawStatus, 'progress'))
                <a href="{{ route('orders.track', $order->order_id) }}" class="btn-custom btn-pink">Track Order</a>
                <button class="btn-custom btn-blue">Complete Order</button>
            @else
                <button class="btn-custom btn-gray">Track Order</button>
                <button class="btn-custom btn-gray">Complete Order</button>
            @endif
        </div>

        <div id="mobileReviewModal" class="mobile-modal-overlay">
            <div class="mobile-modal-box">

                <div class="modal-handle-bar"></div>

                <button type="button" class="btn-close-absolute" onclick="closeReviewModal()">
                    <i class="bi bi-x"></i>
                </button>

                <form action="{{ route('reviews.store', $order->order_id) }}" method="POST">
                    @csrf

                    <div class="d-flex align-items-center mb-4 mt-2">
                        <img src="{{ asset('assets/default-thumb.png') }}" class="modal-service-img">
                        <div>
                            <div class="modal-service-title">{{ $item->service->game->game_name }}</div>
                            <div class="modal-service-variant text-muted">Variant: {{ $item->service->service_desc }}</div>
                        </div>
                    </div>

                    <div class="text-center mb-2">
                        <span class="fw-bold small text-secondary">Tap stars to rate</span>
                    </div>
                    <div class="star-rating">
                        <input type="radio" id="star5" name="rating" value="5" required /><label for="star5"></label>
                        <input type="radio" id="star4" name="rating" value="4" /><label for="star4"></label>
                        <input type="radio" id="star3" name="rating" value="3" /><label for="star3"></label>
                        <input type="radio" id="star2" name="rating" value="2" /><label for="star2"></label>
                        <input type="radio" id="star1" name="rating" value="1" /><label for="star1"></label>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-bold">Write your review</label>
                        <textarea name="review" class="form-control-custom" rows="4" placeholder="Share your experience with this booster..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-bold">Add photos</label>
                        <div class="photo-upload-box">
                            <div class="text-center">
                                <i class="bi bi-camera fs-5"></i>
                                <span class="ms-2 small">Upload Photos</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-send-review">Submit Review</button>

                    <div style="height: 20px;"></div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function openReviewModal() {
            var modal = document.getElementById('mobileReviewModal');
            modal.style.display = 'flex';
            setTimeout(() => {
                modal.classList.add('active');
            }, 10);
        }

        function closeReviewModal() {
            var modal = document.getElementById('mobileReviewModal');
            modal.classList.remove('active');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }
    </script>
@endsection