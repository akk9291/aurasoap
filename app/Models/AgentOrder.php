<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'client_id',
        'order_source',
        'status',
        'required_delivery_date',
        'shipping_address',
        'notes',
        'financial_notes',
        'admin_notes',
        'subtotal',
        'tax_amount',
        'shipping_amount',
        'total_amount',
        'currency',
    ];

    protected $casts = [
        'required_delivery_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(AgentClient::class, 'client_id');
    }

    public function items()
    {
        return $this->hasMany(AgentOrderItem::class, 'order_id');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'under_review' => 'info',
            'confirmed' => 'primary',
            'processing' => 'primary',
            'shipped' => 'info',
            'delivered' => 'success',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    public static function generateOrderNumber(): string
    {
        $year = date('Y');
        $count = self::whereYear('created_at', $year)->count() + 1;
        return sprintf('AS-ORD-%s-%04d', $year, $count);
    }
}
