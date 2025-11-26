{{-- resources/views/marketplace/boosters.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h5 class="fw-bold mb-3">Boosters</h5>

    <div class="row g-3">
        {{-- Booster Card 1 --}}
        <div class="col-12">
            <div class="card shadow-sm border-0 p-3 d-flex flex-row align-items-center">
                <img src="/images/avatar1.png" class="rounded-circle me-3" width="55" height="55" alt="Booster 1">
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1">RizkyBoost</h6>
                    <p class="small text-muted mb-1">Mobile Legends Specialist</p>
                    <span class="badge bg-success">⭐ 4.9</span>
                </div>
                <a href="#" class="btn btn-primary btn-sm">View</a>
            </div>
        </div>

        {{-- Booster Card 2 --}}
        <div class="col-12">
            <div class="card shadow-sm border-0 p-3 d-flex flex-row align-items-center">
                <img src="/images/avatar2.png" class="rounded-circle me-3" width="55" height="55" alt="Booster 2">
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1">ValorPro</h6>
                    <p class="small text-muted mb-1">Valorant Radiant Player</p>
                    <span class="badge bg-success">⭐ 4.8</span>
                </div>
                <a href="#" class="btn btn-primary btn-sm">View</a>
            </div>
        </div>

        {{-- Booster Card 3 --}}
        <div class="col-12">
            <div class="card shadow-sm border-0 p-3 d-flex flex-row align-items-center">
                <img src="/images/avatar3.png" class="rounded-circle me-3" width="55" height="55" alt="Booster 3">
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1">GenshinQueen</h6>
                    <p class="small text-muted mb-1">Genshin Exploration Expert</p>
                    <span class="badge bg-success">⭐ 5.0</span>
                </div>
                <a href="#" class="btn btn-primary btn-sm">View</a>
            </div>
        </div>
    </div>
</div>
@endsection
