<?php

use App\Http\Controllers\AdminContentController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

$basePath = trim((string) parse_url(config('app.url'), PHP_URL_PATH), '/');

Route::prefix($basePath)->group(function () {
    Route::get('/', PortfolioController::class)->name('portfolio.show');
    Route::post('/contacto', [ContactController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('contact.store');
    Route::get('/admin', [ContactController::class, 'login'])->name('admin.login');
    Route::post('/admin', [ContactController::class, 'authenticate'])->name('admin.authenticate');
    Route::get('/admin/dashboard', AdminDashboardController::class)->name('admin.dashboard');
    Route::get('/admin/mensajes', [ContactController::class, 'index'])->name('admin.messages');
    Route::get('/admin/contenido', [AdminContentController::class, 'edit'])->name('admin.content.edit');
    Route::post('/admin/contenido', [AdminContentController::class, 'update'])->name('admin.content.update');
    Route::get('/admin/usuarios', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/usuarios', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::post('/admin/usuarios/clave', [AdminUserController::class, 'updatePassword'])->name('admin.users.update_password');
    Route::post('/admin/usuarios/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::post('/admin/usuarios/{user}/eliminar', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('/admin/salir', [ContactController::class, 'logout'])->name('admin.logout');
});
