<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Performance extends Model
{
    protected $fillable = [
        'troupe_id',
        'title',
        'description',
        'venue',
        'area',
        'area_detail',
        'performance_date',
        'start_time',
        'door_open_time',
        'poster_image_url',
        'ticket_price',
        'reservation_url',
        'has_day_tickets',
        'status',
    ];

    protected $casts = [
        'performance_date' => 'date',
        'has_day_tickets' => 'boolean',
    ];

    public function troupe(): BelongsTo
    {
        return $this->belongsTo(Troupe::class);
    }
}
