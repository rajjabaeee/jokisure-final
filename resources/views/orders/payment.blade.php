{{-- resources/views/orders/payment.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>JokiSure • Payment</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/service-detail.css') }}" rel="stylesheet">
</head>

<body class="preview-center">
<main class="device-frame" role="main" aria-label="Payment">

  {{-- SAFE AREA TANPA STATUS BAR --}}
  <section class="safe-area d-flex flex-column">

    {{-- TOP BAR --}}
    <div class="appbar d-flex align-items-center justify-content-between px-3">
      <a href="{{ route('boost.request') }}" class="icon-btn">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
          <path d="M15 6l-6 6 6 6" stroke="#0a0a0a" stroke-width="2.2"
                stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>

      <div class="fw-semibold">Payment</div>

      <a href="#" class="icon-btn">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
          <circle cx="12" cy="12" r="10" stroke="#0a0a0a" stroke-width="2"/>
          <path d="M12 17v-5" stroke="#0a0a0a" stroke-width="2" stroke-linecap="round"/>
          <circle cx="12" cy="8" r="1.2" fill="#0a0a0a"/>
        </svg>
      </a>
    </div>

    <div class="appbar-divider"></div>

    {{-- CONTENT --}}
    <div class="content container px-3">

      <h1 class="display-6 title">Your Order</h1>

      {{-- ORDER CARD --}}
      <div class="order-card p-3 rounded-3 mb-3">
        <div class="small fw-bold mb-1">Pack 1</div>
        <div class="row">
          <div class="col">
            <div class="small text-muted">
              Genshin Impact | Abyss<br>
              Variant: Floor 9, Floor 10,<br>
              Floor 12
            </div>
          </div>
          <div class="col-auto align-self-start fw-semibold">Rp 60.000</div>
        </div>
      </div>

      {{-- VOUCHER --}}
      <a class="voucher-row mb-3 d-flex align-items-center justify-content-between rounded-2 px-3 py-3 text-decoration-none"
         data-bs-toggle="modal" data-bs-target="#voucherModal">

        <span class="fw-semibold">Voucher</span>

        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
          <path d="M9 18l6-6-6-6" stroke="#0a0a0a" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>

      {{-- PAYMENT METHOD --}}
      <div class="mb-2 fw-semibold">Payment Method</div>

      <form method="post" action="{{ route('payment.process') }}">
        @csrf

        <input type="hidden" name="voucher_id" id="selectedVoucherId" value="">
        <input type="hidden" name="discount_amount" id="selectedDiscountAmount" value="0">

        <select name="method" class="form-select form-select-dark mb-3" required>
          <option disabled selected>Select your payment</option>
          <option value="gopay">Gopay</option>
          <option value="ovo">OVO</option>
          <option value="dana">DANA</option>
          <option value="shopee">ShopeePay</option>
          <option value="card">VISA/Mastercard</option>
        </select>

        <hr class="my-3">

        <div class="price-row">
          <span>Pack Price</span>
          <span class="fw-semibold">Rp 60.000</span>
        </div>

        <div class="price-row">
          <span>Discount</span>
          <span class="text-danger" id="discountAmount">-Rp 0</span>
        </div>

        <div class="price-row mb-2">
          <span>Tax & Services</span>
          <span>Rp 5.000</span>
        </div>

        <div class="d-flex align-items-center justify-content-between mt-1">
          <div class="fw-bold">Total Price</div>
          <span class="total-chip" id="totalPrice">Rp 65.000</span>
        </div>

        <hr class="my-3">

        <button class="btn btn-cta w-100 mt-1" type="submit">Pay</button>
      </form>

    </div>
  </section>

</main>

{{-- MODAL VOUCHER --}}
<div class="modal fade" id="voucherModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content p-3 rounded-4">

      <h5 class="fw-bold mb-3 text-center">Available Vouchers</h5>

      <div id="voucherList">
        <!-- Vouchers will be loaded here dynamically -->
        <div class="text-center text-muted py-3">
          <div class="spinner-border spinner-border-sm" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <div class="mt-2">Loading vouchers...</div>
        </div>
      </div>

      <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" onclick="applyVoucher()">Apply</button>
      </div>

    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  let selectedVoucher = null;
  let availableVouchers = [];
  const basePrice = 60000;
  const tax = 5000;

  // Load vouchers when modal is opened
  document.getElementById('voucherModal').addEventListener('show.bs.modal', function () {
    loadVouchers();
  });

  // Fetch available vouchers from backend
  function loadVouchers() {
    const cartTotal = basePrice; // Hardcoded for now, will be dynamic later

    fetch(`/api/vouchers/available?cart_total=${cartTotal}`)
      .then(response => response.json())
      .then(data => {
        if (data.success && data.data.length > 0) {
          availableVouchers = data.data;
          displayVouchers(data.data);
        } else {
          displayNoVouchers();
        }
      })
      .catch(error => {
        console.error('Error loading vouchers:', error);
        displayError();
      });
  }

  // Display vouchers in modal
  function displayVouchers(vouchers) {
    const voucherList = document.getElementById('voucherList');
    voucherList.innerHTML = '';

    vouchers.forEach(voucher => {
      const voucherCard = document.createElement('div');
      voucherCard.className = 'voucher-card p-3 mb-2 rounded-3 border';
      voucherCard.style.cursor = 'pointer';
      voucherCard.onclick = () => selectVoucher(voucher);

      voucherCard.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="fw-bold">${voucher.discount_value}% OFF</div>
            <div class="small text-muted">${voucher.discount_desc || 'Discount applies to all packs'}</div>
            ${voucher.min_transaction > 0 ? `<div class="small text-muted mt-1">Min: Rp ${voucher.min_transaction.toLocaleString()}</div>` : ''}
          </div>
          <input type="radio" name="voucher" value="${voucher.discount_id}" id="voucher_${voucher.discount_id}">
        </div>
      `;

      voucherList.appendChild(voucherCard);
    });
  }

  // Display message when no vouchers available
  function displayNoVouchers() {
    const voucherList = document.getElementById('voucherList');
    voucherList.innerHTML = `
      <div class="text-center text-muted py-4">
        <div class="mb-2">😔</div>
        <div>No vouchers available for this order</div>
      </div>
    `;
  }

  // Display error message
  function displayError() {
    const voucherList = document.getElementById('voucherList');
    voucherList.innerHTML = `
      <div class="text-center text-danger py-4">
        <div class="mb-2">⚠️</div>
        <div>Failed to load vouchers</div>
        <button class="btn btn-sm btn-outline-secondary mt-2" onclick="loadVouchers()">Retry</button>
      </div>
    `;
  }

  // Select a voucher
  function selectVoucher(voucher) {
    selectedVoucher = voucher;
    // Check the corresponding radio button
    document.getElementById(`voucher_${voucher.discount_id}`).checked = true;
  }

  // Apply selected voucher
  function applyVoucher() {
    if (!selectedVoucher) {
      alert("Please select a voucher!");
      return;
    }

    const discountAmount = (basePrice * selectedVoucher.discount_value) / 100;
    const total = basePrice - discountAmount + tax;

    // Update display
    document.getElementById("discountAmount").innerText = "-Rp " + discountAmount.toLocaleString();
    document.getElementById("totalPrice").innerText = "Rp " + total.toLocaleString();

    // Set hidden inputs for form submission
    document.getElementById("selectedVoucherId").value = selectedVoucher.discount_id;
    document.getElementById("selectedDiscountAmount").value = discountAmount;

    // Close modal
    let modal = bootstrap.Modal.getInstance(document.getElementById('voucherModal'));
    modal.hide();

    console.log('Voucher applied:', selectedVoucher);
  }
</script>

</body>
</html>
