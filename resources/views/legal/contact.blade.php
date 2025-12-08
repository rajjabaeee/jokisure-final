@extends('layouts.home-app')

@section('content')
<style>
    .contact-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
    }

    .contact-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .contact-info {
        background: white;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .contact-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .contact-item:last-child {
        border-bottom: none;
    }

    .contact-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }

    .contact-details h3 {
        margin: 0 0 5px 0;
        font-size: 16px;
        color: #0a0a0a;
    }

    .contact-details p {
        margin: 0;
        color: #666;
        font-size: 14px;
    }

    .contact-form {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-size: 16px;
        font-weight: 500;
        color: #0a0a0a;
    }

    .form-input, .form-textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #f0f0f0;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s;
        box-sizing: border-box;
    }

    .form-input:focus, .form-textarea:focus {
        outline: none;
        border-color: #667eea;
    }

    .form-textarea {
        height: 120px;
        resize: vertical;
    }

    .submit-btn {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 20px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        margin-top: 10px;
    }

    .submit-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
</style>

<div class="contact-container">
    <div class="contact-header">
        <h1>Contact Us</h1>
        <p style="color: #666; margin: 8px 0 0 0;">We're here to help! Reach out to us anytime.</p>
    </div>

    <div class="contact-info">
        <div class="contact-item">
            <div class="contact-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
            </div>
            <div class="contact-details">
                <h3>Email Support</h3>
                <p>support@jokisure.com</p>
                <p>We typically respond within 24 hours</p>
            </div>
        </div>

        <div class="contact-item">
            <div class="contact-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
                </svg>
            </div>
            <div class="contact-details">
                <h3>WhatsApp Support</h3>
                <p>+62 812-3456-7890</p>
                <p>Available 24/7 for urgent matters</p>
            </div>
        </div>

        <div class="contact-item">
            <div class="contact-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
            </div>
            <div class="contact-details">
                <h3>Office Location</h3>
                <p>Jakarta, Indonesia</p>
                <p>Monday - Friday, 9:00 AM - 6:00 PM WIB</p>
            </div>
        </div>
    </div>

    <div class="contact-form">
        <h2 style="margin: 0 0 20px 0; text-align: center; color: #0a0a0a;">Send us a Message</h2>
        
        <form action="#" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="subject">Subject</label>
                <input type="text" id="subject" name="subject" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="message">Message</label>
                <textarea id="message" name="message" class="form-textarea" required placeholder="Tell us how we can help you..."></textarea>
            </div>

            <button type="submit" class="submit-btn">Send Message</button>
        </form>
    </div>
</div>
@endsection