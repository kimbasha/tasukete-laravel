<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/dashboard');
});

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
