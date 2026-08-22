<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'company_name',
        'client_type',
        'phone',
        'whatsapp',
        'email',
        'address',
        'city',
        'country',
        'notes',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enquiries()
    {
        return $this->hasMany(AgentEnquiry::class, 'client_id');
    }

    public function orders()
    {
        return $this->hasMany(AgentOrder::class, 'client_id');
    }
}
