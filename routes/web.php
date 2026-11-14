<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MarketingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - E-Commerce
|--------------------------------------------------------------------------
*/

// Midtrans Webhook Callback & Connection Test
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handle'])->name('midtrans.callback');
Route::get('/midtrans/test-connection', function () {
    $service = app(\App\Services\MidtransService::class);
    $dummyOrder = \App\Models\Order::with(['items', 'user', 'payment'])->latest()->first();
    
    if (!$dummyOrder) {
        return response()->json(['status' => 'error', 'message' => 'Belum ada order di database untuk diuji.']);
    }

    $token = $service->createSnapToken($dummyOrder);
    return response()->json([
        'status' => 'success',
        'server_key_loaded' => substr(config('services.midtrans.server_key') ?: env('MIDTRANS_SERVER_KEY'), 0, 18) . '...',
        'client_key_loaded' => config('services.midtrans.client_key') ?: env('MIDTRANS_CLIENT_KEY'),
        'snap_token_result' => $token,
        'is_real_midtrans_token' => !str_starts_with($token ?? '', 'demo-snap-'),
        'order_number' => $dummyOrder->order_number,
        'grand_total' => $dummyOrder->grand_total,
    ]);
});


// 1. Homepage & Public Catalog
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shops.show');

// 2. Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// 3. Authenticated Customer Shopping & Account Routes
Route::middleware('auth')->group(function () {
    // Khusus Pelanggan / Customer (Admin dilarang belanja)
    Route::middleware('customer.only')->group(function () {
        // Cart Routes
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::post('/cart/buy-now', [CartController::class, 'buyNow'])->name('cart.buy-now');
        Route::put('/cart/item/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::post('/cart/item/{id}/toggle', [CartController::class, 'toggle'])->name('cart.toggle');
        Route::post('/cart/toggle-all', [CartController::class, 'toggleAll'])->name('cart.toggle-all');
        Route::delete('/cart/item/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

        // Checkout Routes
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout/voucher', [CheckoutController::class, 'checkVoucher'])->name('checkout.voucher');
        Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    });

    // Wishlist Routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/wishlist/{product}/move-to-cart', [WishlistController::class, 'moveToCart'])->middleware('customer.only')->name('wishlist.move-to-cart');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // Address Routes
    Route::get('/account/addresses', [AddressController::class, 'index'])->name('customer.addresses.index');
    Route::post('/account/addresses', [AddressController::class, 'store'])->name('customer.addresses.store');
    Route::put('/account/addresses/{address}', [AddressController::class, 'update'])->name('customer.addresses.update');
    Route::post('/account/addresses/{address}/primary', [AddressController::class, 'setPrimary'])->name('customer.addresses.primary');
    Route::delete('/account/addresses/{address}', [AddressController::class, 'destroy'])->name('customer.addresses.destroy');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/voucher', [CheckoutController::class, 'checkVoucher'])->name('checkout.voucher');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // Account Profile (Spec: Mengelola informasi profil dasar)
    Route::get('/account/profile', [App\Http\Controllers\Customer\ProfileController::class, 'edit'])->name('customer.profile');
    Route::put('/account/profile', [App\Http\Controllers\Customer\ProfileController::class, 'update'])->name('customer.profile.update');

    // Phase 4: Order System & Review Routes
    Route::get('/orders/finish', [OrderController::class, 'finish'])->name('orders.finish');
    Route::get('/account/orders', [OrderController::class, 'index'])->name('customer.orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{id}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::get('/orders/{id}/payment-status', [OrderController::class, 'paymentStatus'])->name('orders.payment-status');
    Route::post('/orders/{id}/pay', [OrderController::class, 'pay'])->name('orders.pay');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{id}/confirm-delivered', [OrderController::class, 'confirmDelivered'])->name('orders.confirm-delivered');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Phase 6: Admin Platform Control Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Users Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Categories Management
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Products Management (Spec: Tambah, Lihat, Ubah, Hapus, Gambar, Harga, Stok)
    Route::get('/products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
    Route::post('/products/{product}/toggle-status', [App\Http\Controllers\Admin\ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::delete('/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');

    // Orders Oversight & Management (Spec: Lihat seluruh pesanan, detail, update status pemrosesan & pengiriman)
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');

    // Marketing (Banners Redirect & Vouchers)
    Route::redirect('/marketing/banners', '/admin/marketing/vouchers')->name('marketing.banners');

    Route::get('/marketing/vouchers', [MarketingController::class, 'vouchers'])->name('marketing.vouchers');
    Route::post('/marketing/vouchers', [MarketingController::class, 'storeVoucher'])->name('marketing.vouchers.store');
    Route::post('/marketing/vouchers/{voucher}/toggle', [MarketingController::class, 'toggleVoucher'])->name('marketing.vouchers.toggle');
    Route::delete('/marketing/vouchers/{voucher}', [MarketingController::class, 'destroyVoucher'])->name('marketing.vouchers.destroy');
});

// Seller Redirect (Only Admin & Customer are active)
Route::redirect('/seller/dashboard', '/admin/dashboard');
Route::redirect('/seller', '/admin/dashboard');
