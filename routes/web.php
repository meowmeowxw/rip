<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Customer\CustomerSettingsController;
use App\Http\Controllers\Auth\PasswordChangeController;
use App\Http\Controllers\Seller\SellerRegisterController;
use App\Http\Controllers\Seller\SellerSettingsController;
use App\Http\Controllers\Seller\SellerProductsController;
use App\Http\Controllers\Seller\SellerOrdersController;
use App\Http\Controllers\Seller\SellerPublicController;
use App\Http\Controllers\Customer\CustomerCartController;
use App\Http\Controllers\Customer\CustomerOrdersController;
use App\Http\Controllers\SearchController;
use App\Models\User;
use App\Models\Seller;
use App\Models\Order;
use App\Models\Category;
use App\Models\Product;

/*
|-------------------------------------------------------------------------- | Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('/statistics')->group(function() {
    Route::get('/most-selled-beers', [\App\Http\Controllers\StatisticsController::class, 'mostSelledBeers'])
        ->name('statistics.mostselledbeers');
    Route::get('/customers-who-purchased-more', [\App\Http\Controllers\StatisticsController::class, 'customersWhoPurchasedMore'])
        ->name('statistics.customerswhopurchasedmore');
    Route::get('/sellers-who-sold-more', [\App\Http\Controllers\StatisticsController::class, 'sellerWhoSoldMore'])
        ->name('statistics.sellerswhosoldmore');
    Route::get('/customers-who-received-more', [\App\Http\Controllers\StatisticsController::class, 'customersWhoReceivedMoreOrders'])
        ->name('statistics.customerswhoreceivedmore');
});

Route::prefix('/seller')->group(function () {
    Route::get('/register', [SellerRegisterController::class, 'create'])
        ->name('seller.register');
    Route::post('/register', [SellerRegisterController::class, 'store']);

    Route::get('/settings', [SellerSettingsController::class, 'create'])
        ->name('seller.settings');
    Route::post('/settings', [SellerSettingsController::class, 'store']);

    Route::get('/products/', [SellerProductsController::class, 'create'])
        ->name('seller.products');

    Route::post('/product/delete/', [SellerProductsController::class, 'delete'])
        ->name('seller.product.delete');
    Route::post('/product/edit', [SellerProductsController::class, 'edit'])
        ->name('seller.product.edit');
    Route::get('/product/add', [SellerProductsController::class, 'createAdd'])
        ->name('seller.product.add');
    Route::post('/product/add', [SellerProductsController::class, 'add']);

    Route::get('/orders', [SellerOrdersController::class, 'create'])
        ->name('seller.orders');
    Route::get('/order/{id}', [SellerOrdersController::class, 'show'])
        ->name('seller.order.id');
    Route::post('/order/update', [SellerOrdersController::class, 'update'])
        ->name('seller.order.update');

    Route::get('/{id}', [SellerPublicController::class, 'create'])
        ->name('seller.id')
        ->whereNumber('id');
});

Route::prefix('/customer')->group(function () {
    Route::get('/settings', [CustomerSettingsController::class, 'create'])
        ->name('customer.settings');
    Route::post('/settings', [CustomerSettingsController::class, 'store']);

    Route::get('/cart', [CustomerCartController::class, 'create'])
        ->name('customer.cart');
    Route::post('/cart', [CustomerCartController::class, 'store']);

    Route::post('/cart/buy', [CustomerCartController::class, 'buy'])
        ->name('customer.cart.buy');
    Route::post('/cart/update', [CustomerCartController::class, 'update'])
        ->name('customer.cart.update');
    Route::post('/cart/delete-product', [CustomerCartController::class, 'deleteProduct'])
        ->name('customer.cart.delete-product');

    Route::get('/orders', [CustomerOrdersController::class, 'create'])
        ->name('orders');
    Route::get('/order/{id}', [CustomerOrdersController::class, 'create'])
        ->name('customer.order.id');

});

Route::get('/product/{id}', [ProductController::class, 'view'])
    ->name('product.id')
    ->whereNumber('id');

Route::get('/category/{id}', [CategoryController::class, 'view'])
    ->name('category.id')
    ->whereNumber('id');

Route::get('/search', [SearchController::class, 'search'])
    ->name('search');
Route::post('/search', [SearchController::class, 'search']);

Route::get('/', [ProductController::class, 'show'])
    ->name('dashboard');

Route::post('/user/password-change', [PasswordChangeController::class, 'edit'])
    ->name('password.change');

Route::prefix('/register')->group(function () {
    Route::get('/', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/', [RegisteredUserController::class, 'store']);
});

Route::prefix('/login')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])
        ->middleware('guest')
        ->name('login');

    Route::post('/', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/notifications', function () {
    $user = \Illuminate\Support\Facades\Auth::user();
    $notifications = json_encode($user->unreadNotifications);
    $user->unreadNotifications->markAsRead();
    return $notifications;
})->middleware(['auth'])->name('notifications');
