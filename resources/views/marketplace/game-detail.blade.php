@extends('layouts.app')

@section('title', 'Mobile Legends Details')

@section('content')
<div class="container py-4">

    {{-- Game Header --}}
    <div class="text-center mb-4">
        <img src="/images/mlbb.png" class="img-fluid rounded mb-2" width="120" alt="Mobile Legends">
        <h4 class="fw-bold">Mobile Legends</h4>
        <p class="text-muted small">Choose your desired service</p>
    </div>

    {{-- Sections --}}
    <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="rank-tab" data-bs-toggle="pill" data-bs-target="#rank" type="button">Rank Boost</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="winrate-tab" data-bs-toggle="pill" data-bs-target="#winrate" type="button">Winrate</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="other-tab" data-bs-toggle="pill" data-bs-target="#other" type="button">Other</button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">

        {{-- Rank Boost Section --}}
        <div class="tab-pane fade show active" id="rank" role="tabpanel">
            <div class="card shadow-sm border-0 p-3 mb-3">
                <h6 class="fw-bold">Rank Boost</h6>
                <p class="small text-muted">Select from and to rank</p>

                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label small fw-bold">From</label>
                        <select class="form-select">
                            <option>Epic</option>
                            <option>Legend</option>
                            <option>Mythic</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">To</label>
                        <select class="form-select">
                            <option>Legend</option>
                            <option>Mythic</option>
                            <option>Mythical Glory</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="d-grid">
                <button class="btn btn-primary">Continue</button>
            </div>
        </div>

        {{-- Winrate Section --}}
        <div class="tab-pane fade" id="winrate" role="tabpanel">
            <div class="card shadow-sm border-0 p-3 mb-3">
                <h6 class="fw-bold">Winrate Boost</h6>
                <p class="small text-muted">Choose match amount</p>

                <select class="form-select mb-3">
                    <option>5 Matches</option>
                    <option>10 Matches</option>
                    <option>20 Matches</option>
                </select>
            </div>

            <div class="d-grid">
                <button class="btn btn-primary">Continue</button>
            </div>
        </div>

        {{-- Other Section --}}
        <div class="tab-pane fade" id="other" role="tabpanel">
            <div class="card shadow-sm border-0 p-3 mb-3">
                <h6 class="fw-bold">Other Services</h6>
                <p class="small text-muted">Examples: level up, emblem, hero mastery</p>

                <select class="form-select mb-3">
                    <option>Leveling</option>
                    <option>Emblem Upgrade</option>
                    <option>Hero Mastery</option>
                </select>
            </div>

            <div class="d-grid">
                <button class="btn btn-primary">Continue</button>
            </div>
        </div>
    </div>
</div>
@endsection
