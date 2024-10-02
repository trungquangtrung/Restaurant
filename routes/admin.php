<?php

use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Middleware\CheckUserIsAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('admin/dashboard', function (){
    return view('admin.pages.dashboard');
});

Route::get('admin/product', function (){
    return view('admin.pages.product');
});

Route::get('admin/blog', function (){
    return view('admin.pages.blog');
});

Route::prefix('admin/product_category')
->name('admin.product_category.')
->middleware(CheckUserIsAdmin::class)
->controller(ProductCategoryController::class)->group(function(){
    Route::get('/', 'index')->name('index');
    Route::get('create','create')->name('create');
    Route::post('store', 'store')->name('store');
    Route::post('delete/{id}', 'destroy')->name('delete');
    Route::get('detail/{id}', 'detail')->name('detail');
    Route::post('update/{id}', 'update')->name('update');
});


Route::prefix('admin/coupons')->name('admin.coupons.')->group(function() {
    Route::get('/', [CouponController::class, 'index'])->name('index'); // Hiển thị danh sách mã giảm giá
    Route::get('/create', [CouponController::class, 'create'])->name('create'); // Tạo mới mã giảm giá
    Route::post('/', [CouponController::class, 'store'])->name('store'); // Lưu mã giảm giá mới
    Route::delete('/{coupon}', [CouponController::class, 'destroy'])->name('destroy'); // Xoá mã giảm giá
});


Route::prefix('admin')->middleware(CheckUserIsAdmin::class)->name('admin.')->group(function () {
    Route::resource('product', ProductController::class);
});
Route::post('admin/product/make-slug', [ProductController::class, 'makeSlug'])->name('admin.product.make.slug')->middleware(CheckUserIsAdmin::class);
