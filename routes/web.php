<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $performances = \App\Models\Performance::with('troupe')
        ->orderBy('performance_date')
        ->get()
        ->map(function ($performance) {
            return [
                'id' => $performance->id,
                'title' => $performance->title,
                'troupe_name' => $performance->troupe->name,
                'venue' => $performance->venue,
                'area' => $performance->area,
                'performance_date' => $performance->performance_date->format('Y-m-d'),
                'start_time' => $performance->start_time,
                'ticket_price' => $performance->ticket_price,
                'has_day_tickets' => $performance->has_day_tickets,
                'poster_image_url' => $performance->poster_image_url,
            ];
        });

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
