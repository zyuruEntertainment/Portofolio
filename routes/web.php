<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AdminProjectController;
use App\Http\Controllers\AdminSocialLinkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SocialLinkController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/explore', 'explore')->name('explore');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/social-media', [SocialLinkController::class, 'index'])->name('social-media');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::resource('projects', AdminProjectController::class)->except(['index', 'show'])->parameters(['projects' => 'project']);
        Route::resource('social-links', AdminSocialLinkController::class)->except(['show'])->parameters(['social-links' => 'link']);
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});
