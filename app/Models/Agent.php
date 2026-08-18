<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'market',
        'country',
        'city_town',
        'province_state',
        'agent_count',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'agent_count' => 'integer',
        'sort_order' => 'integer',
    ];
}
