{{-- resources/views/marketplace/chat.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-3" style="height: 85vh; display: flex; flex-direction: column;">

    {{-- Header --}}
    <div class="d-flex align-items-center mb-3">
        <img src="/images/avatar1.png" class="rounded-circle me-2" width="45" height="45" alt="Booster">
        <div>
            <h6 class="fw-bold mb-0">RizkyBoost</h6>
            <p class="small text-muted mb-0">Online</p>
        </div>
    </div>

    {{-- Chat Body --}}
    <div class="flex-grow-1 overflow-auto mb-3" style="background: #f7f7f7; border-radius: 10px; padding: 15px;">

        {{-- Message from Booster --}}        
        <div class="d-flex mb-3">
            <div class="p-2 px-3 rounded" style="background: #fff; max-width: 75%;">
                <p class="small mb-0">Hello! I have started your boosting session now.</p>
            </div>
        </div>

        {{-- User Message --}}
        <div class="d-flex justify-content-end mb-3">
            <div class="p-2 px-3 rounded text-white" style="background: #0d6efd; max-width: 75%;">
                <p class="small mb-0">Okay! Please update me when you finish each rank.</p>
            </div>
        </div>

        {{-- Booster Reply --}}
        <div class="d-flex mb-3">
            <div class="p-2 px-3 rounded" style="background: #fff; max-width: 75%;">
                <p class="small mb-0">Sure, I'll keep you updated!</p>
            </div>
        </div>

    </div>

    {{-- Input Box --}}
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Type a message...">
        <button class="btn btn-primary">Send</button>
    </div>
</div>
@endsection
