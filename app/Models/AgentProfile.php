<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'agent_code',
        'company_name',
        'business_type',
        'business_address',
        'city',
        'province_state',
        'country',
        'whatsapp_number',
        'national_id_number',
        'business_details',
        'buyer_network_info',
        'expected_order_volume',
        'distribution_requirements',
        'business_reg_doc',
        'id_card_doc',
        'agreement_doc',
        'application_status',
        'gov_tender_permission',
        'gov_tender_notes',
        'admin_internal_notes',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isApproved(): bool
    {
        return $this->application_status === 'approved';
    }

    public function isPending(): bool
    {
        return in_array($this->application_status, ['pending', 'under_review']);
    }

    public function isSuspended(): bool
    {
        return $this->application_status === 'suspended';
    }

    public function isTenderApproved(): bool
    {
        return $this->gov_tender_permission === 'approved';
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->application_status) {
            'approved' => 'success',
            'pending' => 'warning',
            'under_review' => 'info',
            'rejected' => 'danger',
            'suspended' => 'secondary',
            default => 'dark',
        };
    }
}
