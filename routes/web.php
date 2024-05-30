<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\TagController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
})->name('/');
Route::get('/reload-captcha', [WelcomeController::class, 'captcha'])->name('reload.captcha');
Route::post('/test', [WelcomeController::class, 'test'])->name('test');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/users', [UserController::class, 'index'])->name('users');
    Route::post('/dashboard/users/store', [UserController::class, 'store'])->name('users.store');
    Route::post('/dashboard/users/update', [UserController::class, 'update'])->name('users.update');
    Route::post('/dashboard/users/delete', [UserController::class, 'destroy'])->name('users.delete');
    Route::get('/dashboard/master/tag', [TagController::class, 'index'])->name('tag');
    Route::post('/dashboard/master/tag/store', [TagController::class, 'store'])->name('tag.store');
    Route::post('/dashboard/master/tag/update', [TagController::class, 'update'])->name('tag.update');
    Route::post('/dashboard/master/tag/delete', [TagController::class, 'destroy'])->name('tag.delete');
    Route::get('/dashboard/master/category', [CategoryController::class, 'index'])->name('category');
    Route::post('/dashboard/master/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::post('/dashboard/master/category/update', [CategoryController::class, 'update'])->name('category.update');
    Route::post('/dashboard/master/category/delete', [CategoryController::class, 'destroy'])->name('category.delete');
    Route::get('/dashboard/blog', [BlogController::class, 'index'])->name('blog');
    Route::get('/dashboard/blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/dashboard/blog/store', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/dashboard/blog/edit', [BlogController::class, 'index'])->name('blog.edit');
    Route::post('/dashboard/blog/update', [BlogController::class, 'update'])->name('blog.update');
    Route::post('/dashboard/blog/delete', [BlogController::class, 'destroy'])->name('blog.delete');
});

require __DIR__ . '/auth.php';
