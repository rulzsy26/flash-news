<?php

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ProfileController;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/', [NewsController::class, 'index'])->name('home');
Route::get('/category/{category}', [NewsController::class, 'category'])->name('category');
Route::get('/search', [NewsController::class, 'search'])->name('search');
Route::get('/news/saved', [NewsController::class, 'saved'])->name('news.saved');
Route::get('/tentang-kami', function () {
    return view('tentang'); })->name('tentang');
Route::get('/news/{id}', [NewsController::class, 'detail'])->name('news.detail');
Route::get('/berita', [NewsController::class, 'allNews'])->name('berita');
Route::get('/berita/{encoded}', [NewsController::class, 'show'])->name('berita.detail');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::post('/save-article', [NewsController::class, 'saveArticle'])->name('news.save');
Route::delete('/news/unsave/{id}', [NewsController::class, 'unsave'])->name('news.unsave');

