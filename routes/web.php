<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ViewerController;

Route::get('/', [ViewerController::class, 'portal'])->name('viewer.portal');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/upload', [AdminController::class, 'upload'])->name('admin.upload');
    Route::post('/admin/sync', [AdminController::class, 'sync'])->name('admin.sync');
});

Route::get('/view/{token}', [ViewerController::class, 'view'])->name('viewer.show');
Route::get('/stream/{token}', [ViewerController::class, 'stream'])->name('viewer.stream');
Route::get('/vault', [ViewerController::class, 'vault'])->name('viewer.vault');

