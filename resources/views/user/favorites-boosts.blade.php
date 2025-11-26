{{-- resources/views/user/favorites-boosts.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h5 class="fw-bold mb-3">Favorite Boosts</h5>

    <div class="row g-3">
        <div class="col-12">
            <div class="card shadow-sm border-0 p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">Mobile Legends - Rank Boost</h6>
                        <p class="small text-muted mb-1">Epic → Mythic</p>
                        <span class="fw-bold">Rp 120.000</span>
                    </div>
                    <button class="btn btn-outline-danger btn-sm">Remove</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
