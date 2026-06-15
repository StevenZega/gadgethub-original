<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\CustomerProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;


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
});

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::resource('products', ProductController::class);

        Route::resource('promos', PromoController::class);

        Route::resource('customer-profiles', CustomerProfileController::class);
});