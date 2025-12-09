@extends('layouts.home-app')

@section('title', 'Review')

@section('content')
<div style="padding: 20px 16px; background: #f8f9fa; min-height: calc(100vh - 60px); padding-bottom: 100px;">
    
    @php
        $service = $item->service;
        $game = $service->game;
        $booster = $service->booster;
        
        // Determine service image based on service description
        $serviceImage = 'genshin boss.png'; // default for Genshin services
        $serviceName = strtolower($service->service_desc);
        
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
    
    <!-- Review Card -->
    <div style="background: white; border-radius: 16px; margin-bottom: 24px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: flex-start; gap: 12px;">
            <!-- Service Image -->
            <img src="{{ asset('assets/' . $serviceImage) }}" alt="{{ $service->service_desc }}" 
                 style="width: 60px; height: 60px; border-radius: 12px; object-fit: cover; flex-shrink: 0;">
            
            <!-- Content -->
            <div style="flex: 1; min-width: 0;">
                <!-- Date -->
                <div style="font-size: 13px; color: #666; margin-bottom: 4px;">
                    {{ $order->created_at->format('d M Y') }}
                </div>
                
                <!-- Service Title -->
                <div style="font-size: 16px; font-weight: 600; color: #000; margin-bottom: 4px;">
                    {{ $game->game_name }} {{ $service->service_desc }}
                </div>
                
                <!-- Variant -->
                <div style="font-size: 14px; color: #666;">
                    Variant: Childe, Raiden, The Knave
                </div>
            </div>
        </div>
    </div>
    
    <!-- Review Form -->
    <form method="POST" action="{{ route('reviews.store', $order->order_id) }}">
        @csrf
        
        <!-- Rating Section -->
        <div style="background: white; border-radius: 16px; margin-bottom: 16px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <div style="font-size: 16px; font-weight: 600; color: #000; margin-bottom: 16px;">Rate this service</div>
            
            <!-- Star Rating -->
            <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 20px;">
                @for($i = 1; $i <= 5; $i++)
                    <label for="rating-{{ $i }}" style="cursor: pointer;">
                        <input type="radio" id="rating-{{ $i }}" name="rating" value="{{ $i }}" style="display: none;" onchange="updateStarRating({{ $i }})">
                        <svg class="star-icon" data-rating="{{ $i }}" width="32" height="32" viewBox="0 0 24 24" fill="#E5E7EB" onclick="selectRating({{ $i }})">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </label>
                @endfor
            </div>
            
            <!-- Review Text Area -->
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 500; color: #000; margin-bottom: 8px;">Write your review</label>
                <textarea name="review" placeholder="Share your experience with this service..." 
                          style="width: 100%; min-height: 100px; border: 1px solid #e9ecef; border-radius: 8px; padding: 12px; font-size: 14px; resize: vertical; font-family: inherit;" 
                          required></textarea>
            </div>
        </div>
        
        <!-- Submit Button -->
        <button type="submit" 
                style="width: 100%; background: #007aff; color: white; border: none; padding: 16px; border-radius: 12px; font-size: 16px; font-weight: 600; cursor: pointer; margin-bottom: 20px;">
            Submit Review
        </button>
    </form>
    
</div>

<script>
let selectedRating = 0;

function selectRating(rating) {
    selectedRating = rating;
    updateStarRating(rating);
    document.querySelector('input[name="rating"][value="' + rating + '"]').checked = true;
}

function updateStarRating(rating) {
    const stars = document.querySelectorAll('.star-icon');
    stars.forEach((star, index) => {
        if (index < rating) {
            star.setAttribute('fill', '#FFD700');
        } else {
            star.setAttribute('fill', '#E5E7EB');
        }
    });
}
</script>

<style>
    .star-icon {
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .star-icon:hover {
        transform: scale(1.1);
    }
    
    /* Mobile optimizations */
    @media (max-width: 768px) {
        .device-frame {
            overflow: hidden !important;
        }
        
        .safe-area {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 60px !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }
        
        .navbar {
            position: fixed !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 1000 !important;
        }
    }
</style>
@endsection

                <button type="button" class="btn-close-absolute" onclick="closeReviewModal()">
                    <i class="bi bi-x"></i>
                </button>

                <form action="{{ route('reviews.store', $order->order_id) }}" method="POST">
                    @csrf

                    <div class="d-flex align-items-center mb-4 mt-2">
                        @php
                            // Get service-specific image based on content
                            $serviceContent = strtolower(($item->service->service_name ?? '') . ' ' . ($item->service->service_desc ?? ''));
                            
                            if (str_contains($serviceContent, 'abyss')) {
                                $imageName = 'abyss.jpg';
                            } elseif (str_contains($serviceContent, 'natlan')) {
                                $imageName = 'natlan.jpg';
                            } elseif (str_contains($serviceContent, 'inazuma')) {
                                $imageName = 'inazuma.jpg';
                            } elseif (str_contains($serviceContent, 'liyue')) {
                                $imageName = 'liyue.jpg';
                            } elseif (str_contains($serviceContent, 'mondstadt')) {
                                $imageName = 'Monstandt.png';
                            } elseif (str_contains($serviceContent, 'fontaine')) {
                                $imageName = 'fontaine.jpg';
                            } elseif (str_contains($serviceContent, 'sumeru')) {
                                $imageName = 'sumeru.jpg';
                            } elseif (str_contains($serviceContent, 'enkanomiya')) {
                                $imageName = 'enkanomiya.jpg';
                            } elseif (str_contains($serviceContent, 'dragonspine')) {
                                $imageName = 'dragonspine.jpg';
                            } elseif (str_contains($serviceContent, 'chasm')) {
                                $imageName = 'chasm.jpg';
                            } else {
                                $imageName = 'default-thumb.png';
                            }
                        @endphp
                        <img src="{{ asset('assets/' . $imageName) }}" class="modal-service-img">
                        <div>
                            <div class="modal-service-title">{{ $item->service->game->game_name }}</div>
                            <div class="modal-service-variant text-muted">Variant: {{ $item->service->service_desc }}</div>
                        </div>
                    </div>

                    <div class="text-center mb-2">
                        <span class="fw-bold small text-secondary">Tap stars to rate</span>
                    </div>
                    <div class="star-rating">
                        <input type="radio" id="star5" name="rating" value="5" required /><label for="star5"></label>
                        <input type="radio" id="star4" name="rating" value="4" /><label for="star4"></label>
                        <input type="radio" id="star3" name="rating" value="3" /><label for="star3"></label>
                        <input type="radio" id="star2" name="rating" value="2" /><label for="star2"></label>
                        <input type="radio" id="star1" name="rating" value="1" /><label for="star1"></label>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-bold">Write your review</label>
                        <textarea name="review" class="form-control-custom" rows="4" placeholder="Share your experience with this booster..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-bold">Add photos</label>
                        <div class="photo-upload-box">
                            <div class="text-center">
                                <i class="bi bi-camera fs-5"></i>
                                <span class="ms-2 small">Upload Photos</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-send-review">Submit Review</button>

                    <div style="height: 20px;"></div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function openReviewModal() {
            var modal = document.getElementById('mobileReviewModal');
            modal.style.display = 'flex';
            setTimeout(() => {
                modal.classList.add('active');
            }, 10);
        }

        function closeReviewModal() {
            var modal = document.getElementById('mobileReviewModal');
            modal.classList.remove('active');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }
    </script>
@endsection