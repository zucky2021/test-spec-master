<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SpecDocItemController;
use App\Http\Controllers\SpecDocSheetController;
use App\Http\Controllers\SpecificationDocumentController;
use App\Http\Controllers\TesterController;
use App\Http\Middleware\ValidateProjectId;
use App\Http\Middleware\ValidateSpecDocItemId;
use App\Http\Middleware\ValidateSpecDocSheetId;
use App\Http\Middleware\ValidateSpecificationDocumentId;
use App\Http\Middleware\ValidateTesterId;
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
                Route::get('/edit', [SpecificationDocumentController::class, 'edit'])->name('specDocs.edit');
                Route::put('/update', [SpecificationDocumentController::class, 'update'])->name('specDocs.update');
            });

            // シート
            Route::prefix('{specDocId}/sheets')->middleware(ValidateSpecificationDocumentId::class)->group(function () {
                Route::get('/', [SpecDocSheetController::class, 'index'])->name('specDocSheets.index');
                Route::post('/', [SpecDocSheetController::class, 'store'])->name('specDocSheets.store');
                Route::prefix('{specDocSheetId}')->middleware(ValidateSpecDocSheetId::class)->group(function () {
                    Route::get('/', [SpecDocSheetController::class, 'show'])->name('specDocSheets.show');
                    Route::put('/', [SpecDocItemController::class, 'store'])->name('specDocItems.store');
                    Route::delete('/', [SpecDocSheetController::class, 'destroy'])->name('specDocSheets.destroy');
                    Route::get('/edit', [SpecDocSheetController::class, 'edit'])->name('specDocSheets.edit');
                    Route::get('/preview', [SpecDocSheetController::class, 'preview'])->name('specDocSheets.preview');

                    Route::prefix('{specDocItemId}')->middleware(ValidateSpecDocItemId::class)->group(function () {
                        Route::patch('/', [SpecDocItemController::class, 'update'])->name('specDocItems.update');
                    });

                    Route::prefix('testers')->group(function () {
                        Route::get('/', [TesterController::class, 'index'])->name('testers.index');
                        Route::post('/', [TesterController::class, 'store'])->name('testers.store');
                        Route::delete('/{testerId}', [TesterController::class, 'destroy'])
                            ->middleware(ValidateTesterId::class)
                            ->name('testers.destroy');
                    });
                });
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
