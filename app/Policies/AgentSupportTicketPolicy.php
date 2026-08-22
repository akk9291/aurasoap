<?php

namespace App\Policies;

use App\Models\AgentSupportTicket;
use App\Models\User;

class AgentSupportTicketPolicy
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

    public function view(User $user, AgentSupportTicket $ticket): bool
    {
        return $user->id === $ticket->user_id;
    }

    public function reply(User $user, AgentSupportTicket $ticket): bool
    {
        return $user->id === $ticket->user_id && $ticket->status !== 'closed';
    }
}
