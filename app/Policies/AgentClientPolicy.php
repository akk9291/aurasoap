<?php

namespace App\Policies;

use App\Models\AgentClient;
use App\Models\User;

class AgentClientPolicy
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

    public function view(User $user, AgentClient $client): bool
    {
        return $user->id === $client->user_id;
    }

    public function create(User $user): bool
    {
        return $user->isApprovedAgent();
    }

    public function update(User $user, AgentClient $client): bool
    {
        return $user->id === $client->user_id;
    }

    public function delete(User $user, AgentClient $client): bool
    {
        return $user->id === $client->user_id;
    }
}
