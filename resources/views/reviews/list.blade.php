@extends('layouts.home-app')

@section('title', 'Review')

@section('content')
<div style="padding: 20px 16px; background: #f8f9fa; min-height: calc(100vh - 60px); padding-bottom: 100px;">
    
    @foreach($completedOrders as $order)
        @php
            $item = $order->orderItems->first();
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
        <div style="background: white; border-radius: 16px; margin-bottom: 16px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
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
                    <div style="font-size: 14px; color: #666; margin-bottom: 12px;">
                        Variant: Childe, Raiden, The Knave
                    </div>
                    
                    <!-- Rating Stars -->
                    <div style="display: flex; align-items: center; gap: 4px;">
                        @for($i = 1; $i <= 5; $i++)
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="{{ $i <= 4 ? '#FFD700' : '#E5E7EB' }}">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        @endfor
                    </div>
                </div>
                
                <!-- Arrow -->
                <div style="display: flex; align-items: center; justify-content: center; width: 24px; height: 24px; cursor: pointer;" onclick="window.location.href='{{ route('reviews.create', $order->order_id) }}'">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="#666">
                        <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                    </svg>
                </div>
            </div>
        </div>
    @endforeach
    
    @if($completedOrders->isEmpty())
        <div style="text-align: center; padding: 40px 20px; color: #666;">
            <div style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">No Completed Orders</div>
            <div style="font-size: 14px;">You haven't completed any orders yet.</div>
        </div>
    @endif
    
</div>

<style>
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