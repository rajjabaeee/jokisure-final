# JokiSure Routes & Controllers Mapping

## Summary
All views now have corresponding controllers with `show()` or equivalent methods. Routes are fully wired and data-driven.

---

## PUBLIC ROUTES (No Auth Required)

| Route | Method | Controller | View | Purpose |
|-------|--------|-----------|------|---------|
| `/` | GET | `UiController@splash` | `auth.splash` | Landing/splash page |
| `/splash` | GET | `UiController@splash` | `auth.splash` | Splash page |
| `/login` | GET | Closure | `auth.login` | Login form |
| `/login` | POST | `LoginController@login` | - | Process login |
| `/signup` | GET | `UiController@signup` | `auth.register` | Signup form |
| `/signup/verify-phone` | POST | `RegisterController@storeDataForOTP` | - | Store signup data and redirect to OTP |
| `/otp` | GET | `UiController@otp` | `auth.otp-verify` | OTP verification form |
| `/otp` | POST | `RegisterController@verifyOTP` | - | Verify OTP code |
| `/otp/verify-demo` | GET | Closure | - | Demo OTP verification (dev only) |
| `/signup` | POST | `RegisterController@register` | - | Create user account |
| `/reset-password` | GET | `UiController@reset` | `auth.reset-password` | Password reset form |

---

## PROTECTED ROUTES (Auth Required)

### Marketplace
| Route | Method | Controller | View | Purpose |
|-------|--------|-----------|------|---------|
| `/home` | GET | `UiController@home` | `marketplace.home` | Marketplace homepage |
| `/games` | GET | `GameController@index` | `marketplace.games` | List all games |
| `/games/{game}` | GET | `GameController@show` | `marketplace.game-detail` | Show single game detail |
| `/boosters` | GET | `UiController@boosters` | `marketplace.boosters` | List all boosters |
| `/cart` | GET | `CartController@index` | `marketplace.cart` | Shopping cart |
| `/cart/add` | POST | `CartController@add` | - | Add item to cart |
| `/cart/remove/{item}` | POST | `CartController@remove` | - | Remove item from cart |
| `/chat` | GET | `ChatController@index` | `marketplace.chat` | Chat listing |
| `/game-detail` | GET | View | `marketplace.game-detail` | Game detail (fallback) |

### Service & Orders
| Route | Method | Controller | View | Purpose |
|-------|--------|-----------|------|---------|
| `/service/detail` | GET | `UiController@serviceDetailConfirm` | `orders.service-detail` | Service detail & confirmation |
| `/boost/request` | GET | `UiController@boostRequest` | `orders.boost-request` | Boost request form |
| `/payment` | GET/POST | `UiController@payment` | `orders.payment` | Payment page |
| `/payment/success` | GET/POST | `UiController@paymentSuccess` | `orders.payment-success` | Payment success confirmation |

### Orders (Dynamic)
| Route | Method | Controller | View | Purpose |
|-------|--------|-----------|------|---------|
| `/orders` | GET | `OrderController@index` | `orders.my-orders` | List authenticated user's orders |
| `/orders/{order}` | GET | `OrderController@show` | `orders.order-{status}` | Order detail (status-specific view) |
| `/orders` | POST | `OrderController@store` | - | Create new order |
| `/orders/{order}/status` | POST | `OrderController@updateStatus` | - | Update order status |
| `/track/{order}` | GET | `OrderController@track` | `orders.track-order-{status}` | Track order (status-specific view) |
| `/track/{order}/events` | POST | `OrderController@addEvent` | - | Add timeline event to order |

### User Profile
| Route | Method | Controller | View | Purpose |
|-------|--------|-----------|------|---------|
| `/profile` | GET | `ProfileController@show` | `profile.my-profile` | User's profile page |
| `/profile/edit` | GET | `ProfileController@edit` | `profile.edit-profile` | Edit profile form |
| `/profile/update` | POST | `ProfileController@update` | - | Update profile |
| `/booster/profile/{booster}` | GET | `BoosterController@show` | `booster.profile` | Booster's profile |
| `/favorites/boosters` | GET | `UiController@favoriteBoosters` | `user.favorites-boosters` | Favorite boosters list |
| `/favorites/boosts` | GET | `UiController@favoriteBoosts` | `user.favorites-boosts` | Favorite boosts list |

### Auth
| Route | Method | Controller | Purpose |
|-------|--------|-----------|---------|
| `/logout` | POST | `LoginController@logout` | Logout user |

---

## Controllers Structure

### OrderController
- `index()` - List orders for authenticated user (fetches from DB)
- `show($orderId)` - Show order detail (routes to status-specific view)
- `store()` - Create new order
- `updateStatus()` - Update order status
- `track($orderId)` - Show order tracking (routes to status-specific track view)
- `addEvent()` - Add timeline event to order

### ProfileController
- `show()` - Display authenticated user's profile
- `edit()` - Show edit profile form
- `update()` - Update profile data

### BoosterController
- `show($boosterId)` - Display booster's profile by ID

### GameController
- `index()` - List all games
- `show($gameId)` - Show game detail

### CartController
- `index()` - Display shopping cart
- `add()` - Add item to cart
- `remove($itemId)` - Remove item from cart

### ChatController
- `index()` - List chats for authenticated user

### UiController
- `splash()` - Show splash/landing page
- `login()` - Show login form
- `signup()` - Show signup form
- `otp()` - Show OTP verification form
- `reset()` - Show password reset form
- `home()` - Show marketplace home
- `boosters()` - Show boosters list
- `serviceDetailConfirm()` - Show service detail & confirmation
- `boostRequest()` - Show boost request form
- `payment()` - Show payment page
- `paymentSuccess()` - Show payment success page
- `profile()` - *(deprecated, use ProfileController@show)*
- `editProfile()` - *(deprecated, use ProfileController@edit)*
- `boosterProfile()` - *(deprecated, use BoosterController@show)*
- `favoriteBoosters()` - Show favorite boosters
- `favoriteBoosts()` - Show favorite boosts

---

## Data Models Used

- **User** - Authenticated users (buyer or booster)
- **WorkOrder** - Orders placed (has events via `WorkOrderEvent`)
- **WorkOrderEvent** - Timeline events for orders
- **OrderItem** - Items in an order
- **OrderStatus** - Order status (pending, progress, completed, waitlist)
- **Payment** - Payment records
- **Game** - Available games
- **Service** - Services offered by boosters
- **Chat** - Chat messages between users
- **Booster** - Booster profile (User with booster role)

---

## Important Notes

1. **Dynamic Views**: Order detail and tracking views are now dynamic, selected based on order status
2. **Ownership Checks**: `OrderController` enforces buyer ownership before displaying orders
3. **Database Persistence**: All order operations (create, update, track events) are persisted to DB
4. **Route Naming**: All routes follow a consistent naming convention for easy reference in views
5. **Auth Middleware**: Protected routes require user to be authenticated via middleware

---

## Testing Checklist

- [ ] Verify `php artisan route:list` shows all routes
- [ ] Test login/signup flow
- [ ] Navigate to `/orders` and verify order listing
- [ ] Click on an order and verify detail page loads
- [ ] Test `/profile` and profile edit
- [ ] Test `/games` and game detail
- [ ] Test `/cart` operations
- [ ] Test `/chat` listing
- [ ] Test order tracking `/track/{order}`
- [ ] Test adding events to order

