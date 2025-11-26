@extends('layouts.app')

@section('title', 'JokiSure | Home')

@section('content')
<div class="container py-3">

    {{-- Logo + Search + Cart --}}
    <div class="d-flex align-items-center mb-3">
        <img src="{{ asset('images/jokisure-logo.png') }}" alt="JokiSure" height="35">
        <div class="flex-grow-1 mx-2">
            <input type="text" class="form-control rounded-pill" placeholder="Search...">
        </div>
        <a href="#" class="position-relative">
            <i class="bi bi-cart3 fs-4"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">1</span>
        </a>
    </div>

    {{-- Banner --}}
    <div class="mb-4">
        <img src="{{ asset('images/banner-naruto.jpg') }}" class="img-fluid rounded-3 shadow-sm" alt="Banner">
    </div>

    {{-- Boost Games --}}
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="fw-bold mb-0">Boost Games</h5>
        <a href="{{ url('/games') }}" class="text-decoration-none text-primary fw-semibold">See All →</a>
    </div>

    <div class="scroll-x mb-4">
        <div class="d-inline-flex gap-2">
            @foreach (['Genshin Impact', 'Roblox', 'Mobile Legends', 'Honkai Star Rail', 'Free Fire', 'VALORANT'] as $game)
                <div class="card border-0 shadow-sm" style="width: 120px;">
                    <img src="{{ asset('images/' . Str::slug($game) . '.jpg') }}" class="card-img-top rounded" alt="{{ $game }}">
                    <div class="card-body text-center py-2">
                        <small class="fw-semibold">{{ $game }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Boosters --}}
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="fw-bold mb-0">1000+ Boosters</h5>
        <a href="{{ url('/boosters') }}" class="text-decoration-none text-primary fw-semibold">See All →</a>
    </div>

    <div class="scroll-x mb-4">
        <div class="d-inline-flex gap-3">
            @php
                $boosters = [
                    ['tier'=>'Gold Booster', 'name'=>'SealW', 'games'=>'Mobile Legends, VALORANT, Genshin Impact', 'img'=>'sealw.jpg'],
                    ['tier'=>'Diamond Booster', 'name'=>'BangBoost', 'games'=>'Genshin Impact, Zenless Zone Zero, Honkai Star Rail', 'img'=>'bangboost.jpg', 'tag'=>'May Best Seller'],
                    ['tier'=>'Diamond Booster', 'name'=>'MOBALovers', 'games'=>'Mobile Legends, DOTA, League of Legends', 'img'=>'mobalovers.jpg'],
                ];
            @endphp

            @foreach ($boosters as $b)
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="width: 260px;">
                <div class="row g-0 align-items-center">
                    <div class="col-4">
                        <img src="{{ asset('images/' . $b['img']) }}" class="img-fluid" alt="{{ $b['name'] }}">
                    </div>
                    <div class="col-8 p-2">
                        <div class="d-flex align-items-center flex-wrap">
                            <span class="badge bg-warning text-dark me-2">{{ $b['tier'] }}</span>
                            @if(isset($b['tag']))
                                <span class="badge bg-primary">{{ $b['tag'] }}</span>
                            @endif
                        </div>
                        <h6 class="fw-bold mt-1 mb-0">
                            {{ $b['name'] }}
                            <i class="bi bi-patch-check-fill text-primary"></i>
                        </h6>
                        <small class="text-muted d-block">Games: {{ $b['games'] }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- For You --}}
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="fw-bold mb-0">For You</h5>
    </div>

    <div class="row row-cols-2 g-3">
        @for ($i = 0; $i < 6; $i++)
        <div class="col">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <img src="{{ asset('images/genshin-abyss.jpg') }}" class="card-img-top" alt="Abyss">
                <div class="card-body p-2">
                    <span class="badge bg-primary">Open</span>
                    <h6 class="mt-2 mb-1">Genshin Impact | Abyss</h6>
                    <small class="text-muted d-block">Variant: Floor 9–12</small>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div>
                            <small><i class="bi bi-person-circle me-1"></i> BangBoost</small>
                            <i class="bi bi-patch-check-fill text-primary ms-1"></i>
                        </div>
                        <div class="fw-bold text-dark">Rp60,000+</div>
                    </div>
                    <small class="text-muted d-block">300 sold ★ 4.8 (120)</small>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>
@endsection