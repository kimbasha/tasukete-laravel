<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    // サンプルデータ（後でデータベースから取得）
    $performances = [
        [
            'id' => 1,
            'title' => '夏の夜の夢',
            'troupe_name' => '劇団シェイクスピア',
            'venue' => '下北沢タイニイアリス',
            'area' => '下北沢',
            'performance_date' => '2025-12-26',
            'start_time' => '19:00',
            'ticket_price' => 3500,
            'has_day_tickets' => true,
            'poster_image_url' => null,
        ],
        [
            'id' => 2,
            'title' => '待ちぼうけ',
            'troupe_name' => 'Theatre Company SUBARU',
            'venue' => '新宿シアターサンモール',
            'area' => '新宿',
            'performance_date' => '2025-12-27',
            'start_time' => '14:00',
            'ticket_price' => 4000,
            'has_day_tickets' => false,
            'poster_image_url' => null,
        ],
    ];

    return Inertia::render('Performances/Index', [
        'performances' => $performances,
    ]);
})->name('performances.index');

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
