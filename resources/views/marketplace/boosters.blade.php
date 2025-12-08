@extends('layouts.app')

@section('title', 'Boosters')

@section('content')
    <!-- BODY -->
    <div class="px-2 pb-5">
      <!-- Boosters Section - GRID 1 Kolom -->
      <div style="background: #fff; border-radius: 16px; padding: 16px; margin-bottom: 16px; border: 1px solid #e9e9e9; margin-top: 12px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
          <div style="font-weight: 600; font-size: 16px;">All Boosters</div>
        </div>

        <!-- Search Bar -->
        <div style="margin-bottom: 8px;">
          <form method="GET" action="{{ route('boosters') }}" style="display: flex; gap: 6px;">
            <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" style="flex: 1; padding: 4px 12px; border: 2px solid #d4e4f7; border-radius: 20px; font-size: 12px; outline: none; transition: all 0.3s;">
            <button type="submit" style="display: none;">Search</button>
          </form>
        </div>

        <!-- Filter and Sort -->
        <div style="display: flex; align-items: center; gap: 3px; margin-bottom: 20px;">
          <form method="GET" action="{{ route('boosters') }}" style="display: flex; align-items: center; gap: 3px;">
            <!-- Filter by Rating -->
            <select name="rating" onchange="this.form.submit()" style="padding: 3px 3px 3px 12px; border: 2px solid #d4e4f7; border-radius: 18px; font-size: 12px; cursor: pointer; background: #fff url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%228%22 height=%226%22 viewBox=%220 0 8 6%22><path fill=%22%230066cc%22 d=%22M0 0l4 6 4-6z%22/></svg>') no-repeat right 6px center; color: #0066cc; font-weight: 500; outline: none; transition: all 0.3s; appearance: none;">
              <option value="" style="color: #999;">Filter</option>
              <option value="diamond" {{ request('rating') == 'diamond' ? 'selected' : '' }}>Diamond (4.5+)</option>
              <option value="gold" {{ request('rating') == 'gold' ? 'selected' : '' }}>Gold (3.5+)</option>
              <option value="silver" {{ request('rating') == 'silver' ? 'selected' : '' }}>Silver</option>
              <option value="bestseller" {{ request('rating') == 'bestseller' ? 'selected' : '' }}>Best Seller (4.8+)</option>
            </select>

            <!-- Sort By -->
            <select name="sort" onchange="this.form.submit()" style="padding: 3px 3px 3px 12px; border: 2px solid #d4e4f7; border-radius: 18px; font-size: 12px; cursor: pointer; background: #fff url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%228%22 height=%226%22 viewBox=%220 0 8 6%22><path fill=%22%230066cc%22 d=%22M0 0l4 6 4-6z%22/></svg>') no-repeat right 6px center; color: #0066cc; font-weight: 500; outline: none; transition: all 0.3s; appearance: none;">
              <option value="" style="color: #999;">Sort</option>
              <option value="rating_desc" {{ request('sort') == 'rating_desc' ? 'selected' : '' }}>Rating (High to Low)</option>
              <option value="rating_asc" {{ request('sort') == 'rating_asc' ? 'selected' : '' }}>Rating (Low to High)</option>
              <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
              <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
            </select>

            <!-- Reset Button
            <a href="{{ route('boosters') }}" style="padding: 3px 6px; background: transparent; color: #999; border: 2px solid #e9e9e9; border-radius: 18px; text-decoration: none; font-size: 12px; cursor: pointer; transition: all 0.3s;">Clear</a> -->
          </form>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px;">
        @if($boosters && $boosters->count() > 0)
          @foreach ($boosters as $b)
            <a href="{{ route('booster.profile', $b->booster_id) }}" style="display: flex; background: linear-gradient(135deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.3) 100%), url('{{ asset('assets/' . str()->slug($b->user->user_name) . '-bg.jpg') }}') center/cover; border: 1px solid #e9e9e9; border-radius: 16px; padding: 12px; gap: 12px; text-decoration: none; color: #0a0a0a; align-items: center; transition: all 0.3s ease;">
              <img src="{{ asset('assets/' . str()->slug($b->user->user_name) . '.jpg') }}" alt="{{ $b->user->user_name }}" style="width: 80px; height: 80px; border-radius: 12px; object-fit: cover; flex-shrink: 0;" onerror="this.src='{{ asset('assets/avatar-placeholder.jpg') }}'">
              <div style="flex: 1; min-width: 0;">
                <div style="margin-bottom: 4px;">
                  @if($b->booster_rating >= 4.5)
                    <span style="font-size: 10px; padding: 3px 8px; background: #ffc107; color: #000; border-radius: 4px; margin-right: 6px; display: inline-block;">Diamond Booster</span>
                  @elseif($b->booster_rating >= 3.5)
                    <span style="font-size: 10px; padding: 3px 8px; background: #c0c0c0; color: #000; border-radius: 4px; margin-right: 6px; display: inline-block;">Gold Booster</span>
                  @else
                    <span style="font-size: 10px; padding: 3px 8px; background: #cd7f32; color: #fff; border-radius: 4px; margin-right: 6px; display: inline-block;">Silver Booster</span>
                  @endif
                  @if($b->booster_rating >= 4.8)
                    <span style="font-size: 10px; padding: 3px 8px; background: #0066cc; color: #fff; border-radius: 4px; display: inline-block;">Best Seller</span>
                  @endif
                </div>
                <div style="font-weight: 600; font-size: 14px; margin: 4px 0; display: flex; align-items: center; gap: 4px; color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                  {{ $b->user->user_name }}
                  @if($b->verified)
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="#0066cc"><path d="M10.5 1.5H4.605c-.606 0-1.122.233-1.5.612-.389.378-.605.894-.605 1.5v16.776c0 .606.233 1.122.612 1.5.378.389.894.605 1.5.605h14.776c.606 0 1.122-.233 1.5-.612.389-.378.605-.894.605-1.5V11.5M10.5 1.5v8m0-8L21 10.5m-10.5-9h8.25"/></svg>
                  @endif
                </div>
                <div style="font-size: 11px; color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">★ {{ number_format($b->booster_rating / 10, 1) }}</div>
              </div>
            </a>
          @endforeach
        @else
          <p style="color: #999;">Tidak ada booster tersedia</p>
        @endif
        </div>
        
        <!-- Pagination -->
        @if($boosters->hasPages())
          <div style="margin-top: 12px; display: flex; justify-content: center; gap: 4px;">
            {{-- Previous Page Link --}}
            @if ($boosters->onFirstPage())
              <span style="padding: 4px 8px; color: #ccc; border: 1px solid #e9e9e9; border-radius: 4px; background: #f9f9f9; font-size: 12px;">←</span>
            @else
              <a href="{{ $boosters->previousPageUrl() }}&search={{ request('search') }}&rating={{ request('rating') }}&sort={{ request('sort') }}" style="padding: 4px 8px; text-decoration: none; color: #0066cc; border: 1px solid #0066cc; border-radius: 4px; background: #fff; transition: all 0.3s; font-size: 12px;">←</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($boosters->getUrlRange(1, $boosters->lastPage()) as $page => $url)
              @if ($page == $boosters->currentPage())
                <span style="padding: 4px 8px; background: #0066cc; color: #fff; border: 1px solid #0066cc; border-radius: 4px; font-weight: 600; font-size: 12px;">{{ $page }}</span>
              @else
                <a href="{{ $url }}&search={{ request('search') }}&rating={{ request('rating') }}&sort={{ request('sort') }}" style="padding: 4px 8px; text-decoration: none; color: #0066cc; border: 1px solid #e9e9e9; border-radius: 4px; background: #fff; transition: all 0.3s; font-size: 12px;">{{ $page }}</a>
              @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($boosters->hasMorePages())
              <a href="{{ $boosters->nextPageUrl() }}&search={{ request('search') }}&rating={{ request('rating') }}&sort={{ request('sort') }}" style="padding: 4px 8px; text-decoration: none; color: #0066cc; border: 1px solid #0066cc; border-radius: 4px; background: #fff; transition: all 0.3s; font-size: 12px;">→</a>
            @else
              <span style="padding: 4px 8px; color: #ccc; border: 1px solid #e9e9e9; border-radius: 4px; background: #f9f9f9; font-size: 12px;">→</span>
            @endif
          </div>
        @endif
      </div>
    </div>

  </section>

  <!-- TAB BAR -->
  <nav class="tabbar">
    <a class="tab" href="{{ route('home') }}">
      <svg viewBox="0 0 24 24"><path d="M3 10l9-7 9 7v8a2 2 0 0 1-2 2h-3v-5H8v5H5a2 2 0 0 1-2-2v-8Z"/></svg>
      <span>Home</span>
    </a>
    <a class="tab active" href="{{ route('games.index') }}">
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
      <svg viewBox="0 0 24 24" class="profile-icon"><circle cx="12" cy="12" r="9" fill="none"/><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-6 7a6 6 0 0 1 12 0" fill="none"/></svg>
      <span>Profile</span>
    </a>
  </nav>

@endsection
