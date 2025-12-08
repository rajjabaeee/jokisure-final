# 🧪 Testing Guide - Order & Payment Flow

## ✅ Changes Summary

### 📁 Files Modified:
1. **boost-request.blade.php** - Fixed boost priority values to match database
2. **UiController.php** - Removed payment methods, kept only boost request handling
3. **PaymentController.php** - Added payment flow (index, process, success)
4. **OrderController.php** - Added createOrder() method for order creation
5. **payment.blade.php** - Dynamic payment methods & admin fee display
6. **payment-success.blade.php** - Updated to use new order data structure
7. **routes/web.php** - Updated routes to use proper controllers

---

## 🎯 How to Test Your Feature

### **Prerequisites:**
1. Make sure you're logged in as a user
2. Make sure you have at least one item in cart (or use hardcoded testing)
3. Database tables populated:
   - ✅ `boost_priority` (4 records)
   - ✅ `payment_method` (5 records)
   - ✅ `order_status` (4 records including 'Pending')
   - ✅ `discount` (3 vouchers)

---

### **Testing Flow:**

#### **Step 1: Boost Request Form**
1. Navigate to: `/boost/request`
2. **What to check:**
   - ✅ Name, email, phone fields auto-filled with your user data
   - ✅ All fields are required
   - ✅ Email validation works (must have `@`)
   - ✅ Boost priority radio buttons show: "VIP+ (>6 hours)", "VIP (<6 hours)", "Same Day (1 day)", "Regular (1 - 2 day)"
3. **Fill the form:**
   - Contact details (pre-filled)
   - Game username & password
   - Select any boost priority
   - Check the consent checkbox
4. **Click "Submit"**
   - Should redirect to `/payment`

---

#### **Step 2: Payment Page**
1. **What to check:**
   - ✅ Payment methods dropdown shows 5 options from database (GoPay, OVO, DANA, ShopeePay, Credit Card)
   - ✅ Pack Price displays correctly (Rp 60.000 or your cart total)
   - ✅ Discount shows "Rp 0" initially
   - ✅ Services & Taxes shows "Rp 0" initially

2. **Select Payment Method:**
   - Choose any payment method (e.g., GoPay)
   - ✅ Services & Taxes should update to show admin fee (e.g., Rp 1.000 for GoPay)
   - ✅ Total Price should update: Pack Price + Admin Fee

3. **Apply Voucher (Optional):**
   - Click "Voucher" button
   - ✅ Modal opens showing available vouchers from database
   - ✅ Should see 3 vouchers: Flash Sale (20%), Member Baru (15%), Member Loyalty (10%)
   - Select a voucher
   - Click "Apply"
   - ✅ Discount amount updates (e.g., -Rp 12.000 for 20% off Rp 60.000)
   - ✅ Total Price recalculates: Pack Price - Discount + Admin Fee

4. **Click "Pay"**
   - Should redirect to order creation

---

#### **Step 3: Order Creation**
1. **Backend Process (automatic):**
   - Creates `WorkOrder` record
   - Creates `OrderItem` records from cart
   - Creates `Payment` record
   - Deletes cart items
   - Clears session data
   
2. **Should redirect to:** `/payment/success`

---

#### **Step 4: Payment Success Page**
1. **What to check:**
   - ✅ Shows "Payment Successful!" message
   - ✅ Displays Order ID (UUID format)
   - ✅ Has "Back to Homepage" and "View Order" buttons

2. **Click "View Order":**
   - Should go to `/orders` (My Orders page)
   - ✅ Your new order should appear in the list

---

## 🔍 Expected Database Changes

After completing one order, check these tables:

### **work_order:**
```sql
SELECT * FROM work_order ORDER BY order_date DESC LIMIT 1;
```
**Expected:**
- `boost_priority_id` = UUID matching your selection
- `order_status_id` = UUID for "Pending" status
- `subtotal_amount` = Cart total (e.g., 60000)
- `discount_id` = UUID of voucher (if applied) or NULL
- `discount_amount` = Discount value (e.g., 12000 for 20%) or 0
- `total_amount` = Subtotal - Discount + Admin Fee

### **order_items:**
```sql
SELECT * FROM order_items WHERE order_id = '<your_order_id>';
```
**Expected:**
- One row per cart item
- `game_username` = What you entered in boost request
- `game_password_encrypt` = Encrypted password

### **payment:**
```sql
SELECT * FROM payment WHERE order_id = '<your_order_id>';
```
**Expected:**
- `method_id` = UUID of selected payment method
- `payment_status_id` = Same as order status (Pending)
- `gateway_reference` = NULL (will be filled by payment gateway later)

### **cart_items:**
```sql
SELECT * FROM cart_items WHERE cart_id = '<your_cart_id>';
```
**Expected:**
- Should be EMPTY (deleted after order creation)

---

## ⚠️ Common Issues & Solutions

### **Issue 1: "Please fill the boost request form first"**
**Cause:** Session data missing  
**Solution:** Go back to `/boost/request` and submit the form again

### **Issue 2: Payment methods not showing**
**Cause:** Database `payment_method` table empty  
**Solution:** Run the INSERT query for payment methods

### **Issue 3: "Invalid boost priority selected"**
**Cause:** Boost priority name mismatch  
**Solution:** Make sure database has exact values: "VIP+ (>6 hours)", "VIP (<6 hours)", etc.

### **Issue 4: Voucher modal shows "Failed to load vouchers"**
**Cause:** API route not working or discount table empty  
**Solution:** 
- Check `/api/vouchers/available` endpoint
- Verify discount table has active vouchers

### **Issue 5: Order not created**
**Cause:** Missing cart items  
**Solution:** Add items to cart first, or check if cart is empty

---

## 🧪 Quick Test Checklist

- [ ] Boost request form auto-fills user data
- [ ] Boost priority values match database
- [ ] Email validation works (requires @)
- [ ] Payment methods load from database (5 methods)
- [ ] Admin fee updates when payment method changes
- [ ] Voucher modal loads 3 vouchers
- [ ] Discount calculation works correctly
- [ ] Total price updates dynamically
- [ ] Order created in database
- [ ] Cart items deleted after order
- [ ] Payment record created
- [ ] Redirects to success page
- [ ] Order ID displayed on success page

---

## 🎉 Success Indicators

**You'll know it works when:**
1. ✅ You can select boost priority that matches database
2. ✅ Payment methods show from database with correct admin fees
3. ✅ Vouchers load and apply discounts correctly
4. ✅ Order appears in `work_order` table with correct data
5. ✅ Order items created with encrypted password
6. ✅ Payment record exists
7. ✅ Cart is empty after order
8. ✅ Success page shows real order ID (UUID)

---

## 🚀 Next Steps After Testing

Once testing is complete, you can:
1. Integrate real payment gateway (update `gateway_reference`)
2. Add order status transitions (Pending → On Progress → Completed)
3. Implement booster assignment logic
4. Add order tracking timeline
5. Send email notifications

---

**Happy Testing! 🎯**
