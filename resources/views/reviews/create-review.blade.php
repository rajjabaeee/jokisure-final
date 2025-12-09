<!-- 5026231002 | Aisya Candra Kirana Dewi (Velyven) -->
<!-- 5026231057 | Siti Qalimatus Zahra (SitiQalimatusZahra) -->

@extends('layouts.app')

@section('title', 'Write Review')

@section('content')
<style>
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: flex-end;
        z-index: 999;
    }

    .review-modal {
        background: white;
        border-radius: 24px 24px 0 0;
        padding: 24px;
        width: 100%;
        max-width: 375px;
        max-height: 66.67vh;
        overflow-y: auto;
        box-shadow: 0 -4px 16px rgba(0, 0, 0, 0.1);
        animation: slideUp 0.3s ease;
    }

    @keyframes slideUp {
        from {
            transform: translateY(100%);
        }
        to {
            transform: translateY(0);
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        position: relative;
    }

    .modal-close {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 40px;
        height: 40px;
        background: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        font-size: 24px;
        color: #999;
    }

    .modal-close:hover {
        background: #f0f0f0;
    }

    .service-header {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f0f0f0;
    }

    .service-image {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .service-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .service-date {
        font-size: 12px;
        color: #999;
        margin-bottom: 4px;
    }

    .service-title {
        font-size: 16px;
        font-weight: 700;
        color: #000;
        margin-bottom: 4px;
    }

    .service-variant {
        font-size: 12px;
        color: #666;
    }

    .rating-section {
        margin-bottom: 24px;
    }

    .rating-label {
        font-size: 12px;
        color: #999;
        margin-bottom: 8px;
        display: block;
    }

    .rating-stars {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .rating-star {
        width: 40px;
        height: 40px;
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .rating-star svg {
        width: 32px;
        height: 32px;
        transition: transform 0.2s;
    }

    .rating-star:hover svg {
        transform: scale(1.1);
    }

    .form-section {
        margin-bottom: 20px;
    }

    .form-label {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }

    .form-textarea {
        width: 100%;
        min-height: 120px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px;
        font-family: inherit;
        font-size: 14px;
        resize: vertical;
        box-sizing: border-box;
    }

    .form-textarea::placeholder {
        color: #ccc;
    }

    .form-textarea:focus {
        outline: none;
        border-color: #007aff;
    }

    .photos-area {
        width: 100%;
        height: 100px;
        border: 2px dashed #e0e0e0;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.2s;
        background: #f9f9f9;
    }

    .photos-area:hover {
        background: #f0f0f0;
        border-color: #d0d0d0;
    }

    .photos-placeholder {
        text-align: center;
        color: #999;
    }

    .photos-icon {
        font-size: 32px;
        margin-bottom: 8px;
    }

    .photos-text {
        font-size: 13px;
    }

    .submit-btn {
        width: 100%;
        background: #ff3b6d;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 8px;
    }

    .submit-btn:hover {
        background: #e8306a;
    }

    .submit-btn:active {
        transform: scale(0.98);
    }
</style>

<div class="overlay">
    <div class="review-modal">
        <!-- Modal Header -->
        <div class="modal-header">
            <a href="{{ route('reviews') }}" class="modal-close" style="text-decoration: none; color: #999;">✕</a>
        </div>

        <!-- Service Header -->
        @php
            $service = $item->service;
            $game = $service->game;
            
            // Determine service image
            $serviceImage = 'genshin boss.png';
            $serviceName = strtolower($service->service_desc ?? '');
            
            if (str_contains($serviceName, 'natlan')) {
                $serviceImage = 'Natlan.png';
            } elseif (str_contains($serviceName, 'inazuma')) {
                $serviceImage = 'Inazuma.png';
            } elseif (str_contains($serviceName, 'sumeru')) {
                $serviceImage = 'Sumeru.png';
            } elseif (str_contains($serviceName, 'fontaine')) {
                $serviceImage = 'fontaine.png';
            } elseif (str_contains($serviceName, 'liyue')) {
                $serviceImage = 'liyue.png';
            } elseif (str_contains($serviceName, 'mondstadt')) {
                $serviceImage = 'Monstandt.png';
            } elseif (str_contains($serviceName, 'dragonspine')) {
                $serviceImage = 'Dragonspine.png';
            } elseif (str_contains($serviceName, 'enkanomiya')) {
                $serviceImage = 'enkanomiya.png';
            } elseif (str_contains($serviceName, 'chasm')) {
                $serviceImage = 'Chasm.png';
            } elseif (str_contains($serviceName, 'weekly') || str_contains($serviceName, 'boss')) {
                $serviceImage = 'genshin boss.png';
            } elseif (str_contains($serviceName, 'abyss')) {
                $serviceImage = 'abyss.jpg';
            }
        @endphp

        <div class="service-header">
            <img src="{{ asset('assets/' . $serviceImage) }}" class="service-image" alt="{{ $service->service_name }}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2280%22 height=%2280%22%3E%3Crect fill=%22%23f0f0f0%22 width=%2280%22 height=%2280%22/%3E%3C/svg%3E'">
            <div class="service-info">
                <div class="service-date">{{ $order->created_at ? $order->created_at->format('d M Y') : 'N/A' }}</div>
                <div class="service-title">{{ $game->game_name }}</div>
                <div class="service-variant">{{ $service->service_name }}</div>
            </div>
        </div>

        <!-- Review Form -->
        <form action="{{ route('reviews.store', $order->order_id) }}" method="POST" id="reviewForm">
            @csrf

            <!-- Rating Section -->
            <div class="rating-section">
                <label class="rating-label">Rating</label>
                <div class="rating-stars" id="ratingStars">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" class="rating-star" data-rating="{{ $i }}" onclick="setRating({{ $i }}, event)">
                            <svg viewBox="0 0 24 24" fill="#FFD700" stroke="none">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </button>
                    @endfor
                </div>
                <input type="hidden" id="rating" name="user_rating" value="0">
            </div>

            <!-- Review Text Section -->
            <div class="form-section">
                <label class="form-label">Write your review</label>
                <textarea class="form-textarea" name="user_review" placeholder="Your Review" required></textarea>
            </div>

            <!-- Photos Section -->
            <div class="form-section">
                <label class="form-label">Add your photos</label>
                <div class="photos-area" onclick="document.getElementById('photoInput').click();">
                    <div class="photos-placeholder">
                        <div class="photos-icon">📷</div>
                        <div class="photos-text">Photos or videos</div>
                    </div>
                </div>
                <input type="file" id="photoInput" multiple accept="image/*,video/*" style="display: none;">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">Send Review</button>
        </form>
    </div>
</div>

<script>
    let selectedRating = 0;

    function setRating(rating, event) {
        event.preventDefault();
        selectedRating = rating;
        document.getElementById('rating').value = rating;
        
        // Update star visual state
        document.querySelectorAll('.rating-star').forEach((star, index) => {
            if (index < rating) {
                star.style.opacity = '1';
            } else {
                star.style.opacity = '0.3';
            }
        });
    }

    // Prevent body scroll when modal is open
    document.body.style.overflow = 'hidden';

    // Handle form submission validation
    document.getElementById('reviewForm').addEventListener('submit', function(e) {
        // Validate rating is selected
        if (!selectedRating || selectedRating === 0) {
            e.preventDefault();
            alert('Please select a rating before submitting');
            return false;
        }
        // Allow form to submit normally - controller will handle redirect
    });

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        document.body.style.overflow = 'auto';
    });
</script>
