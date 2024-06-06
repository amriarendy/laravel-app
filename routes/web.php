<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])->name('/');
Route::get('/blog', [WelcomeController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [WelcomeController::class, 'blog'])->name('blog.category');
Route::get('/detail/{slug}', [WelcomeController::class, 'detail'])->name('blog.detail');
Route::get('/reload-captcha', [WelcomeController::class, 'captcha'])->name('reload.captcha');

Route::middleware('auth')->group(function () {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/dashboard/profile/update', [DashboardController::class, 'profile_update'])->name('profile.update');
    Route::post('/dashboard/profile/update-password', [DashboardController::class, 'change_password'])->name('profile.password');
    // users
    Route::get('/dashboard/users', [UserController::class, 'index'])->name('users');
    Route::post('/dashboard/users/store', [UserController::class, 'store'])->name('users.store');
    Route::post('/dashboard/users/update', [UserController::class, 'update'])->name('users.update');
    Route::post('/dashboard/users/delete', [UserController::class, 'destroy'])->name('users.delete');
    Route::post('/dashboard/users/change-password', [UserController::class, 'update_password'])->name('users.update.password');
    // master tags
    Route::get('/dashboard/master/tag', [TagController::class, 'index'])->name('tag');
    Route::post('/dashboard/master/tag/store', [TagController::class, 'store'])->name('tag.store');
    Route::post('/dashboard/master/tag/update', [TagController::class, 'update'])->name('tag.update');
    Route::post('/dashboard/master/tag/delete', [TagController::class, 'destroy'])->name('tag.delete');
    // master categories
    Route::get('/dashboard/master/category', [CategoryController::class, 'index'])->name('category');
    Route::post('/dashboard/master/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::post('/dashboard/master/category/update', [CategoryController::class, 'update'])->name('category.update');
    Route::post('/dashboard/master/category/delete', [CategoryController::class, 'destroy'])->name('category.delete');
    // blog
    Route::get('/dashboard/blog', [BlogController::class, 'index'])->name('blog.list');
    Route::get('/dashboard/blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/dashboard/blog/store', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/dashboard/blog/edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
    Route::post('/dashboard/blog/update', [BlogController::class, 'update'])->name('blog.update');
    Route::post('/dashboard/blog/delete', [BlogController::class, 'destroy'])->name('blog.delete');
    // setting
    Route::get('/dashboard/setting', [SettingController::class, 'index'])->name('setting');
    Route::post('/dashboard/meta/update', [SettingController::class, 'update'])->name('meta.update');
    Route::post('/dashboard/favicon/update', [SettingController::class, 'favicon'])->name('favicon.update');
    Route::post('/dashboard/image/update', [SettingController::class, 'image'])->name('image.update');
    // information
    Route::get('/dashboard/information', [SettingController::class, 'information'])->name('information');
    // feature
    Route::post('/dashboard/image-upload', [DashboardController::class, 'image_upload'])->name('image.upload');
    Route::post('/dashboard/image-delete', [DashboardController::class, 'image_delete'])->name('image.delete');
    Route::delete('/dashboard/file-delete/{id}', [DashboardController::class, 'delete_file'])->name('file.delete');
});

require __DIR__ . '/auth.php';
