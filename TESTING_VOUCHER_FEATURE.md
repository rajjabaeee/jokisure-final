# 🧪 Testing Guide - Fitur Discount/Voucher

## 📋 Prerequisite

Sebelum testing, pastikan:
1. ✅ Database sudah running (XAMPP MySQL aktif)
2. ✅ Tabel `discount` sudah ada dan terisi data (3 voucher yang sudah dimasukkan via DBeaver)
3. ✅ Laravel development server running
4. ✅ User sudah login (karena route dalam `auth` middleware)

---

## 🚀 Cara Menjalankan Testing

### Step 1: Start Laravel Server

Buka terminal PowerShell di folder project, jalankan:

```powershell
php artisan serve
```

Server akan jalan di: `http://127.0.0.1:8000`

---

### Step 2: Login ke Aplikasi

1. Buka browser: `http://127.0.0.1:8000/login`
2. Login dengan akun yang valid
3. Setelah login, kamu akan diarahkan ke homepage

---

## 🎯 Testing Flow - Fitur Discount

### TEST 1: Boost Request Form

**URL**: `http://127.0.0.1:8000/boost/request`

**Yang Harus Dilakukan**:
1. Isi semua field:
   - Name: `John Doe`
   - Email: `john@example.com`
   - Phone: `081234567890`
   - Username/ID: `johndoe123`
   - Password: `password123`
2. Pilih salah satu **Boost Priority** (misal: VIP)
3. Centang checkbox agreement
4. Klik tombol **Submit**

**Expected Result**:
- ✅ Form tervalidasi
- ✅ Data tersimpan di session
- ✅ Redirect ke halaman Payment (`/payment`)

**Cara Cek Berhasil**:
- Tidak ada error
- Langsung masuk ke halaman Payment

---

### TEST 2: Payment Page - Load Vouchers

**URL**: Otomatis di `/payment` setelah submit boost request

**Yang Harus Dilakukan**:
1. Perhatikan halaman Payment
2. Klik tombol/link **"Voucher"** (untuk buka modal)
3. Modal "Available Vouchers" akan muncul

**Expected Result**:
- ✅ Modal terbuka
- ✅ Muncul loading spinner dulu (sebentar)
- ✅ Setelah load selesai, muncul **3 voucher cards**:
  - **Flash Sale** - 20% OFF
  - **Member Baru** - 15% OFF
  - **Member Loyalty** - 10% OFF (min transaction: Rp 50,000)

**Cara Cek Berhasil**:
- Buka **Browser DevTools** (F12)
- Tab **Console**, tidak ada error merah
- Tab **Network**, cek request ke `/api/vouchers/available?cart_total=60000`
  - Status: `200 OK`
  - Response JSON berisi array 3 vouchers

**Screenshot Response JSON yang Expected**:
```json
{
  "success": true,
  "data": [
    {
      "discount_id": "f69941f6-7026-4158-9b60-66037d34bdd33",
      "discount_name": "Flash Sale",
      "discount_desc": "Diskon 20% untuk semua paket",
      "discount_value": 20,
      "min_transaction": 0
    },
    {
      "discount_id": "3de87bf1-3b8a-42e2-bd45-8f80c4850c10",
      "discount_name": "Member Baru",
      "discount_desc": "Diskon 15% untuk member baru",
      "discount_value": 15,
      "min_transaction": 0
    },
    {
      "discount_id": "30437fef-2cb5-44c2-98fa-9417bdfce4f4",
      "discount_name": "Member Loyalty",
      "discount_desc": "Diskon 10% untuk member setia",
      "discount_value": 10,
      "min_transaction": 50000
    }
  ]
}
```

---

### TEST 3: Select & Apply Voucher

**Masih di Modal Voucher**

**Yang Harus Dilakukan**:
1. Klik salah satu voucher card (misal: **Flash Sale 20% OFF**)
2. Radio button akan ter-check
3. Klik tombol **Apply**

**Expected Result**:
- ✅ Modal tertutup
- ✅ Halaman Payment ter-update:
  - **Discount** berubah dari `-Rp 0` menjadi `-Rp 12.000` (20% dari 60.000)
  - **Total Price** berubah dari `Rp 65.000` menjadi `Rp 53.000`
    - Perhitungan: 60.000 - 12.000 + 5.000 (tax) = 53.000

**Cara Cek Berhasil**:
- Lihat angka discount dan total price di halaman
- Buka **Console** (F12), ada log: `Voucher applied: {discount_id: "...", ...}`

---

### TEST 4: Process Payment

**Masih di halaman Payment**

**Yang Harus Dilakukan**:
1. Pilih **Payment Method** dari dropdown (misal: Gopay)
2. Klik tombol **Pay**

**Expected Result**:
- ✅ Form tersubmit dengan data:
  - `method`: gopay
  - `voucher_id`: (ID voucher yang dipilih)
  - `discount_amount`: 12000
- ✅ Data payment tersimpan di session
- ✅ Redirect ke halaman **Payment Successful** (`/payment/success`)

**Cara Cek Berhasil**:
- Tidak ada error
- Langsung masuk ke halaman Payment Success

---

### TEST 5: Payment Success Page

**URL**: Otomatis di `/payment/success`

**Expected Result**:
- ✅ Muncul pesan "Payment Successful!"
- ✅ Tampil **Order ID** (format: `ORD-XXXXX` - mock ID)
- ✅ Tampil **breakdown harga**:
  - Subtotal: Rp 60.000
  - Discount: -Rp 12.000 (kalau pakai voucher)
  - Tax & Service: Rp 5.000
  - **Total Paid: Rp 53.000**

