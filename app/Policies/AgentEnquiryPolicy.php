<?php

namespace App\Policies;

use App\Models\AgentEnquiry;
use App\Models\User;

class AgentEnquiryPolicy
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

    public function view(User $user, AgentEnquiry $enquiry): bool
    {
        return $user->id === $enquiry->user_id;
    }

    public function create(User $user): bool
    {
        return $user->isApprovedAgent();
    }

    public function update(User $user, AgentEnquiry $enquiry): bool
    {
        return $user->id === $enquiry->user_id;
    }

    public function delete(User $user, AgentEnquiry $enquiry): bool
    {
        return $user->id === $enquiry->user_id;
    }
}
