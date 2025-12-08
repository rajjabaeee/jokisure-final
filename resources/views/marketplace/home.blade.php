@extends('layouts.home-app')

@section('title', 'Home')

@section('content')
    <!-- BODY -->
    <div class="px-2 pb-5">

      <!-- Banner Slider -->
      <div style="position: relative; margin-top: 12px; margin-bottom: 16px;">
        <div class="banner-slider" style="overflow: hidden; border-radius: 14px; position: relative; width: 100%; height: 140px;" id="bannerSlider">
          <div class="banner-track" style="display: flex; transition: transform 0.5s ease-in-out; width: 100%; height: 100%;" id="bannerTrack">
            <div style="min-width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; overflow: hidden;">
              <img src="{{ asset('assets/hsrnewver.jpg') }}" class="w-100 h-100" alt="Banner 1" style="object-fit: cover;">
            </div>
            <div style="min-width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; overflow: hidden;">
              <img src="{{ asset('assets/pgrdmccollab.jpg') }}" class="w-100 h-100" alt="Banner 2" style="object-fit: cover; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" onerror="this.style.display='none'">
            </div>
            <div style="min-width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; overflow: hidden;">
              <img src="{{ asset('assets/akevent.jpg') }}" class="w-100 h-100" alt="Banner 3" style="object-fit: cover; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);" onerror="this.style.display='none'">
            </div>
          </div>

          <!-- Banner Navigation Buttons -->
          <button onclick="slideBanner('left')" style="position: absolute; left: 8px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.7); border: none; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10; padding: 0; transition: background 0.3s;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 19l-7-7 7-7"/></svg>
          </button>
          <button onclick="slideBanner('right')" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.7); border: none; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10; padding: 0; transition: background 0.3s;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 19l7-7-7-7"/></svg>
          </button>

          <!-- Banner Indicators -->
          <div style="position: absolute; bottom: 8px; left: 50%; transform: translateX(-50%); display: flex; gap: 6px; z-index: 10;">
            <span class="banner-indicator" data-index="0" style="width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.8); cursor: pointer; transition: all 0.3s;" onclick="goToBanner(0)"></span>
            <span class="banner-indicator" data-index="1" style="width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.4); cursor: pointer; transition: all 0.3s;" onclick="goToBanner(1)"></span>
            <span class="banner-indicator" data-index="2" style="width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.4); cursor: pointer; transition: all 0.3s;" onclick="goToBanner(2)"></span>
          </div>
        </div>
      </div>

      <!-- Boost Games Section - GRID 3x2 -->
      <div style="background: #fff; border-radius: 16px; padding: 16px; margin-bottom: 16px; border: 1px solid #e9e9e9;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
          <div style="font-weight: 600; font-size: 16px;">Boost Games</div>
          <a href="{{ route('games.index') }}" style="display: flex; align-items: center; gap: 4px; text-decoration: none; color: #000000; font-size: 12px; font-weight: 500;">
             
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
          </a>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
        @if($games->count() > 0)
          @foreach ($games->take(6) as $game)
            <a href="{{ route('games.show', $game->game_id) }}" style="display: flex; flex-direction: column; border-radius: 12px; overflow: hidden; background: #fff; border: 1px solid #e9e9e9; text-decoration: none; color: #0a0a0a; transition: all 0.3s ease;">
              <div style="width: 100%; height: 100px; overflow: hidden; background: #f5f5f5;">
                <img src="{{ asset('assets/' . str()->slug($game->game_name) . '.jpg') }}" alt="{{ $game->game_name }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='{{ asset('assets/games-placeholder.jpg') }}'">
              </div>
              <div style="padding: 10px; text-align: center; flex: 1; display: flex; align-items: center; justify-content: center;">
                <span style="font-size: 13px; font-weight: 600; line-height: 1.3;">{{ $game->game_name }}</span>
              </div>
            </a>
          @endforeach
        @else
          <p style="color: #999; grid-column: 1 / -1;">Tidak ada games tersedia</p>
        @endif
        </div>
      </div>

      <!-- Featured Boosters - GRID 3x1 -->
      <div style="background: #fff; border-radius: 16px; padding: 16px; margin-bottom: 16px; border: 1px solid #e9e9e9;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
          <div style="font-weight: 600; font-size: 16px;">Featured Boosters</div>
          <a href="{{ route('boosters') }}" style="display: flex; align-items: center; gap: 4px; text-decoration: none; color: #000000; font-size: 12px; font-weight: 500;">
             
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
          </a>
        </div>
        <div style="display: flex; flex-direction: column; gap: 12px;">
        @if($featuredBoosters->count() > 0)
          @foreach ($featuredBoosters->take(3) as $b)
            @php
              // Skip boosters without profile pictures (like aisya, account baru, Mochi)
              $hasProfilePic = in_array(str()->slug($b->user_name), ['bangboost', 'sealw', 'monkeyd']);
            @endphp
            @if($hasProfilePic)
            <a href="{{ route('booster.profile', ['booster' => $b->booster_id, 'referrer' => 'home']) }}" style="display: flex; background: linear-gradient(135deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.3) 100%), url('{{ asset('assets/' . str()->slug($b->user_name) . '-bg.jpg') }}') center/cover; border: 1px solid #e9e9e9; border-radius: 16px; padding: 12px; gap: 12px; text-decoration: none; color: #0a0a0a; align-items: center; transition: all 0.3s ease;">
              <img src="{{ asset('assets/' . str()->slug($b->user_name) . '.jpg') }}" alt="{{ $b->user_name }}" style="width: 80px; height: 80px; border-radius: 12px; object-fit: cover; flex-shrink: 0;" onerror="this.src='{{ asset('assets/avatar-placeholder.jpg') }}'">>
              <div style="flex: 1; min-width: 0;">
                <div style="margin-bottom: 4px;">
                  @if($b->user_rating >= 4.5)
                    <span style="font-size: 10px; padding: 3px 8px; background: #ffc107; color: #000; border-radius: 4px; margin-right: 6px; display: inline-block;">Diamond Booster</span>
                  @elseif($b->user_rating >= 3.5)
                    <span style="font-size: 10px; padding: 3px 8px; background: #c0c0c0; color: #000; border-radius: 4px; margin-right: 6px; display: inline-block;">Gold Booster</span>
                  @else
                    <span style="font-size: 10px; padding: 3px 8px; background: #cd7f32; color: #fff; border-radius: 4px; margin-right: 6px; display: inline-block;">Silver Booster</span>
                  @endif
                  @if($b->user_rating >= 4.8)
                    <span style="font-size: 10px; padding: 3px 8px; background: #0066cc; color: #fff; border-radius: 4px; display: inline-block;">Best Seller</span>
                  @endif
                </div>
                <div style="font-weight: 600; font-size: 14px; margin: 4px 0; display: flex; align-items: center; gap: 4px; color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                  {{ $b->user_name }}
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="#0066cc"><path d="M10.5 1.5H4.605c-.606 0-1.122.233-1.5.612-.389.378-.605.894-.605 1.5v16.776c0 .606.233 1.122.612 1.5.378.389.894.605 1.5.605h14.776c.606 0 1.122-.233 1.5-.612.389-.378.605-.894.605-1.5V11.5M10.5 1.5v8m0-8L21 10.5m-10.5-9h8.25"/></svg>
                </div>
                <div style="font-size: 11px; color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">★ {{ number_format($b->user_rating, 1) }}</div>
              </div>
            </a>
            @endif
          @endforeach
        @else
          <p style="color: #999;">Tidak ada booster tersedia</p>
        @endif
        </div>
      </div>

      <!-- For You Section - Grid 2 Kolom -->
      <div style="background: #fff; border-radius: 16px; padding: 16px; margin-bottom: 16px; border: 1px solid #e9e9e9;">
        <div style="font-weight: 600; font-size: 16px; margin-bottom: 12px;">For You</div>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
        @if($services->count() > 0)
          @foreach ($services as $service)
            @php
              // Function to match service description with appropriate image
              $serviceImage = 'genshin-impact.jpg'; // default
              $description = strtolower($service->service_desc ?? '');
              
              // Match keywords in description with available images
              if (str_contains($description, 'mondstadt')) {
                $serviceImage = 'Monstandt.png';
              } elseif (str_contains($description, 'liyue')) {
                $serviceImage = 'liyue.png';
              } elseif (str_contains($description, 'inazuma')) {
                $serviceImage = 'Inazuma.png';
              } elseif (str_contains($description, 'sumeru')) {
                $serviceImage = 'Sumeru.png';
              } elseif (str_contains($description, 'fontaine')) {
                $serviceImage = 'fontaine.png';
              } elseif (str_contains($description, 'natlan')) {
                $serviceImage = 'Natlan.png';
              } elseif (str_contains($description, 'dragonspine')) {
                $serviceImage = 'Dragonspine.png';
              } elseif (str_contains($description, 'enkanomiya')) {
                $serviceImage = 'enkanomiya.png';
              } elseif (str_contains($description, 'chasm')) {
                $serviceImage = 'Chasm.png';
              } elseif (str_contains($description, 'abyss')) {
                $serviceImage = 'abyss.jpg';
              } elseif (str_contains($description, 'childe')) {
                $serviceImage = 'childe.jpg';
              } else {
                // Use game-specific image as fallback
                $serviceImage = str()->slug($service->game_name) . '.jpg';
              }
            @endphp
            <a href="{{ route('service.detail.confirm', $service->service_id) }}" style="display: flex; flex-direction: column; background: #fff; border: 1px solid #e9e9e9; border-radius: 12px; overflow: hidden; text-decoration: none; color: #0a0a0a; transition: all 0.3s ease;">
              <div style="position: relative; width: 100%; height: 120px; overflow: hidden; background: #f5f5f5;">
                <img src="{{ asset('assets/' . $serviceImage) }}" alt="{{ $service->service_desc }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='{{ asset('assets/' . str()->slug($service->game_name) . '.jpg') }}'">
                <span style="position: absolute; top: 6px; right: 6px; font-size: 9px; padding: 2px 6px; background: #0066cc; color: #fff; border-radius: 4px; font-weight: 500;">Open</span>
              </div>
              <div style="padding: 10px; flex: 1; display: flex; flex-direction: column;">
                <div style="font-weight: 600; font-size: 11px; margin-bottom: 3px; overflow: hidden; text-overflow: ellipsis; white-space: normal; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{ $service->game_name }}</div>
                <div style="font-size: 9px; color: #666; margin-bottom: 3px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $service->service_desc ?? 'Service' }}</div>
                <div style="font-size: 9px; color: #999; margin-bottom: 4px;">Est. {{ $service->est_time }}</div>
                <div style="display: flex; align-items: center; gap: 6px; font-size: 9px; color: #666; margin-bottom: 4px;">
                  @php
                    // Match booster name with available profile pictures
                    $boosterImage = 'Tamago.jpg'; // default
                    $boosterName = strtolower($service->booster_name ?? '');
                    
                    if (str_contains($boosterName, 'monkeyd')) {
                      $boosterImage = 'monkeyd.jpg';
                    } elseif (str_contains($boosterName, 'skullface')) {
                      $boosterImage = 'skullface.jpg';
                    } elseif (str_contains($boosterName, 'nagaaaaa')) {
                      $boosterImage = 'nagaaaaa.jpg';
                    } elseif (str_contains($boosterName, 'bangboost')) {
                      $boosterImage = 'bangboost.jpg';
                    } elseif (str_contains($boosterName, 'mobalovers')) {
                      $boosterImage = 'mobalovers.jpg';
                    } elseif (str_contains($boosterName, 'emo')) {
                      $boosterImage = 'emo.jpg';
                    } elseif (str_contains($boosterName, 'sealw')) {
                      $boosterImage = 'sealw.jpg';
                    }
                  @endphp
                  <img src="{{ asset('assets/' . $boosterImage) }}" alt="{{ $service->booster_name }}" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover; flex-shrink: 0;" onerror="this.src='{{ asset('assets/Tamago.jpg') }}'">
                  <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $service->booster_name }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                  <div style="font-size: 9px; color: #ffc107;">★ {{ number_format($service->service_rating, 1) }}</div>
                  <span style="font-weight: 700; font-size: 10px; color: #0066cc;">Rp{{ number_format($service->service_price, 0, ',', '.') }}</span>
                </div>
              </div>
            </a>
          @endforeach
        @else
          <p style="color: #999; grid-column: 1 / -1;">Tidak ada layanan tersedia</p>
        @endif
        </div>
      </div>

    </div>
  </section>

  <!-- TAB BAR -->
  <nav class="tabbar">
    <a class="tab active" href="{{ route('home') }}">
      <svg viewBox="0 0 24 24"><path d="M3 10l9-7 9 7v8a2 2 0 0 1-2 2h-3v-5H8v5H5a2 2 0 0 1-2-2v-8Z"/></svg>
      <span>Home</span>
    </a>
    <a class="tab" href="{{ route('games.index') }}">
      <svg viewBox="0 0 24 24"><path d="M6 7h12l-1 11a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2L6 7Z"/><path d="M9 7V5a3 3 0 0 1 6 0v2" fill="none"/></svg>
      <span>Explore</span>
    </a>
    <a class="tab" href="{{ route('chat.index') }}">
      <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
      <span>Message</span>
    </a>
    <a class="tab" href="{{ route('cart.index') }}">
      <svg viewBox="0 0 24 24"><path d="M9 2a1 1 0 0 0 0 2h.01a1 1 0 0 0 0-2H9z"/><path d="M5 5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5z"/></svg>
      <span>Notification</span>
    </a>
    <a class="tab" href="{{ route('profile.show') }}">
      <svg viewBox="0 0 24 24" class="profile-icon">
        <circle cx="12" cy="12" r="9" fill="none"/>
        <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-6 7a6 6 0 0 1 12 0" fill="none"/>
      </svg>
      <span>Profile</span>
    </a>
  </nav>

  <script>
    // Banner Slider Functions
    let bannerCurrentIndex = 0;
    const bannerTotal = 3;
    let bannerAutoplay = true;
    let bannerAutoplayTimer = null;

    function updateBannerSlide(index) {
      const track = document.getElementById('bannerTrack');
      const offset = -index * 100;
      track.style.transform = `translateX(${offset}%)`;
      
      // Update indicators
      document.querySelectorAll('.banner-indicator').forEach((indicator, i) => {
        if (i === index) {
          indicator.style.background = 'rgba(255,255,255,0.9)';
          indicator.style.width = '24px';
        } else {
          indicator.style.background = 'rgba(255,255,255,0.4)';
          indicator.style.width = '8px';
        }
      });
      
      bannerCurrentIndex = index;
      resetBannerAutoplay();
    }

    function slideBanner(direction) {
      let newIndex = bannerCurrentIndex;
      if (direction === 'left') {
        newIndex = bannerCurrentIndex === 0 ? bannerTotal - 1 : bannerCurrentIndex - 1;
      } else {
        newIndex = bannerCurrentIndex === bannerTotal - 1 ? 0 : bannerCurrentIndex + 1;
      }
      updateBannerSlide(newIndex);
    }

    function goToBanner(index) {
      updateBannerSlide(index);
    }

    function resetBannerAutoplay() {
      if (bannerAutoplayTimer) {
        clearInterval(bannerAutoplayTimer);
      }
      if (bannerAutoplay) {
        bannerAutoplayTimer = setInterval(() => {
          let nextIndex = bannerCurrentIndex === bannerTotal - 1 ? 0 : bannerCurrentIndex + 1;
          updateBannerSlide(nextIndex);
        }, 5000); // Auto slide every 5 seconds
      }
    }

    // Initialize banner autoplay
    document.addEventListener('DOMContentLoaded', () => {
      resetBannerAutoplay();
      // Stop autoplay on user interaction
      document.getElementById('bannerSlider').addEventListener('mouseenter', () => {
        if (bannerAutoplayTimer) clearInterval(bannerAutoplayTimer);
      });
      document.getElementById('bannerSlider').addEventListener('mouseleave', () => {
        resetBannerAutoplay();
      });
    });
  </script>

  @endsection