@extends('layouts.app')

@push('styles')
<style>
    .mobile-container { max-width: 480px; margin: 0 auto; background: #fff; min-height: 100vh; }
    .star-yellow { color: #ffc700; }
    .review-card { border-bottom: 1px solid #f0f0f0; padding-bottom: 15px; margin-bottom: 15px; }
</style>
@endpush

@section('content')
<div class="mobile-container p-4">

    <div class="d-flex align-items-center mb-4">
        {{-- Kembali ke halaman Orders --}}
        <a href="{{ route('orders') }}" class="text-dark me-3"><i class="bi bi-arrow-left fs-4"></i></a>
        <h5 class="fw-bold mb-0">Reviews</h5>
    </div>

    {{-- Header --}}
    <div class="mb-4">
        <h2 class="fw-bold display-6 mb-0">{{ number_format($reviews->avg('rating'), 1) }}</h2>
        <div class="text-muted small">Based on {{ $reviews->count() }} reviews</div>
        <div class="fw-bold mt-2 text-primary">{{ $service->game_name }} - {{ $service->service_desc }}</div>
    </div>

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="alert alert-success small mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- List Review --}}
    @forelse($reviews as $review)
        <div class="review-card">
            <div class="d-flex justify-content-between mb-2">
                <div class="fw-bold">{{ $review['buyer_name'] }}</div>
                <div class="small text-muted">{{ \Carbon\Carbon::parse($review['created_at'])->diffForHumans() }}</div>
            </div>

            <div class="mb-2">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $review['rating'])
                        <i class="bi bi-star-fill star-yellow"></i>
                    @else
                        <i class="bi bi-star text-muted"></i>
                    @endif
                @endfor
            </div>

            <p class="text-secondary small mb-0">
                "{{ $review['review_text'] }}"
            </p>
        </div>
    @empty
        <div class="text-center py-5 text-muted">
            <p>Belum ada review.</p>
        </div>
    @endforelse
</div>
@endsection