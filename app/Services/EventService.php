<?php

namespace App\Services;

use App\Models\Event;
use App\Models\User;

class EventService
{
    public function create(array $params, User $user): void
    {
        $event = app(Event::class);
        $event->fill($params);
        $event->creator()->associate($user);
        $event->users()->attach($user->id);
        $event->save();
    }

    public function subscribe(Event $event, User $user): void
    {
        $event->users()->attach($user->id);
    }

    public function unsubscribe(Event $event, User $user): void
    {
        $event->users()->detach($user->id);
    }
}
