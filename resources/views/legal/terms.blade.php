@extends('layouts.home-app')

@section('content')
<style>
    .terms-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .terms-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .terms-content {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        line-height: 1.6;
    }

    .terms-content h2 {
        color: #0a0a0a;
        margin: 25px 0 15px 0;
        font-size: 20px;
    }

    .terms-content h3 {
        color: #333;
        margin: 20px 0 10px 0;
        font-size: 18px;
    }

    .terms-content p {
        color: #666;
        margin-bottom: 15px;
    }

    .terms-content ul {
        color: #666;
        padding-left: 20px;
    }

    .terms-content li {
        margin-bottom: 8px;
    }
</style>

<div class="terms-container">
    <div class="terms-header">
        <h1>Terms of Service</h1>
        <p style="color: #666; margin: 8px 0 0 0;">Last updated: January 2024</p>
    </div>

    <div class="terms-content">
        <h2>1. Acceptance of Terms</h2>
        <p>By accessing and using JokiSure, you accept and agree to be bound by the terms and provision of this agreement.</p>

        <h2>2. Service Description</h2>
        <p>JokiSure is a marketplace platform that connects users with professional game boosters and gaming services. We provide:</p>
        <ul>
            <li>Game boosting services</li>
            <li>Account leveling</li>
            <li>Achievement unlocking</li>
            <li>Rank pushing</li>
            <li>Item farming</li>
        </ul>

        <h2>3. User Accounts</h2>
        <p>When you create an account with us, you must provide information that is accurate, complete, and current at all times. You are responsible for safeguarding the password and for all activities that occur under your account.</p>

        <h2>4. Payment and Pricing</h2>
        <p>Payment is required before services are rendered. All prices are in Indonesian Rupiah (IDR). We accept various payment methods including bank transfers and digital wallets.</p>

        <h2>5. Service Quality</h2>
        <p>We strive to ensure high-quality services from our boosters. However, we cannot guarantee specific results or outcomes in games.</p>

        <h2>6. Privacy and Security</h2>
        <p>Your privacy is important to us. We implement security measures to protect your account information and gaming credentials.</p>

        <h2>7. Prohibited Uses</h2>
        <p>You may not use our service for any illegal or unauthorized purpose. You agree to comply with all laws, rules, and regulations applicable to your use of the service.</p>

        <h2>8. Limitation of Liability</h2>
        <p>JokiSure shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use of the service.</p>

        <h2>9. Termination</h2>
        <p>We may terminate or suspend your account immediately, without prior notice or liability, for any reason whatsoever, including breach of the Terms.</p>

        <h2>10. Contact Information</h2>
        <p>If you have any questions about these Terms of Service, please contact us through our support channels.</p>
    </div>
</div>
@endsection