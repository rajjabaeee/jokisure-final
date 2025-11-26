{{-- resources/views/user/favorites-boosters.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h5 class="fw-bold mb-3">Favorite Boosters</h5>

    <div class="row g-3">
        <div class="col-12">
            <div class="card shadow-sm border-0 p-3 d-flex flex-row align-items-center">
                <img src="/images/avatar1.png" class="rounded-circle me-3" width="55" height="55" alt="Booster">
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1">RizkyBoost</h6>
                    <p class="small text-muted mb-1">Mobile Legends Specialist</p>
                    <span class="badge bg-success">⭐ 4.9</span>
                </div>
                <button class="btn btn-outline-danger btn-sm">Remove</button>
            </div>
        </div>
    </div>
</div>
@endsection
