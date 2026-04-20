<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/

// ADMIN
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\SettingController;

// FRONTEND
use App\Http\Controllers\Frontend\HomeController;


/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

// HOME
Route::get('/', [HomeController::class, 'index'])->name('home');

// COUPONS
Route::get('/coupons', [HomeController::class, 'allCoupons'])->name('coupons.all');

// STORES
Route::get('/stores', [HomeController::class, 'allStores'])->name('stores.all');
Route::get('/store/{slug}', [HomeController::class, 'store'])->name('store.single');

// CATEGORIES
Route::get('/categories', [HomeController::class, 'allCategories'])->name('categories.all');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.single');

// BLOGS
Route::get('/blogs', [HomeController::class, 'allBlogs'])->name('blogs.all');
Route::get('/blog/{slug}', [HomeController::class, 'singleBlog'])->name('blog.single');

// NAVBAR PAGES
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// FOOTER PAGES
Route::get('/privacy-policy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms-condition', [HomeController::class, 'terms'])->name('terms');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');


/*
|--------------------------------------------------------------------------
| ADMIN AUTH ROUTES
|--------------------------------------------------------------------------
*/

// LOGIN
Route::get('/admin/login', [AuthController::class, 'loginForm'])
    ->name('admin.login');

Route::post('/admin/login', [AuthController::class, 'login'])
    ->name('admin.login.submit');

// FORGOT PASSWORD
Route::get('/admin/forgot-password', [AuthController::class, 'forgotForm'])
    ->name('admin.forgot');

Route::post('/admin/forgot-password', [AuthController::class, 'forgotSubmit'])
    ->name('admin.forgot.submit');

// LOGOUT
Route::get('/admin/logout', [AuthController::class, 'logout'])
    ->name('admin.logout');


/*
|--------------------------------------------------------------------------
| ADMIN PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // DASHBOARD
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    // PROFILE
    Route::get('/profile', [AuthController::class, 'profile'])
        ->name('profile');

    Route::post('/profile', [AuthController::class, 'updateProfile'])
        ->name('profile.update');

    // CRUD
    Route::resource('categories', CategoryController::class);
    Route::resource('stores', StoreController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('blogs', BlogController::class);

    // SETTINGS
    Route::get('/settings', [SettingController::class, 'index'])
        ->name('settings');

    Route::post('/settings', [SettingController::class, 'save'])
        ->name('settings.save');
});