<!-- 5026231003 | Kanayya Shafa Amelia (kanayya shafa) -->

@extends('layouts.home-app')

@section('content')
<style>
    .account-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
    }

    .account-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .account-info {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-size: 16px;
        color: #666;
        font-weight: 500;
    }

    .info-value {
        font-size: 16px;
        color: #0a0a0a;
        font-weight: 600;
    }

    .edit-btn {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 20px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        margin-top: 20px;
    }
</style>

<div class="account-container">
    <div class="account-header">
        <h2>Account Information</h2>
        <p style="color: #666; margin: 8px 0 0 0;">Manage your personal information</p>
    </div>

    <div class="account-info">
        <div class="info-row">
            <span class="info-label">Full Name</span>
            <span class="info-value">{{ $user->user_name ?? 'Not set' }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Username</span>
            <span class="info-value">{{ $user->user_nametag ? '@' . $user->user_nametag : 'Not set' }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Email</span>
            <span class="info-value">{{ $user->email ?? 'Not set' }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Phone Number</span>
            <span class="info-value">{{ $user->user_number ?? 'Not set' }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Member Since</span>
            <span class="info-value">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'Unknown' }}</span>
        </div>
    </div>

    <button class="edit-btn" onclick="window.location.href='{{ route('profile.edit') }}'">
        Edit Account Information
    </button>
</div>
@endsection