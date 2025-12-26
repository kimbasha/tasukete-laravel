<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\PerformanceController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// 公開ページ - 公演
Route::get('/', [PerformanceController::class, 'index'])->name('performances.index');
Route::get('/performances/{id}', [PerformanceController::class, 'show'])->name('performances.show');

// 管理画面 - 認証
Route::prefix('admin')->group(function () {
    // ゲスト用（未ログイン）
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    // 認証済み用
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

        Route::get('/', function () {
            return Inertia::render('Dashboard', [
                'stats' => [
                    'totalProjects' => 12,
                    'activeTasks' => 34,
                    'completedTasks' => 156,
                    'teamMembers' => 8,
                ],
            ]);
        })->name('admin.dashboard');
    });
});
