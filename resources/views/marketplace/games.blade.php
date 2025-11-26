{{-- resources/views/marketplace/games.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h5 class="fw-bold mb-3">Games</h5>

    <div class="row g-3">
        {{-- Game Card 1 --}}
        <div class="col-12">
            <div class="card shadow-sm border-0 p-3 d-flex flex-row align-items-center">
                <img src="/images/mlbb.png" class="rounded me-3" width="55" height="55" alt="Mobile Legends">
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1">Mobile Legends</h6>
                    <p class="small text-muted mb-1">Popular MOBA Game</p>
                    <span class="badge bg-success">⭐ 4.9</span>
                </div>
                <a href="#" class="btn btn-primary btn-sm">View</a>
            </div>
        </div>

        {{-- Game Card 2 --}}
        <div class="col-12">
            <div class="card shadow-sm border-0 p-3 d-flex flex-row align-items-center">
                <img src="/images/valorant.png" class="rounded me-3" width="55" height="55" alt="Valorant">
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1">Valorant</h6>
                    <p class="small text-muted mb-1">Tactical FPS Game</p>
                    <span class="badge bg-success">⭐ 4.8</span>
                </div>
                <a href="#" class="btn btn-primary btn-sm">View</a>
            </div>
        </div>

        {{-- Game Card 3 --}}
        <div class="col-12">
            <div class="card shadow-sm border-0 p-3 d-flex flex-row align-items-center">
                <img src="/images/genshin.png" class="rounded me-3" width="55" height="55" alt="Genshin Impact">
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1">Genshin Impact</h6>
                    <p class="small text-muted mb-1">Open World Adventure</p>
                    <span class="badge bg-success">⭐ 5.0</span>
                </div>
                <a href="#" class="btn btn-primary btn-sm">View</a>
            </div>
        </div>
    </div>
</div>
@endsection
