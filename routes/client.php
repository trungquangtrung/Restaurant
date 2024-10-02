<?php

use App\Http\Controllers\Client\CouponController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\GoogleController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\VNPAYController;
use App\Mail\OrderEmailCustomer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/home', [HomeController::class, 'index'])->name('client.home');

Route::get('/contact', [ContactController::class, 'showForm'])->name('client.contact.form');
Route::post('/contact', [ContactController::class, 'submitForm'])->name('client.contact');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{slug}', [ProductController::class, 'detail'])->name('product.detail');
Route::get('/product/show/{id}', [ProductController::class, 'show'])->name('product.show');
// Cart Routes
Route::middleware('auth')->group(function () {
    Route::get('cart/add-product/{productId?}/qty/{qty?}', [CartController::class, 'addProductToCart'])
        ->name('client.cart.add-product');

    Route::get('cart', [CartController::class, 'index'])
        ->name('client.cart');


    Route::DELETE('cart/delete/{productId?}', [CartController::class, 'deleteProductToCart'])
        ->name('client.cart.delete-product');

    Route::post('checkout', [CartController::class, 'checkout'])
        ->name('client.checkout');

    Route::post('place-order', [CartController::class, 'placeOrder'])
        ->name('client.placeOrder');
});

Route::post('/apply-coupon', [CouponController::class, 'applyCoupon'])->name('apply.coupon');

// Google Authentication Routes
Route::get('google/callback', [GoogleController::class, 'callback'])->name('client.google.callback');
Route::get('google/redirect', [GoogleController::class, 'redirect'])->name('client.google.redirect');

// VNPAY Callback
Route::post('/vnpay/callback', [CartController::class, 'vnpayCallBack'])->name('vnpay.callback');

Route::post('/vnpay/payment', [VNPAYController::class, 'payment'])->name('vnpay.payment');
