<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\TagController;
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
    Route::get('/dashboard/master/tag', [TagController::class, 'index'])->name('tag');
    Route::post('/dashboard/master/tag/store', [TagController::class, 'store'])->name('tag.store');
    Route::post('/dashboard/master/tag/update', [TagController::class, 'update'])->name('tag.update');
    Route::post('/dashboard/master/tag/delete', [TagController::class, 'destroy'])->name('tag.delete');
    Route::get('/dashboard/master/category', [CategoryController::class, 'index'])->name('category');
});

require __DIR__ . '/auth.php';
