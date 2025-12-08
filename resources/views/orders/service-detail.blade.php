{{-- resources/views/orders/service-detail.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>JokiSure • Service Detail</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/service-detail-confirm.css') }}" rel="stylesheet">
</head>
<body class="preview-center">
<main class="device-frame">

  {{-- Status bar --}}
  <div class="status-bar d-flex align-items-center justify-content-between px-3">
    <div class="fw-semibold">9:41</div>
    <div class="d-flex align-items-center gap-2"><div class="battery"></div></div>
  </div>

  {{-- Safe area --}}
  <section class="safe-area">
    {{-- App bar --}}
    <div class="appbar d-flex align-items-center justify-content-between px-3">
      <a href="{{ url()->previous() }}" class="text-dark text-decoration-none" aria-label="Back">
        <svg width="22" height="22" fill="none" aria-hidden="true"><path d="M14 5l-6 6 6 6" stroke="#000" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
      <div class="title-appbar">{{ $service->service_name ?? 'Service' }} | {{ $service->game->game_name ?? 'Game' }}</div>
      <svg width="22" height="22" fill="none" aria-hidden="true"><circle cx="11" cy="11" r="10" stroke="#000" stroke-width="2"/><text x="11" y="15" text-anchor="middle" font-size="10" font-family="Inter, sans-serif" fill="#000">?</text></svg>
    </div>
    <div class="divider"></div>

    <div class="content container px-3 pb-5">
      {{-- Banner --}}
      <div class="mt-3 rounded-3 overflow-hidden">
        @php
          // Create banner image path based on service name AND description
          $imageName = '';
          if($service) {
            $serviceName = strtolower($service->service_name ?? '');
            $serviceDesc = strtolower($service->service_desc ?? '');
            $serviceContent = $serviceName . ' ' . $serviceDesc;
            
            if(str_contains($serviceContent, 'abyss')) {
              $imageName = 'abyss.jpg';
            } elseif(str_contains($serviceContent, 'inazuma')) {
              $imageName = 'inazuma.png';
            } elseif(str_contains($serviceContent, 'liyue')) {
              $imageName = 'liyue.png';
            } elseif(str_contains($serviceContent, 'mondstadt')) {
              $imageName = 'Monstandt.png';
            } elseif(str_contains($serviceContent, 'fontaine')) {
              $imageName = 'fontaine.png';
            } elseif(str_contains($serviceContent, 'sumeru')) {
              $imageName = 'Sumeru.png';
            } elseif(str_contains($serviceContent, 'dragonspine')) {
              $imageName = 'Dragonspine.png';
            } elseif(str_contains($serviceContent, 'enkanomiya')) {
              $imageName = 'enkanomiya.png';
            } elseif(str_contains($serviceContent, 'natlan')) {
              $imageName = 'Natlan.png';
            } elseif(str_contains($serviceContent, 'chasm')) {
              $imageName = 'Chasm.png';
            } else {
              // Default to game image
              $gameName = strtolower($service->game->game_name ?? 'genshin-impact');
              $imageName = str_replace(' ', '-', $gameName) . '.jpg';
            }
          } else {
            $imageName = 'abyss.jpg'; // fallback
          }
        @endphp
        <img src="{{ asset('assets/' . $imageName) }}" class="w-100 rounded-3" alt="{{ $service->service_name ?? 'Service' }} Banner">
      </div>

      {{-- Detail card --}}
      <div class="mt-3 p-3 border rounded-3">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <h6 class="h6-title mb-1">{{ $service->service_name ?? 'Service' }} | {{ $service->game->game_name ?? 'Game' }}</h6>
            <div class="meta-variant">{{ $service->service_desc ?? 'Service description not available' }}</div>
          </div>

          {{-- Chips (buttons) --}}
          <div class="d-flex align-items-center gap-2">
            <button type="button" id="btnShare"
                    class="chip share"
                    title="Share"
                    aria-label="Share this service"
                    data-share-title="{{ $service->service_name ?? 'Service' }} | {{ $service->game->game_name ?? 'Game' }}"
                    data-share-url="{{ url()->current() }}">
              {{-- share icon (white) --}}
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M16 8a3 3 0 100-6 3 3 0 000 6zM8 15a3 3 0 100-6 3 3 0 000 6zM16 22a3 3 0 100-6 3 3 0 000 6z"
                      fill="currentColor"/>
                <path d="M13.5 6.5L10.5 8.5M13.5 17.5L10.5 15.5" stroke="#fff" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" opacity=".9"/>
              </svg>
            </button>

            <button type="button" id="btnWishlist"
                    class="chip heart"
                    title="Add to wishlist"
                    aria-label="Add to wishlist"
                    aria-pressed="false">
              {{-- heart icon (white) --}}
              <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 21s-7.5-4.35-9.5-8.24C1 9.5 3.5 6 7 6c2 0 3.3 1.04 5 3 1.7-1.96 3-3 5-3 3.5 0 6 3.5 4.5 6.76C19.5 16.65 12 21 12 21Z"
                      fill="currentColor"/>
              </svg>
            </button>
          </div>
        </div>

        <div class="mt-3">
          <h6 class="section-title">Joki Details:</h6>
          @php
            $desc = strtolower($service->service_name ?? '');
            $gameDesc = strtolower($service->service_desc ?? '');
          @endphp
          
          @if(str_contains($desc, 'abyss'))
            <ul class="details-list mb-3">
              <li>✅ Completion of Abyss Floors 9–12</li>
              <li>✅ Optional full stars clear (3 stars per floor)</li>
              <li>✅ Customized team strategies based on your roster</li>
              <li>✅ Weekly resets accepted</li>
            </ul>
          @elseif(str_contains($desc, 'explore') || str_contains($gameDesc, 'exploration'))
            @php
              $region = '';
              if(str_contains($desc, 'inazuma') || str_contains($gameDesc, 'inazuma')) $region = 'Inazuma';
              elseif(str_contains($desc, 'liyue') || str_contains($gameDesc, 'liyue')) $region = 'Liyue';
              elseif(str_contains($desc, 'mondstadt') || str_contains($gameDesc, 'mondstadt')) $region = 'mondstadt';
              elseif(str_contains($desc, 'fontaine') || str_contains($gameDesc, 'fontaine')) $region = 'Fontaine';
              elseif(str_contains($desc, 'sumeru') || str_contains($gameDesc, 'sumeru')) $region = 'Sumeru';
              elseif(str_contains($desc, 'dragonspine') || str_contains($gameDesc, 'dragonspine')) $region = 'Dragonspine';
              elseif(str_contains($desc, 'enkanomiya') || str_contains($gameDesc, 'enkanomiya')) $region = 'Enkanomiya';
              elseif(str_contains($desc, 'natlan') || str_contains($gameDesc, 'natlan')) $region = 'Natlan';
              elseif(str_contains($desc, 'chasm') || str_contains($gameDesc, 'chasm')) $region = 'Chasm';
              else $region = 'Region';
            @endphp
            <ul class="details-list mb-3">
              <li>✅ Complete {{ $region }} exploration to 100%</li>
              <li>✅ All waypoints and teleport points activated</li>
              <li>✅ All treasure chests collected</li>
              <li>✅ All oculi and collectibles gathered</li>
              <li>✅ World quests and puzzles completed</li>
            </ul>
          @else
            <ul class="details-list mb-3">
              <li>✅ {{ $service->service_desc ?? 'Professional service completion' }}</li>
              <li>✅ Fast and reliable completion</li>
              <li>✅ Account safety guaranteed</li>
              <li>✅ Professional boosters only</li>
            </ul>
          @endif

          <h6 class="section-title">How It Works</h6>
          @if(str_contains($desc, 'abyss'))
            <ol class="howto ps-3 mb-0">
              <li>Choose the floors you want boosted (9, 10, 11, 12 – or all).</li>
              <li>Select any add-ons (e.g., full stars, specific characters).</li>
              <li>Confirm your order and preferred time slot.</li>
              <li>Sit back and track your boost progress live.</li>
            </ol>
          @elseif(str_contains($desc, 'explore') || str_contains($gameDesc, 'exploration'))
            <ol class="howto ps-3 mb-0">
              <li>Provide your account details and current exploration progress.</li>
              <li>Our booster will systematically explore all areas.</li>
              <li>All chests, waypoints, and collectibles will be gathered.</li>
              <li>Receive completion confirmation with progress screenshots.</li>
            </ol>
          @else
            <ol class="howto ps-3 mb-0">
              <li>Provide your account details and service requirements.</li>
              <li>Our professional booster will handle your request.</li>
              <li>Track progress through real-time updates.</li>
              <li>Receive completion notification with results.</li>
            </ol>
          @endif
        </div>
      </div>

      {{-- Bottom grid --}}
      <div class="bottom-grid mt-3">
        <div class="left-col">
          <button id="openRules" class="rules-card w-100" aria-haspopup="dialog" aria-controls="rulesSheet">
            <span class="rules-text">See The<br/>Rules Here</span>
            <span class="rules-circle" aria-hidden="true">
              <svg class="arrow-fallback" viewBox="0 0 24 24" width="18" height="18" fill="none">
                <path d="M8 12h8" stroke="#fff" stroke-width="2.2" stroke-linecap="round"/>
                <path d="M13 7l5 5-5 5" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
          </button>

          <div id="statusBadge" class="pill text-white fw-semibold text-center mt-2">Unconfirmed</div>
        </div>

        <div class="right-col">
          <div class="price-box p-2 rounded-3">
            <div class="tiny-label">Price:</div>
            <div class="price-pill mb-2">Rp {{ number_format($service->service_price ?? 70000, 0, ',', '.') }}</div>
            <div class="tiny-label">Estimated Time:</div>
            <div class="price-pill">{{ $service->est_time ?? '1 Day' }}</div>
          </div>

          @if($service)
            <form action="{{ route('cart.add') }}" method="POST" class="mt-2">
              @csrf
              <input type="hidden" name="service_id" value="{{ $service->service_id }}">
              <button type="submit" class="btn addtocart-btn w-100 fw-semibold">Add To Cart</button>
            </form>
          @else
            <a href="/cart" class="btn addtocart-btn w-100 mt-2 fw-semibold text-decoration-none">Add To Cart</a>
          @endif
        </div>
      </div>

      <button id="proceedBtn" class="btn proceed w-100 mt-3 fw-semibold" aria-disabled="true">Proceed & Pay</button>
    </div>
  </section>

  <div class="home-indicator"></div>

  {{-- Sheet modal --}}
  <div id="sheetBackdrop" class="sheet-backdrop d-none"></div>
  <aside id="rulesSheet" class="sheet d-none" aria-hidden="true">
    <div class="sheet-header d-flex justify-content-between align-items-center">
      <h5 class="sheet-title mb-0">Rules & Guidelines</h5>
      <button type="button" id="closeRules" class="sheet-close"><span>✕</span></button>
    </div>

    <div class="sheet-body">
      <ul class="sheet-list mb-3 ps-3">
        <li>All users must treat boosters and support staff respectfully. Any form of harassment, hate speech, or abusive behavior will result in immediate account suspension.</li>
        <li>Using the app to advertise or promote third-party services, marketplaces, or unrelated products is strictly prohibited.</li>
        <li>You are responsible for providing accurate account credentials and game information. Incorrect details may lead to delays or failed boosts, which are not eligible for refund.</li>
        <li>All payments must be completed through the official app payment system. Refunds or disputes will be handled according to the app's refund policy.</li>
        <li>By ordering a boost, you agree to share your game account temporarily for the purpose of completing Spiral Abyss content.</li>
        <li>Please do not log into your Genshin Impact account while the booster is working. Doing so may cause disconnects or data loss.</li>
      </ul>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="acceptRules">
        <label class="form-check-label sheet-check" for="acceptRules">Will You Accept the Rules to Proceed?</label>
      </div>

      <button id="approveBtn" class="btn approve w-100 fw-semibold" disabled>Approve</button>
    </div>
  </aside>

  {{-- Mini toast --}}
  <div id="toast" class="toast-mini" role="status" aria-live="polite"></div>
</main>

<script>
  // ===== Sheet logic
  const openRules   = document.getElementById('openRules');
  const sheet       = document.getElementById('rulesSheet');
  const backdrop    = document.getElementById('sheetBackdrop');
  const closeRules  = document.getElementById('closeRules');
  const checkbox    = document.getElementById('acceptRules');
  const approveBtn  = document.getElementById('approveBtn');
  const statusBadge = document.getElementById('statusBadge');
  const proceedBtn  = document.getElementById('proceedBtn');

  function openSheet(){
    sheet.classList.remove('d-none');
    backdrop.classList.remove('d-none');
    requestAnimationFrame(()=>{ sheet.classList.add('show'); backdrop.classList.add('show'); });
  }
  function closeSheet(){
    sheet.classList.remove('show'); backdrop.classList.remove('show');
    sheet.addEventListener('transitionend',()=>{ sheet.classList.add('d-none'); backdrop.classList.add('d-none'); },{once:true});
  }
  openRules.addEventListener('click', openSheet);
  closeRules.addEventListener('click', closeSheet);
  backdrop.addEventListener('click', closeSheet);

  checkbox.addEventListener('change', ()=>{
    approveBtn.disabled = !checkbox.checked;
    approveBtn.classList.toggle('active', checkbox.checked);
  });

  approveBtn.addEventListener('click', ()=>{
    closeSheet();
    statusBadge.textContent = 'Confirmed';
    statusBadge.style.backgroundColor = '#3ABC13';
    proceedBtn.classList.add('enabled');
    proceedBtn.setAttribute('aria-disabled','false');
  });

  proceedBtn.addEventListener('click', ()=>{
    if (proceedBtn.classList.contains('enabled')) {
      window.location.href = "{{ route('boost.request') }}?service_id={{ $service->service_id ?? '' }}";
    }
  });

  // ===== Chips: share & wishlist
  const toastEl   = document.getElementById('toast');
  const btnShare  = document.getElementById('btnShare');
  const btnWish   = document.getElementById('btnWishlist');

  function showToast(msg){
    toastEl.textContent = msg;
    toastEl.classList.add('show');
    setTimeout(()=> toastEl.classList.remove('show'), 1600);
  }

  btnShare.addEventListener('click', async () => {
    const title = btnShare.dataset.shareTitle || document.title;
    const url   = btnShare.dataset.shareUrl || window.location.href;

    if (navigator.share) {
      try { await navigator.share({ title, url }); }
      catch(e){ /* user cancelled */ }
    } else if (navigator.clipboard) {
      try { await navigator.clipboard.writeText(url); showToast('Link copied'); return; }
      catch(e){ /* fallback to alert */ }
    }
    // last resort
    alert(url);
  });

  btnWish.addEventListener('click', () => {
    const active = btnWish.classList.toggle('active');
    btnWish.setAttribute('aria-pressed', active ? 'true' : 'false');
    showToast(active ? 'Added to wishlist' : 'Removed from wishlist');
  });
</script>
</body>
</html>
