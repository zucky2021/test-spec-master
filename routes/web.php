<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SpecDocSheet\IndexController as SpecDocSheetIndexController;
use App\Http\Controllers\SpecificationDocumentController;
use App\Http\Middleware\ValidateProjectId;
use App\Http\Middleware\ValidateSpecificationDocumentId;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // プロジェクト
    Route::prefix('projects')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('projects.index');

        // テスト仕様書
        Route::prefix('{projectId}/spec-docs')->middleware(ValidateProjectId::class)->group(function () {
            Route::get('/', [SpecificationDocumentController::class, 'index'])->name('specDocs.index');
            Route::get('/create', [SpecificationDocumentController::class, 'create'])->name('specDocs.create');
            Route::post('/', [SpecificationDocumentController::class, 'store'])->name('specDocs.store');
            Route::prefix('{specDocId}')->middleware(ValidateSpecificationDocumentId::class)->group(function () {
                Route::get('/', [SpecificationDocumentController::class, 'show'])->name('specDocs.show');
                Route::get('/edit', [SpecificationDocumentController::class, 'edit'])->name('specDocs.edit');
                Route::put('/update', [SpecificationDocumentController::class, 'update'])->name('specDocs.update');
            });

            // シート
            Route::prefix('{specDocId}/sheets')->middleware(ValidateSpecificationDocumentId::class)->group(function () {
                Route::get('/', [SpecDocSheetIndexController::class, 'index'])->name('specDocSheets.index');
                Route::get('/create', [SpecDocSheetIndexController::class, 'create'])->name('specDocSheets.create');
                Route::get('/{specDocSheetId}', [SpecDocSheetIndexController::class, 'show'])->name('specDocSheets.show');
                Route::get('/{specDocSheetId}/edit', [SpecDocSheetIndexController::class, 'edit'])->name('specDocSheets.edit');
            });
        });
    });

    // プロフィール
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // 管理者関連
    // Route::prefix('admin')->group(function () {
    //     Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    //     Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    //     Route::get('/projects/edit', [AdminController::class, 'editProjects'])->name('admin.projects.edit');
    //     Route::get('/exec-env/edit', [AdminController::class, 'editExecEnv'])->name('admin.execEnv.edit');
    // });
});

require __DIR__ . '/auth.php';
