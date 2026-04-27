<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\AdsController;

// FRONTEND
use App\Http\Controllers\Frontend\HomeController;

// MODELS
use App\Models\AdminNotification;


/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/coupons', [HomeController::class, 'allCoupons'])->name('coupons.all');

Route::get('/stores', [HomeController::class, 'allStores'])->name('stores.all');
Route::get('/store/{slug}', [HomeController::class, 'store'])->name('store.single');

Route::get('/categories', [HomeController::class, 'allCategories'])->name('categories.all');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.single');


/* BLOGS */
Route::get('/blogs', [HomeController::class, 'allBlogs'])->name('blogs.all');

Route::get('/blogs/category/{category}',
[HomeController::class, 'blogCategory'])
->name('blogs.category');

Route::get('/blog/{slug}',
[HomeController::class, 'singleBlog'])
->name('blog.detail');


Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::post('/contact-send', [HomeController::class, 'contactSend'])
->name('contact.send');

Route::get('/privacy-policy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms-condition', [HomeController::class, 'terms'])->name('terms');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');


/*
|--------------------------------------------------------------------------
| CLICK TRACKING
|--------------------------------------------------------------------------
*/

Route::get('/track-click/{id}', function ($id) {

    DB::table('coupon_clicks')->insert([
        'coupon_id'  => $id,
        'ip'         => request()->ip(),
        'created_at' => now(),
        'updated_at' => now()
    ]);

    AdminNotification::create([
        'title'   => 'Coupon Clicked',
        'message' => 'Coupon ID '.$id.' clicked by visitor',
        'type'    => 'coupon_click',
        'url'     => route('admin.coupons.index'),
        'is_read' => 0
    ]);

    return response()->json([
        'success' => true
    ]);

})->name('track.click');


/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AuthController::class, 'loginForm'])
->name('admin.login');

Route::post('/admin/login', [AuthController::class, 'login'])
->name('admin.login.submit');

Route::get('/admin/forgot-password', [AuthController::class, 'forgotForm'])
->name('admin.forgot');

Route::post('/admin/forgot-password', [AuthController::class, 'forgotSubmit'])
->name('admin.forgot.submit');

Route::get('/admin/logout', [AuthController::class, 'logout'])
->name('admin.logout');


/*
|--------------------------------------------------------------------------
| EMAIL CHANGE
|--------------------------------------------------------------------------
*/

Route::get('/admin/confirm-current-email/{token}',
[AuthController::class,'confirmCurrentEmail'])
->name('admin.confirm.current.email');


/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

/* DASHBOARD */
Route::get('/', [DashboardController::class, 'index'])
->name('dashboard');


/* CLEAR CLICK DATA */
Route::get('/clear-clicks', function () {

    DB::table('coupon_clicks')->truncate();

    return redirect()
    ->route('admin.dashboard')
    ->with('success', 'All click data cleared');

})->name('clear.clicks');


/* REMOVE NOTIFICATION */
Route::post('/notifications/remove/{id}',
[DashboardController::class,'removeNotification'])
->name('notifications.remove');


/* PROFILE */
Route::get('/profile', [AuthController::class, 'profile'])
->name('profile');

Route::post('/profile', [AuthController::class, 'updateProfile'])
->name('profile.update');


/* CRUD */
Route::resource('categories', CategoryController::class);
Route::resource('stores', StoreController::class);
Route::resource('coupons', CouponController::class);
Route::resource('blogs', BlogController::class);


/* BLOG CATEGORY SAVE */
Route::post(
'/blog-category/store',
[BlogController::class,'storeCategory']
)->name('blog.category.store');


/* BLOG CATEGORY DELETE */
Route::delete(
'/blog-category/delete/{id}',
[BlogController::class,'deleteCategory']
)->name('blog.category.delete');


/* CKEDITOR IMAGE UPLOAD */
Route::post(
'/blog/upload-image',
[BlogController::class, 'uploadEditorImage']
)->name('blog.upload.image');


Route::resource('ads', AdsController::class);


/* CONTACT */
Route::get('/contact-messages',
[ContactMessageController::class, 'index'])
->name('contact.messages');

Route::get('/contact-messages/{id}',
[ContactMessageController::class, 'show'])
->name('contact.messages.show');

Route::delete('/contact-messages/{id}',
[ContactMessageController::class, 'destroy'])
->name('contact.messages.delete');

Route::post(
'/contact-messages/reply/{id}',
[ContactMessageController::class,'reply']
)->name('contact.messages.reply');


/* Import Export Coupons, Stores, Categories, Blogs */
Route::get(
'/coupons-export',
[CouponController::class,'export']
)->name('coupons.export');

Route::post(
'/coupons-import',
[CouponController::class,'import']
)->name('coupons.import');

Route::get(
'/stores-export',
[StoreController::class,'export']
)->name('stores.export');

Route::post(
'/stores-import',
[StoreController::class,'import']
)->name('stores.import');

Route::get(
'/categories-export',
[CategoryController::class,'export']
)->name('categories.export');

Route::post(
'/categories-import',
[CategoryController::class,'import']
)->name('categories.import');

Route::get(
'/blogs-export',
[BlogController::class,'export']
)->name('blogs.export');

Route::post(
'/blogs-import',
[BlogController::class,'import']
)->name('blogs.import');


/* READ NOTIFICATION */
Route::get('/notifications/read/{id}', function ($id) {

    $item = AdminNotification::find($id);

    if ($item) {

        $redirectUrl = $item->url ?: route('admin.dashboard');

        $item->update([
            'is_read' => 1
        ]);

        return redirect($redirectUrl);
    }

    return back();

})->name('notifications.read');


/* CLEAR ALL NOTIFICATIONS */
Route::get('/notifications/clear-all', function () {

    AdminNotification::truncate();

    return back();

})->name('notifications.clear');


/* DELETE SINGLE NOTIFICATION */
Route::delete('/notifications/delete/{id}', function ($id) {

    $item = AdminNotification::find($id);

    if ($item) {
        $item->delete();
    }

    return back();

})->name('notifications.delete');


/* SETTINGS */
Route::get('/settings', [SettingController::class, 'index'])
->name('settings');

Route::post('/settings', [SettingController::class, 'save'])
->name('settings.save');

});