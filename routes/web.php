<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VoucherCustomerController;
use App\Http\Controllers\CartVoucherController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderDownloadController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FlavourController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MembershipController;

// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');

Route::get('/process-queue', function () {
    // Opsi 1: Proses semua job yang ada di queue saat ini (tidak berjalan terus)
    Artisan::call('queue:work', ['--stop-when-empty' => true]);
    
    // Opsi 2: Proses hanya 1 job
    // Artisan::call('queue:work', ['--once' => true]);
    
    return 'Processed queue jobs';
}); // Tambahkan middleware admin untuk keamanan

Route::get('/symlink', function () {
    Artisan::call('storage:link');
    return 'Symlink created successfully';
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Products
Route::resource('products', ProductController::class)->only(['index', 'show']);
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/flavour/{flavour:slug}', [FlavourController::class, 'show'])->name('flavours.show');

Auth::routes();
// Add these routes
Route::middleware(['auth'])->group(function () {

    Route::prefix('membership')->group(function () {
        Route::get('/', [MembershipController::class, 'index'])->name('membership.index');
        Route::get('/checkout/{plan}', [MembershipController::class, 'checkout'])->name('membership.checkout');
        Route::post('/process/{plan}', [MembershipController::class, 'process'])->name('membership.process');
        Route::get('/finish/{transaction}', [MembershipController::class, 'finish'])->name('membership.finish');
        Route::get('/error/{transaction}', [MembershipController::class, 'error'])->name('membership.error');
        Route::post('/notification', [MembershipController::class, 'notification'])->name('membership.notification');
        Route::get('/history', [MembershipController::class, 'history'])->name('membership.history');
    });
    // Cart
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');
        Route::post('/update/{productId}', [CartController::class, 'update'])->name('cart.update');
        Route::post('/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
    });


    // Payment
    Route::post('payment/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('payment/finish/{order}', [PaymentController::class, 'finish'])->name('payment.finish');
    Route::get('payment/error/{order}', [PaymentController::class, 'error'])->name('payment.error');
    Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');

    // Checkout
    Route::prefix('checkout')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/', [CheckoutController::class, 'store'])->name('checkout.store');
    });

    // Orders
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
    });

    Route::post('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    Route::get('/vouchers', [VoucherCustomerController::class, 'index'])->name('vouchers.customer.index');
    Route::post('/vouchers/{voucher}/claim', [VoucherCustomerController::class, 'claim'])->name('vouchers.customer.claim');

    Route::post('cart/voucher/apply', [CartVoucherController::class, 'apply'])->name('cart.voucher.apply');
    Route::post('cart/voucher/remove', [CartVoucherController::class, 'remove'])->name('cart.voucher.remove');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/order/{order}/download', OrderDownloadController::class)->name('order.download');
});
