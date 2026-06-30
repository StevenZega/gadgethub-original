<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\CustomerProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AdminProfileController;


/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);

Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth');

Route::get('/search-products', [HomeController::class, 'searchProducts'])
    ->name('products.search');

Route::get('/dashboard', function () {

    if (!auth()->check()) {
        return redirect('/login');
    }

    if (auth()->user()->role == 'admin') {
        return redirect('/admin/dashboard');
    }

    return redirect('/user/dashboard');

})->middleware('auth');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'admin']);

Route::middleware(['auth'])->group(function () {

    Route::get('/user/dashboard', [HomeController::class, 'index'])
        ->name('user.dashboard');

    Route::get('/user/products/{id}', [HomeController::class, 'show'])
        ->name('user.products.show');

    Route::get('/user/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/user/cart/add/{productId}', [CartController::class, 'addToCart'])
        ->name('cart.add');

    Route::patch('/user/cart/update/{id}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('/user/cart/delete/{id}', [CartController::class, 'destroy'])
        ->name('cart.delete');

    Route::get('/user/profile', [HomeController::class, 'myProfile'])->name('user.profile');
    
    // TAMBAHAN: Route untuk memproses update data profil user
    Route::post('/user/profile/update', [HomeController::class, 'updateProfile'])->name('user.profile.update');
    //Checkout

    Route::get('/checkout/buy-now/{product}',
        [CheckoutController::class, 'buyNow'])
        ->name('checkout.buyNow');

    Route::get('/checkout/cart',
        [CheckoutController::class, 'cart'])
        ->name('checkout.cart');

    Route::post('/checkout/process',
        [CheckoutController::class, 'process'])
        ->name('checkout.process');

    // Payment
    Route::get('/payment/{order}', [PaymentController::class, 'show'])
        ->name('payment.show');
        
    // Rute upload bukti transfer
    Route::post('/payment/{order}/upload', [PaymentController::class, 'uploadProof'])->name('payment.upload');

    // Riwayat Pesanan
    Route::get('/user/orders', [OrderController::class, 'index'])
        ->name('orders.index');
});

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::get('/orders', [AdminOrderController::class, 'index'])
            ->name('admin.orders.index');

        Route::patch('/orders/{order}/approve', [AdminOrderController::class, 'approve'])
            ->name('admin.orders.approve');

        Route::patch('/orders/{order}/reject', [AdminOrderController::class, 'reject'])
            ->name('admin.orders.reject');

        Route::resource('products', ProductController::class);

        Route::resource('promos', PromoController::class);

        Route::resource('customer-profiles', CustomerProfileController::class);

        Route::get('/profile', [HomeController::class, 'adminProfile'])
            ->name('admin.profile');

        Route::post('/profile/update', [HomeController::class, 'updateAdminProfile'])
            ->name('admin.profile.update');

        Route::get('/profile', [AdminProfileController::class, 'index'])
            ->name('admin.profile');

        Route::get('/profile/edit', [AdminProfileController::class,'edit'])
            ->name('admin.profile.edit');

        Route::put('/profile/update', [AdminProfileController::class,'update'])
            ->name('admin.profile.update');
});