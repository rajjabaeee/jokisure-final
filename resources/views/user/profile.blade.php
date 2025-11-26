{{-- resources/views/user/profile.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h5 class="fw-bold mb-3">My Profile</h5>

    {{-- Profile Card --}}
    <div class="card shadow-sm border-0 p-4 mb-4 text-center">
        <img src="/images/avatar-profile.png" class="rounded-circle mx-auto mb-2" width="80" height="80" alt="Profile Picture">
        <h6 class="fw-bold mb-1">John Doe</h6>
        <p class="small text-muted mb-0">john.doe@email.com</p>
    </div>

    {{-- Profile Info --}}
    <div class="card shadow-sm border-0 p-3 mb-3">
        <h6 class="fw-bold mb-3">Account Information</h6>

        <div class="mb-3">
            <label class="form-label small text-muted">Full Name</label>
            <p class="fw-semibold">John Doe</p>
        </div>

        <div class="mb-3">
            <label class="form-label small text-muted">Email</label>
            <p class="fw-semibold">john.doe@email.com</p>
        </div>

        <div class="mb-3">
            <label class="form-label small text-muted">Phone Number</label>
            <p class="fw-semibold">+62 812 3456 7890</p>
        </div>

        <a href="#" class="btn btn-outline-primary btn-sm">Edit Profile</a>
    </div>

    {{-- Settings --}}
    <div class="card shadow-sm border-0 p-3 mb-3">
        <h6 class="fw-bold">Settings</h6>

        <a href="#" class="d-flex justify-content-between align-items-center py-2 text-decoration-none text-dark">
            <span>Change Password</span>
            <span class="text-muted">></span>
        </a>

        <a href="#" class="d-flex justify-content-between align-items-center py-2 text-decoration-none text-dark">
            <span>Notifications</span>
            <span class="text-muted">></span>
        </a>

        <a href="#" class="d-flex justify-content-between align-items-center py-2 text-decoration-none text-dark">
            <span>Privacy Settings</span>
            <span class="text-muted">></span>
        </a>
    </div>

    {{-- Help & Support --}}
    <div class="card shadow-sm border-0 p-3 mb-3">
        <h6 class="fw-bold">Help & Support</h6>

        <a href="#" class="d-flex justify-content-between align-items-center py-2 text-decoration-none text-dark">
            <span>FAQ</span>
            <span class="text-muted">></span>
        </a>

        <a href="#" class="d-flex justify-content-between align-items-center py-2 text-decoration-none text-dark">
            <span>Help Center</span>
            <span class="text-muted">></span>
        </a>

        <a href="#" class="d-flex justify-content-between align-items-center py-2 text-decoration-none text-dark">
            <span>Terms of Service</span>
            <span class="text-muted">></span>
        </a>
    </div>

    <div class="d-grid">
        <button class="btn btn-danger">Logout</button>
    </div>
</div>
@endsection
