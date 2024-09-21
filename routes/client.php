<?php

use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\GoogleController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController;
use App\Mail\OrderEmailCustomer;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;



Route::get('home', [HomeController::class, 'index'])->name('client.home');

Route::get('contact', function(){
    return view('client.pages.contact');
});

Route::get('product/{slug}', [ProductController::class, 'detail'])->name('client.product.slug');

Route::get('cart/add-product/{productId?}/qty/{qty?}', [CartController::class, 'addProductToCart'])
->name('client.cart.add-product')->middleware('auth');

Route::get('cart', [CartController::class, 'index'])
->name('client.cart')->middleware('auth');

Route::post('cart/delete/{productId?}', [CartController::class, 'deleteProductToCart'])
    ->name('client.cart.delete-product')->middleware('auth');
Route::post('checkout', [CartController::class, 'checkout'])->name('client.checkout')->middleware('auth');

Route::post('place-order', [CartController::class, 'placeOrder'])->name('client.cart.checkout')->middleware('auth');

Route::get('test-send-mail',function(){
    $name = Auth::user()->name;
    Mail::to('trungquang00000@gmail.com')->send(new OrderEmailCustomer($name));
});

Route::get('google/callback', [GoogleController::class, 'callback'])->name('client.google.callback');
Route::get('google/redirect', [GoogleController::class, 'redirect'])->name('client.google.redirect');
Route::get('vnpay/callback', [CartController::class, 'vnpayCallBack'])->name('client.vnpay.callback');
