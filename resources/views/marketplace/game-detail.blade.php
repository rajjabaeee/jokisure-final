<!-- 5026231002 | Aisya Candra Kirana Dewi (Velyven) -->
<!-- 5026231003 | Kanayya Shafa Amelia (kanayya shafa) -->

@extends('layouts.app')

@section('title', $game->game_name)

@section('content')

<div style="padding: 0;">
    {{-- Game Header --}}
    <div style="background: #fff; padding: 16px 32px; border-bottom: 1px solid #e9e9e9; margin-bottom: 16px; margin-left: -16px; margin-right: -16px;">
        <div style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 12px;">
            <img src="{{ asset('assets/' . str()->slug($game->game_name) . '.jpg') }}" alt="{{ $game->game_name }}" style="width: 120px; height: 180px; border-radius: 8px; object-fit: cover; border: 2px solid #e9e9e9; flex-shrink: 0;" onerror="this.src='{{ asset('assets/games-placeholder.jpg') }}'">
            <div style="flex: 1;">
                <h2 style="margin: 0 0 8px 0; font-weight: 700; font-size: 18px; color: #0a0a0a;">{{ $game->game_name }}</h2>
                <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                    @if($game->genres->count() > 0)
                        @foreach($game->genres as $genre)
                            <span style="font-size: 11px; padding: 3px 8px; background: #0066cc; color: #fff; border-radius: 4px; font-weight: 500;">{{ $genre->genre_name }}</span>
                        @endforeach
                    @else
                        <span style="font-size: 11px; padding: 3px 8px; background: #ccc; color: #fff; border-radius: 4px;">No genres</span>
                    @endif
                </div>
            </div>
        </div>
        <p style="margin: 0; font-size: 12px; color: #666; line-height: 1.4;">{{ $game->game_desc ?? 'No description available' }}</p>
    </div>

    <div style="padding: 0 16px;">

    {{-- Services by Type (Filter by service_name) --}}
    <div style="background: #fff; border-bottom: 1px solid #e9e9e9; padding: 16px; margin-left: -16px; margin-right: -16px; border-radius: 16px; margin-bottom: 16px;">
        <h3 style="font-weight: 600; font-size: 16px; margin: 0 0 16px 0; padding-bottom: 16px; border-bottom: 1px solid #e9e9e9;">Browse Services</h3>
        {{-- Tab Headers --}}
        <div style="display: flex; gap: 20px; margin-bottom: 16px; border-bottom: 2px solid #e9e9e9; padding-bottom: 12px;">
            <button onclick="showTab('by-booster')" id="by-booster-tab" style="background: none; border: none; padding: 0; font-weight: 600; font-size: 15px; color: #0a0a0a; cursor: pointer; position: relative;">
                By Booster
                <div id="by-booster-indicator" style="position: absolute; bottom: -12px; left: 0; right: 0; height: 3px; background: #0066cc; border-radius: 2px;"></div>
            </button>
            <button onclick="showTab('all-services')" id="all-services-tab" style="background: none; border: none; padding: 0; font-weight: 600; font-size: 15px; color: #999; cursor: pointer; position: relative;">
                All Services
                <div id="all-services-indicator" style="position: absolute; bottom: -12px; left: 0; right: 0; height: 3px; background: transparent; border-radius: 2px;"></div>
            </button>
        </div>

        {{-- All Services Tab --}}
        <div id="all-services" style="display: none;">
            {{-- Search Bar --}}
            <div style="margin-bottom: 12px;">
                <input type="text" id="serviceSearch" placeholder="Search services..." style="flex: 1; width: 100%; padding: 4px 12px; border: 2px solid #d4e4f7; border-radius: 20px; font-size: 12px; outline: none; transition: all 0.3s;" oninput="filterServices()">
            </div>

            {{-- Filter and Sort --}}
            <div style="display: flex; align-items: center; gap: 3px; margin-bottom: 16px;">
                <form method="GET" action="{{ route('games.show', $game->game_id) }}" style="display: flex; align-items: center; gap: 3px;">
                    {{-- Filter by Rating --}}
                    <select name="rating" onchange="this.form.submit()" style="padding: 3px 3px 3px 12px; border: 2px solid #d4e4f7; border-radius: 18px; font-size: 12px; cursor: pointer; background: #fff url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%228%22 height=%226%22 viewBox=%220 0 8 6%22><path fill=%22%230066cc%22 d=%22M0 0l4 6 4-6z%22/></svg>') no-repeat right 6px center; color: #0066cc; font-weight: 500; outline: none; transition: all 0.3s; appearance: none;">
                        <option value="" style="color: #999;">Filter</option>
                        <option value="diamond" {{ request('rating') == 'diamond' ? 'selected' : '' }}>Diamond (4.5+)</option>
                        <option value="gold" {{ request('rating') == 'gold' ? 'selected' : '' }}>Gold (3.5+)</option>
                        <option value="silver" {{ request('rating') == 'silver' ? 'selected' : '' }}>Silver</option>
                        <option value="bestseller" {{ request('rating') == 'bestseller' ? 'selected' : '' }}>Best Seller (4.8+)</option>
                    </select>

                    {{-- Sort By --}}
                    <select name="sort" onchange="this.form.submit()" style="padding: 3px 3px 3px 12px; border: 2px solid #d4e4f7; border-radius: 18px; font-size: 12px; cursor: pointer; background: #fff url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%228%22 height=%226%22 viewBox=%220 0 8 6%22><path fill=%22%230066cc%22 d=%22M0 0l4 6 4-6z%22/></svg>') no-repeat right 6px center; color: #0066cc; font-weight: 500; outline: none; transition: all 0.3s; appearance: none;">
                        <option value="" style="color: #999;">Sort</option>
                        <option value="rating_desc" {{ request('sort') == 'rating_desc' ? 'selected' : '' }}>Rating (High to Low)</option>
                        <option value="rating_asc" {{ request('sort') == 'rating_asc' ? 'selected' : '' }}>Rating (Low to High)</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                    </select>
                </form>
            </div>

            @if($game->services->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
                    @foreach($filteredServices as $service)
                        @php
                            // Determine service image based on service description - same logic as homepage
                            $serviceImage = 'genshin boss.png'; // default for Genshin services
                            $serviceName = strtolower($service->service_desc ?? $service->service_name ?? '');
                            
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
                        <a href="{{ route('service.detail.confirm', $service->service_id) }}" data-service-name="{{ $service->service_name }}" data-game-type="{{ $service->service_desc ?? '' }}" style="display: flex; flex-direction: column; background: #fff; border: 1px solid #e9e9e9; border-radius: 12px; overflow: hidden; text-decoration: none; color: #0a0a0a; transition: all 0.3s ease;">
                            <div style="position: relative; width: 100%; height: 120px; overflow: hidden; background: #f5f5f5;">
                                <img src="{{ asset('assets/' . $serviceImage) }}" alt="{{ $service->service_desc ?? $service->service_name }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='{{ asset('assets/genshin-impact.jpg') }}'">
                                <span style="position: absolute; top: 6px; right: 6px; font-size: 9px; padding: 2px 6px; background: #0066cc; color: #fff; border-radius: 4px; font-weight: 500;">Open</span>
                            </div>
                            <div style="padding: 10px; flex: 1; display: flex; flex-direction: column;">
                                <div style="font-weight: 600; font-size: 11px; margin-bottom: 3px; overflow: hidden; text-overflow: ellipsis; white-space: normal; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{ $service->service_name }}</div>
                                <div style="font-size: 9px; color: #666; margin-bottom: 3px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $service->service_desc ?? 'Service' }}</div>
                                <div style="font-size: 9px; color: #999; margin-bottom: 4px;">Est. {{ $service->est_time }}</div>
                                <div style="display: flex; align-items: center; gap: 6px; font-size: 9px; color: #666; margin-bottom: 4px;">
                                    <img src="{{ asset('assets/' . str()->slug($service->booster->user->user_name) . '.jpg') }}" alt="{{ $service->booster->user->user_name }}" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover; flex-shrink: 0;" onerror="this.src='{{ asset('assets/avatar-placeholder.jpg') }}'">
                                    <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $service->booster->user->user_name }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                                    <div style="font-size: 9px; color: #ffc107;">★ {{ number_format($service->service_rating, 1) }}</div>
                                    <span style="font-weight: 700; font-size: 10px; color: #0066cc;">Rp{{ number_format($service->service_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p style="color: #999; text-align: center; padding: 20px 0;">No services available for this game</p>
            @endif
        </div>

        {{-- By Booster Tab --}}
        <div id="by-booster" style="display: block;">
            {{-- Search Bar --}}
            <div style="margin-bottom: 12px;">
                <input type="text" id="boosterSearch" placeholder="Search booster..." style="flex: 1; width: 100%; padding: 4px 12px; border: 2px solid #d4e4f7; border-radius: 20px; font-size: 12px; outline: none; transition: all 0.3s;" oninput="filterBoosters()">
            </div>

            {{-- Filter and Sort --}}
            <div style="display: flex; align-items: center; gap: 3px; margin-bottom: 16px;">
                <form method="GET" action="{{ route('games.show', $game->game_id) }}" style="display: flex; align-items: center; gap: 3px;">
                    {{-- Filter by Rating --}}
                    <select name="rating" onchange="this.form.submit()" style="padding: 3px 3px 3px 12px; border: 2px solid #d4e4f7; border-radius: 18px; font-size: 12px; cursor: pointer; background: #fff url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%228%22 height=%226%22 viewBox=%220 0 8 6%22><path fill=%22%230066cc%22 d=%22M0 0l4 6 4-6z%22/></svg>') no-repeat right 6px center; color: #0066cc; font-weight: 500; outline: none; transition: all 0.3s; appearance: none;">
                        <option value="" style="color: #999;">Filter</option>
                        <option value="diamond" {{ request('rating') == 'diamond' ? 'selected' : '' }}>Diamond (4.5+)</option>
                        <option value="gold" {{ request('rating') == 'gold' ? 'selected' : '' }}>Gold (3.5+)</option>
                        <option value="silver" {{ request('rating') == 'silver' ? 'selected' : '' }}>Silver</option>
                        <option value="bestseller" {{ request('rating') == 'bestseller' ? 'selected' : '' }}>Best Seller (4.8+)</option>
                    </select>

                    {{-- Sort By --}}
                    <select name="sort" onchange="this.form.submit()" style="padding: 3px 3px 3px 12px; border: 2px solid #d4e4f7; border-radius: 18px; font-size: 12px; cursor: pointer; background: #fff url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%228%22 height=%226%22 viewBox=%220 0 8 6%22><path fill=%22%230066cc%22 d=%22M0 0l4 6 4-6z%22/></svg>') no-repeat right 6px center; color: #0066cc; font-weight: 500; outline: none; transition: all 0.3s; appearance: none;">
                        <option value="" style="color: #999;">Sort</option>
                        <option value="rating_desc" {{ request('sort') == 'rating_desc' ? 'selected' : '' }}>Rating (High to Low)</option>
                        <option value="rating_asc" {{ request('sort') == 'rating_asc' ? 'selected' : '' }}>Rating (Low to High)</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                    </select>
                </form>
            </div>

            @if($filteredBoosters->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($filteredBoosters as $booster)
                        <a href="{{ route('booster.profile', ['booster' => $booster->booster_id, 'referrer' => 'game']) }}" data-booster-name="{{ $booster->user->user_name }}" style="display: flex; background: linear-gradient(135deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.3) 100%), url('{{ asset('assets/' . str()->slug($booster->user->user_name) . '-bg.jpg') }}') center/cover; border: 1px solid #e9e9e9; border-radius: 16px; padding: 12px; gap: 12px; text-decoration: none; color: #0a0a0a; align-items: center; transition: all 0.3s ease;">
                            <img src="{{ asset('assets/' . str()->slug($booster->user->user_name) . '.jpg') }}" alt="{{ $booster->user->user_name }}" style="width: 80px; height: 80px; border-radius: 12px; object-fit: cover; flex-shrink: 0;" onerror="this.src='{{ asset('assets/avatar-placeholder.jpg') }}'">
                            <div style="flex: 1; min-width: 0;">
                                <div style="margin-bottom: 4px;">
                                    @if($booster->booster_rating >= 4.5)
                                        <span style="font-size: 10px; padding: 3px 8px; background: #ffc107; color: #000; border-radius: 4px; margin-right: 6px; display: inline-block;">Diamond Booster</span>
                                    @elseif($booster->booster_rating >= 3.5)
                                        <span style="font-size: 10px; padding: 3px 8px; background: #c0c0c0; color: #000; border-radius: 4px; margin-right: 6px; display: inline-block;">Gold Booster</span>
                                    @else
                                        <span style="font-size: 10px; padding: 3px 8px; background: #cd7f32; color: #fff; border-radius: 4px; margin-right: 6px; display: inline-block;">Silver Booster</span>
                                    @endif
                                    @if($booster->booster_rating >= 4.8)
                                        <span style="font-size: 10px; padding: 3px 8px; background: #0066cc; color: #fff; border-radius: 4px; display: inline-block;">Best Seller</span>
                                    @endif
                                </div>
                                <div style="font-weight: 600; font-size: 14px; margin: 4px 0; display: flex; align-items: center; gap: 4px; color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                    {{ $booster->user->user_name }}
                                    @if($booster->verified)
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" title="Verified">
                                          <circle cx="12" cy="12" r="10" fill="#1DA1F2"/>
                                          <path d="M7 12.5l3 3 7-7" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    @endif
                                </div>
                                <div style="font-size: 11px; color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">★ {{ number_format($booster->booster_rating, 1) }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p style="color: #999; text-align: center; padding: 20px 0;">No boosters available for this game</p>
            @endif
        </div>
        </div>

    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tabs
    document.getElementById('all-services').style.display = 'none';
    document.getElementById('by-booster').style.display = 'none';
    
    // Remove indicators
    document.getElementById('all-services-indicator').style.background = 'transparent';
    document.getElementById('by-booster-indicator').style.background = 'transparent';
    
    // Reset tab colors
    document.getElementById('all-services-tab').style.color = '#999';
    document.getElementById('by-booster-tab').style.color = '#999';
    
    // Show selected tab
    document.getElementById(tabName).style.display = 'block';
    
    // Add indicator and color to active tab
    if (tabName === 'all-services') {
        document.getElementById('all-services-indicator').style.background = '#0066cc';
        document.getElementById('all-services-tab').style.color = '#0a0a0a';
    } else {
        document.getElementById('by-booster-indicator').style.background = '#0066cc';
        document.getElementById('by-booster-tab').style.color = '#0a0a0a';
    }
}

// Filter services in real-time
function filterServices() {
    const searchInput = document.getElementById('serviceSearch');
    const filter = searchInput.value.toLowerCase().trim();
    const services = document.querySelectorAll('[data-service-name]');
    
    services.forEach(service => {
        const serviceName = service.getAttribute('data-service-name').toLowerCase();
        const gameType = service.getAttribute('data-game-type').toLowerCase();
        
        if (serviceName.includes(filter) || gameType.includes(filter) || filter === '') {
            service.style.display = '';
        } else {
            service.style.display = 'none';
        }
    });
}

// Filter boosters in real-time
function filterBoosters() {
    const searchInput = document.getElementById('boosterSearch');
    const filter = searchInput.value.toLowerCase().trim();
    const boosters = document.querySelectorAll('[data-booster-name]');
    
    boosters.forEach(booster => {
        const boosterName = booster.getAttribute('data-booster-name').toLowerCase();
        
        if (boosterName.includes(filter) || filter === '') {
            booster.style.display = 'flex';
        } else {
            booster.style.display = 'none';
        }
    });
}
</script>
@endsection
