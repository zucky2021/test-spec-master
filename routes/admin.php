<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Ajax\Admin\UserController as AjaxUserController;
use App\Http\Middleware\EnsureIsAdmin;
use App\Http\Middleware\ValidateProjectId;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'verified', EnsureIsAdmin::class])->name('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('.dashboard');
    Route::prefix('users')->name('.users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('');
        Route::get('/ajax', [AjaxUserController::class, 'index'])->name('.ajax');
        Route::patch('/update/ajax', [AjaxUserController::class, 'update'])->name('.update.ajax');
    });

    Route::prefix('projects')->name('.projects')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('');
        Route::get('/create', [ProjectController::class, 'create'])->name('.create');
        Route::post('/', [ProjectController::class, 'store'])->name('.store');
        Route::middleware(ValidateProjectId::class)->group(function () {
            Route::patch('/update/{projectId}', [ProjectController::class, 'update'])->name('.update');
            Route::delete('/delete/{projectId}', [ProjectController::class, 'destroy'])->name('.destroy');
        });
    });
});
