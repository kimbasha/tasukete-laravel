<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// 公開ページ - 公演一覧
Route::get('/', function () {
    $performances = \App\Models\Performance::with('troupe')
        ->where('performance_date', '>=', now()->startOfDay())
        ->orderBy('performance_date')
        ->orderBy('start_time')
        ->get()
        ->map(function ($performance) {
            return [
                'id' => $performance->id,
                'title' => $performance->title,
                'troupe_name' => $performance->troupe->name,
                'venue' => $performance->venue,
                'area' => $performance->area,
                'performance_date' => $performance->performance_date->format('Y-m-d'),
                'start_time' => substr($performance->start_time, 0, 5), // HH:MM形式
                'ticket_price' => $performance->ticket_price,
                'has_day_tickets' => $performance->has_day_tickets,
                'poster_image_url' => $performance->poster_image_url,
            ];
        });

    return Inertia::render('Performances/Index', [
        'performances' => $performances,
    ]);
})->name('performances.index');

// 公演詳細
Route::get('/performances/{id}', function ($id) {
    $performance = \App\Models\Performance::with('troupe')->findOrFail($id);

    return Inertia::render('Performances/Show', [
        'performance' => [
            'id' => $performance->id,
            'title' => $performance->title,
            'description' => $performance->description,
            'venue' => $performance->venue,
            'area' => $performance->area,
            'performance_date' => $performance->performance_date->format('Y-m-d'),
            'start_time' => substr($performance->start_time, 0, 5),
            'door_open_time' => $performance->door_open_time ? substr($performance->door_open_time, 0, 5) : null,
            'ticket_price' => $performance->ticket_price,
            'has_day_tickets' => $performance->has_day_tickets,
            'poster_image_url' => $performance->poster_image_url,
            'reservation_url' => $performance->reservation_url,
            'troupe' => [
                'name' => $performance->troupe->name,
                'description' => $performance->troupe->description,
                'website' => $performance->troupe->website,
            ],
        ],
    ]);
})->name('performances.show');

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

// 旧ダッシュボードルート（後で削除）
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'stats' => [
            'totalProjects' => 12,
            'activeTasks' => 34,
            'completedTasks' => 156,
            'teamMembers' => 8,
        ],
    ]);
})->name('dashboard');
