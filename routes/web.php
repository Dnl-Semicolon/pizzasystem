<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CrustController;
use App\Http\Controllers\CrustPriceAdditionController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\Admin\PizzaController as AdminPizzaController;
use App\Http\Controllers\PizzaOrderItemDetailController;
use App\Http\Controllers\PizzaOrderItemToppingController;
use App\Http\Controllers\PizzaSizeController;
use App\Http\Controllers\PizzaSizePriceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ToppingController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//->middleware(['auth', 'verified'])

Route::get('/', function () {
    $featuredProducts = Product::where('is_active', true)
        ->where('type', 'pizza')
        ->with('pizza.sizePrices.size')
        ->limit(6)
        ->get();

    return view('home', compact('featuredProducts'));
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('/payments', [PaymentHistoryController::class, 'index'])->name('payment.index');
});

Route::get('/pizzas', [PizzaController::class, 'index'])->name('pizzas.index');
Route::get('/pizzas/{id}', [PizzaController::class, 'show'])->name('pizzas.show');
Route::get('/admin/pizzas', [AdminPizzaController::class, 'index'])->name('admin.pizzas.index');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::post('/cart/clear', function () {
    session()->forget('cart');
    return back()->with('success', 'Cart has been cleared.');
})->name('cart.clear');

Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
Route::post('/payment', [PaymentController::class, 'process'])->name('payment.process');
Route::get('/payment/confirm/{order}', [PaymentController::class, 'confirm'])->name('payment.confirm');


Route::get('/pizzaSizes', [PizzaSizeController::class, 'index'])->name('pizzaSizes.index');
Route::get('/crusts', [CrustController::class, 'index'])->name('crusts.index');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
Route::get('/toppings', [ToppingController::class, 'index'])->name('toppings.index');
Route::get('/pizzaSizePrices', [PizzaSizePriceController::class, 'index'])->name('pizzaSizePrices.index');
Route::get('/crustPriceAdditions', [CrustPriceAdditionController::class, 'index'])->name('crustPriceAdditions.index');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/menu', [OrderController::class, 'create'])->name('orders.create'); // public
Route::post('/orders/store', [OrderController::class, 'store'])->middleware('auth')->name('orders.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::get('/orderItems', [OrderItemController::class, 'index'])->name('orderItems.index');
Route::get('/pizzaOrderItemDetails', [PizzaOrderItemDetailController::class, 'index'])->name('pizzaOrderItemDetails.index');
Route::get('/pizzaOrderItemToppings', [PizzaOrderItemToppingController::class, 'index'])->name('pizzaOrderItemToppings.index');

Route::get('/test-session', function () {
    dd(session()->all());
});

Route::get('/test-user', fn() => dd(Auth::user()?->name ?? 'Not logged in'));

Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
Route::patch('/admin/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');

require __DIR__.'/auth.php';
