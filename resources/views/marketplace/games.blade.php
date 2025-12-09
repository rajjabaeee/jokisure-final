@extends('layouts.app')

@section('title', 'Games')

@section('content')
    <!-- BODY -->
    <div class="px-2 pb-5">

      <!-- Popular Games Section - GRID 3x2 -->
      <div style="background: #fff; border-radius: 16px; padding: 16px; margin-bottom: 16px; border: 1px solid #e9e9e9; margin-top: 12px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
          <div style="font-weight: 600; font-size: 16px;">Popular Games</div>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
        @if($popularGames->count() > 0)
          @foreach ($popularGames as $game)
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

      <!-- All Games Section - GRID 3 Kolom -->
      <div style="background: #fff; border-radius: 16px; padding: 16px; margin-bottom: 16px; border: 1px solid #e9e9e9;">
        <div style="font-weight: 600; font-size: 16px; margin-bottom: 12px;">All Games</div>
        
        <!-- Search Bar -->
        <div style="margin-bottom: 8px;">
          <input type="text" id="gameSearch" placeholder="Search games..." style="flex: 1; width: 100%; padding: 4px 12px; border: 2px solid #d4e4f7; border-radius: 20px; font-size: 12px; outline: none; transition: all 0.3s;" oninput="filterGames()">
        </div>

        <!-- Filter and Sort -->
        <div style="display: flex; align-items: center; gap: 3px; margin-bottom: 20px;">
          <form method="GET" action="{{ route('games.index') }}" style="display: flex; align-items: center; gap: 3px;">
            <!-- Filter by Rating -->
            <select name="rating" onchange="this.form.submit()" style="padding: 3px 3px 3px 12px; border: 2px solid #d4e4f7; border-radius: 18px; font-size: 12px; cursor: pointer; background: #fff url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%228%22 height=%226%22 viewBox=%220 0 8 6%22><path fill=%22%230066cc%22 d=%22M0 0l4 6 4-6z%22/></svg>') no-repeat right 6px center; color: #0066cc; font-weight: 500; outline: none; transition: all 0.3s; appearance: none;">
              <option value="" style="color: #999;">Filter</option>
              <option value="top" {{ request('rating') == 'top' ? 'selected' : '' }}>Top Rated (4.5+)</option>
              <option value="popular" {{ request('rating') == 'popular' ? 'selected' : '' }}>Popular (3.5+)</option>
              <option value="trending" {{ request('rating') == 'trending' ? 'selected' : '' }}>Trending (3.0+)</option>
            </select>

            <!-- Sort By -->
            <select name="sort" onchange="this.form.submit()" style="padding: 3px 3px 3px 12px; border: 2px solid #d4e4f7; border-radius: 18px; font-size: 12px; cursor: pointer; background: #fff url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%228%22 height=%226%22 viewBox=%220 0 8 6%22><path fill=%22%230066cc%22 d=%22M0 0l4 6 4-6z%22/></svg>') no-repeat right 6px center; color: #0066cc; font-weight: 500; outline: none; transition: all 0.3s; appearance: none;">
              <option value="" style="color: #999;">Sort</option>
              <option value="rating_desc" {{ request('sort') == 'rating_desc' ? 'selected' : '' }}>Rating (High to Low)</option>
              <option value="rating_asc" {{ request('sort') == 'rating_asc' ? 'selected' : '' }}>Rating (Low to High)</option>
              <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
              <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
            </select>
          </form>
        </div>
        
        @if($games->count() > 0)
          <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
            @foreach ($games as $game)
              <a href="{{ route('games.show', $game->game_id) }}" data-game-name="{{ $game->game_name }}" style="display: flex; flex-direction: column; border-radius: 12px; overflow: hidden; background: #fff; border: 1px solid #e9e9e9; text-decoration: none; color: #0a0a0a; transition: all 0.3s ease;">
                <div style="width: 100%; height: 100px; overflow: hidden; background: #f5f5f5;">
                  <img src="{{ asset('assets/' . str()->slug($game->game_name) . '.jpg') }}" alt="{{ $game->game_name }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='{{ asset('assets/games-placeholder.jpg') }}'">
                </div>
                <div style="padding: 10px; text-align: center; flex: 1; display: flex; align-items: center; justify-content: center;">
                  <span style="font-size: 13px; font-weight: 600; line-height: 1.3;">{{ $game->game_name }}</span>
                </div>
              </a>
            @endforeach
          </div>
        @else
          <p style="color: #999;">Tidak ada games tersedia</p>
        @endif

        <!-- Pagination -->
        @if($games->hasPages())
          <div style="margin-top: 12px; display: flex; justify-content: center; gap: 4px;">
            {{-- Previous Page Link --}}
            @if ($games->onFirstPage())
              <span style="padding: 4px 8px; color: #ccc; border: 1px solid #e9e9e9; border-radius: 4px; background: #f9f9f9; font-size: 12px;">←</span>
            @else
              <a href="{{ $games->previousPageUrl() }}&search={{ request('search') }}&rating={{ request('rating') }}&sort={{ request('sort') }}" style="padding: 4px 8px; text-decoration: none; color: #0066cc; border: 1px solid #0066cc; border-radius: 4px; background: #fff; transition: all 0.3s; font-size: 12px;">←</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($games->getUrlRange(1, $games->lastPage()) as $page => $url)
              @if ($page == $games->currentPage())
                <span style="padding: 4px 8px; background: #0066cc; color: #fff; border: 1px solid #0066cc; border-radius: 4px; font-weight: 600; font-size: 12px;">{{ $page }}</span>
              @else
                <a href="{{ $url }}&search={{ request('search') }}&rating={{ request('rating') }}&sort={{ request('sort') }}" style="padding: 4px 8px; text-decoration: none; color: #0066cc; border: 1px solid #e9e9e9; border-radius: 4px; background: #fff; transition: all 0.3s; font-size: 12px;">{{ $page }}</a>
              @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($games->hasMorePages())
              <a href="{{ $games->nextPageUrl() }}&search={{ request('search') }}&rating={{ request('rating') }}&sort={{ request('sort') }}" style="padding: 4px 8px; text-decoration: none; color: #0066cc; border: 1px solid #0066cc; border-radius: 4px; background: #fff; transition: all 0.3s; font-size: 12px;">→</a>
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
      <svg viewBox="0 0 24 24" class="profile-icon">
        <circle cx="12" cy="12" r="9" fill="none"/>
        <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-6 7a6 6 0 0 1 12 0" fill="none"/>
      </svg>
      <span>Profile</span>
    </a>
  </nav>

<script>
function filterGames() {
    const searchInput = document.getElementById('gameSearch');
    const filter = searchInput.value.toLowerCase().trim();
    const games = document.querySelectorAll('[data-game-name]');
    
    games.forEach(game => {
        const gameName = game.getAttribute('data-game-name').toLowerCase();
        
        if (gameName.includes(filter) || filter === '') {
            game.style.display = '';
        } else {
            game.style.display = 'none';
        }
    });
}
</script>

@endsection
