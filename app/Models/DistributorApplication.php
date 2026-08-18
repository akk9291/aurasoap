<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributorApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'company', 'country', 'phone', 'email',
        'estimated_order_volume', 'message', 'status', 'admin_notes',
        'ip_address', 'user_agent'
    ];
}
