<?php

namespace App\Policies;

use App\Models\AgentOrder;
use App\Models\User;

class AgentOrderPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin') || $user->hasRole('admin')) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->isAgent();
    }

    public function view(User $user, AgentOrder $order): bool
    {
        return $user->id === $order->user_id;
    }

    public function create(User $user): bool
    {
        return $user->isApprovedAgent();
    }

    public function cancel(User $user, AgentOrder $order): bool
    {
        return $user->id === $order->user_id && in_array($order->status, ['pending', 'under_review']);
    }
}
