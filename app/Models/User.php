<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    protected $fillable = [
        'name',
        'email',
        'phone',
        'profile_image',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($roleSlug)
    {
        if (is_array($roleSlug)) {
            return $this->roles()->whereIn('slug', $roleSlug)->exists();
        }
        return $this->roles()->where('slug', $roleSlug)->exists();
    }

    public function hasPermission($permissionSlug)
    {
        foreach ($this->roles as $role) {
            if ($role->permissions()->where('slug', $permissionSlug)->exists()) {
                return true;
            }
        }
        return false;
    }

    public function agentProfile()
    {
        return $this->hasOne(AgentProfile::class);
    }

    public function agentClients()
    {
        return $this->hasMany(AgentClient::class);
    }

    public function agentOrders()
    {
        return $this->hasMany(AgentOrder::class);
    }

    public function agentEnquiries()
    {
        return $this->hasMany(AgentEnquiry::class);
    }

    public function agentTickets()
    {
        return $this->hasMany(AgentSupportTicket::class);
    }

    public function isAgent(): bool
    {
        return $this->hasRole('principal-agent') || $this->hasRole('agent');
    }

    public function isApprovedAgent(): bool
    {
        return $this->isAgent() && $this->agentProfile && $this->agentProfile->isApproved();
    }
}