**Cara Cek Berhasil**:
- Angka-angka sesuai dengan voucher yang dipilih
- Order ID muncul (bukan `0000`)

---

## 🔍 Testing Scenarios - Edge Cases

### Scenario A: Tidak Pilih Voucher

1. Di halaman Payment, **jangan buka modal voucher**
2. Langsung pilih payment method
3. Klik **Pay**

**Expected**:
- ✅ Discount tetap `Rp 0`
- ✅ Total: `Rp 65.000` (60k + 5k tax)
- ✅ Payment success tanpa discount

---

### Scenario B: Buka Modal Tapi Cancel

1. Buka modal voucher
2. Voucher ter-load
3. Klik tombol **Cancel**

**Expected**:
- ✅ Modal tertutup
- ✅ Discount tetap `Rp 0`
- ✅ Tidak ada voucher yang ter-apply

---

### Scenario C: Pilih Voucher Berbeda

1. Apply voucher **Flash Sale** (20%)
2. Cek total jadi `Rp 53.000`
3. Buka modal lagi
4. Pilih voucher **Member Baru** (15%)
5. Apply

**Expected**:
- ✅ Discount berubah jadi `-Rp 9.000` (15% dari 60k)
- ✅ Total berubah jadi `Rp 56.000`
- ✅ Voucher ter-override (yang terakhir dipilih)

---

### Scenario D: Cart Total Kurang dari Min Transaction

**Manual Test** (ubah hardcode):

Edit file `payment.blade.php`, line 168:
```javascript
// Ubah dari 60000 jadi 40000
const basePrice = 40000;
```

Reload page, buka modal voucher.

**Expected**:
- ✅ Hanya muncul **2 voucher**:
  - Flash Sale (min: 0)
  - Member Baru (min: 0)
- ❌ **Member Loyalty** (min: 50,000) **TIDAK MUNCUL**

Jangan lupa kembalikan ke `60000` setelah test!

---

## 🐛 Troubleshooting

### Error: "No payment data found"

**Penyebab**: Session kosong (boost request tidak diisi)

**Solusi**: 
1. Kembali ke `/boost/request`
2. Isi form dengan benar
3. Submit lagi

---

### Error: Voucher modal kosong / loading terus

**Penyebab**: API `/api/vouchers/available` gagal

**Cara Debug**:
1. Buka DevTools > Network tab
2. Cek request ke `/api/vouchers/available`
3. Lihat response error-nya

**Possible Issues**:
- Database tidak jalan → Start XAMPP MySQL
- Tabel `discount` kosong → Insert data via DBeaver
- Route tidak ada → Cek `routes/web.php`

---

### Error 419 Page Expired (CSRF Token)

**Penyebab**: Session expired atau CSRF mismatch

**Solusi**:
1. Hard refresh: `Ctrl + Shift + R`
2. Clear cache Laravel:
   ```powershell
   php artisan cache:clear
   php artisan config:clear
   ```
3. Logout dan login lagi

---

## 📊 Summary Testing Checklist

Checklist untuk Pak Dosen:

- [ ] **Test 1**: Boost request form tersubmit dan redirect ke payment
- [ ] **Test 2**: Modal voucher terbuka dan load 3 vouchers dari database
- [ ] **Test 3**: Voucher ter-apply dan total harga ter-kalkulasi dengan benar
- [ ] **Test 4**: Payment process berhasil dan redirect ke success page
- [ ] **Test 5**: Success page menampilkan order ID dan breakdown harga
- [ ] **Scenario A**: Payment tanpa voucher berfungsi
- [ ] **Scenario B**: Cancel modal voucher tidak mengubah apapun
- [ ] **Scenario C**: Ganti voucher meng-override voucher sebelumnya
- [ ] **Scenario D**: Voucher dengan min_transaction ter-filter dengan benar

---

## 🎓 Penjelasan untuk Dosen

### Apa yang Sudah Dikerjakan?

1. **Backend - VoucherController**
   - Method `getAvailable()`: Fetch vouchers dari DB dengan filter active, expired, min_transaction
   - Method `validate()`: Validasi voucher (optional, untuk fitur lanjutan)

2. **Backend - Session Management**
   - Boost request data disimpan di session (temporary storage)
   - Payment result disimpan di session untuk ditampilkan di success page

3. **Backend - Payment Processing**
   - Kalkulasi total dengan diskon
   - Support voucher optional (bisa tanpa voucher)

4. **Frontend - Dynamic Voucher Modal**
   - AJAX fetch vouchers via API
   - Display vouchers secara dynamic (bukan hardcode)
   - Handle loading state, empty state, error state

5. **Database Integration**
   - Menggunakan Eloquent Model `Discount`
   - Query dengan filter (active, expiry, min_transaction)

### Apa yang Belum Dikerjakan? (Nunggu Teman)

1. ❌ **Create Order** ke table `order` dan `order_items`
2. ❌ **Cart Items** integration (masih hardcode Rp 60.000)
3. ❌ **Real Product Data** dari table `services`

### Kenapa Pendekatan Ini?

- **Independent Development**: Fitur voucher bisa dikerjakan tanpa dependency ke cart/order
- **Easy Integration**: Nanti tinggal ganti hardcode jadi dynamic dari cart
- **Testable Now**: Bisa ditest dan demo sekarang dengan data mock

---

## 📞 Kontak

Jika ada pertanyaan atau error saat testing, hubungi developer.

**Happy Testing! 🚀**
