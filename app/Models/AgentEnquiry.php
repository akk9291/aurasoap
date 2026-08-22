<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentEnquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'title',
        'description',
        'product_interests',
        'estimated_quantity',
        'status',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(AgentClient::class, 'client_id');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'new' => 'primary',
            'contacted' => 'info',
            'follow_up' => 'warning',
            'converted' => 'success',
            'closed' => 'secondary',
            default => 'dark',
        };
    }
}
