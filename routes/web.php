<?php

use App\Models\category;
use App\Models\page;
use App\Models\product;
use App\Models\slider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\DashboardController;

// Auth Routes
Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');

Route::post('/logout', function() {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Public Routes
Route::get('/', function () {
    $appname = Config::get('app.name');
    $sliders = slider::all();
    $menu = page::where(['is_group'=>0,'is_active'=>1])->get();
    $submenu = page::where(['is_group'=>1,'is_active'=>1])->get();
    $categories = category::all();
    $products = product::all();
    return view('home',compact('appname','sliders','menu','submenu','categories','products'));
});

Route::get('/page/{page:id}', function (page $page) {
    $appname = Config::get('app.name');
    $menu = page::where(['is_group'=>0,'is_active'=>1])->get();
    $submenu = page::where(['is_group'=>1,'is_active'=>1])->get();
    $categories = category::all();
    return view('page',compact('appname','menu','submenu','categories','page'));
});

Route::get('/product/{product:id}', function (product $product) {
    $appname = Config::get('app.name');
    $menu = page::where(['is_group'=>0,'is_active'=>1])->get();
    $submenu = page::where(['is_group'=>1,'is_active'=>1])->get();
    $categories = category::all();
    return view('detail_product',compact('appname','menu','submenu','categories','product'));
});

// Cart Routes
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
});

// Transaction Routes
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [App\Http\Controllers\TransactionController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [App\Http\Controllers\TransactionController::class, 'process'])->name('checkout.process');
    Route::get('/transaction/success', [App\Http\Controllers\TransactionController::class, 'success'])->name('transaction.success');
    Route::get('/transaction/pending', [App\Http\Controllers\TransactionController::class, 'pending'])->name('transaction.pending');
    Route::get('/transaction/error', [App\Http\Controllers\TransactionController::class, 'error'])->name('transaction.error');
});

// Midtrans Callback
Route::post('/midtrans/callback', [App\Http\Controllers\TransactionController::class, 'callback'])->name('midtrans.callback');

// Admin Routes
Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('sliders', \App\Http\Controllers\Admin\SliderController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
});