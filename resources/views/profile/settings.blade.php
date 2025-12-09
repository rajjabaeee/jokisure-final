<!-- 5026231003 | Kanayya Shafa Amelia (kanayya shafa) -->

@extends('layouts.home-app')

@section('content')
<style>
    .settings-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
    }

    .settings-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .settings-section {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .setting-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .setting-item:last-child {
        border-bottom: none;
    }

    .setting-label {
        font-size: 16px;
        color: #0a0a0a;
        font-weight: 500;
    }

    .setting-description {
        font-size: 14px;
        color: #666;
        margin-top: 4px;
    }

    .toggle-switch {
        position: relative;
        width: 50px;
        height: 25px;
        background: #ddd;
        border-radius: 25px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .toggle-switch.active {
        background: #667eea;
    }

    .toggle-switch::after {
        content: '';
        position: absolute;
        width: 21px;
        height: 21px;
        background: white;
        border-radius: 50%;
        top: 2px;
        left: 2px;
        transition: left 0.3s;
    }

    .toggle-switch.active::after {
        left: 27px;
    }

    .logout-btn {
        background: linear-gradient(135deg, #ff6b6b, #ff5252);
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

<div class="settings-container">
    <div class="settings-header">
        <h2>Settings</h2>
        <p style="color: #666; margin: 8px 0 0 0;">Customize your app experience</p>
    </div>

    <div class="settings-section">
        <h3 style="margin: 0 0 20px 0; font-size: 18px; color: #0a0a0a;">Notifications</h3>
        
        <div class="setting-item">
            <div>
                <div class="setting-label">Push Notifications</div>
                <div class="setting-description">Receive notifications about orders and messages</div>
            </div>
            <div class="toggle-switch active" onclick="toggleSetting(this)"></div>
        </div>

        <div class="setting-item">
            <div>
                <div class="setting-label">Email Notifications</div>
                <div class="setting-description">Get updates via email</div>
            </div>
            <div class="toggle-switch" onclick="toggleSetting(this)"></div>
        </div>

        <div class="setting-item">
            <div>
                <div class="setting-label">Marketing Emails</div>
                <div class="setting-description">Receive promotional offers and news</div>
            </div>
            <div class="toggle-switch" onclick="toggleSetting(this)"></div>
        </div>
    </div>

    <div class="settings-section">
        <h3 style="margin: 0 0 20px 0; font-size: 18px; color: #0a0a0a;">Privacy</h3>
        
        <div class="setting-item">
            <div>
                <div class="setting-label">Profile Visibility</div>
                <div class="setting-description">Make your profile visible to other users</div>
            </div>
            <div class="toggle-switch active" onclick="toggleSetting(this)"></div>
        </div>

        <div class="setting-item">
            <div>
                <div class="setting-label">Online Status</div>
                <div class="setting-description">Show when you're online</div>
            </div>
            <div class="toggle-switch active" onclick="toggleSetting(this)"></div>
        </div>
    </div>

    <div class="settings-section">
        <h3 style="margin: 0 0 20px 0; font-size: 18px; color: #0a0a0a;">Account</h3>
        
        <div class="setting-item" onclick="window.location.href='{{ route('profile.edit') }}'">
            <div>
                <div class="setting-label">Edit Profile</div>
                <div class="setting-description">Change your profile information</div>
            </div>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18l6-6-6-6"/>
            </svg>
        </div>
    </div>

    <button class="logout-btn" onclick="handleLogout()">
        Log Out
    </button>
</div>

<script>
    function toggleSetting(element) {
        element.classList.toggle('active');
    }
</script>
@endsection