<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use Inertia\Inertia;

class PerformanceController extends Controller
{
    /**
     * Display a listing of performances.
     */
    public function index()
    {
        $performances = Performance::with('troupe')
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
                    'start_time' => substr($performance->start_time, 0, 5),
                    'ticket_price' => $performance->ticket_price,
                    'has_day_tickets' => $performance->has_day_tickets,
                    'poster_image_url' => $performance->poster_image_url,
                ];
            });

        return Inertia::render('Performances/Index', [
            'performances' => $performances,
        ]);
    }

    /**
     * Display the specified performance.
     */
    public function show(string $id)
    {
        $performance = Performance::with('troupe')->findOrFail($id);

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
    }
}
