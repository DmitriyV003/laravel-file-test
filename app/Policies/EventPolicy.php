<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function __construct()
    {
        //
    }

    public function viewAny(): bool
    {
        return true;
    }

    public function view(): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function destroy(User $user, Event $event): bool
    {
        return $user->id === $event->creator->id;
    }
}
