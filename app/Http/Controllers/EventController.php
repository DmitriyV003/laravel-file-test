<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\EventService;

class EventController extends Controller
{
    private const ITEMS_PER_PAGE = 20;

    public function __construct()
    {
        $this->authorizeResource(Event::class);
    }

    public function store(CreateEventRequest $request)
    {
        app(EventService::class)->create($request->validated(), auth()->user());

        return response(status: 201);
    }

    public function index()
    {
        return EventResource::collection(Event::query()->with('creator')->paginate(self::ITEMS_PER_PAGE));
    }

    public function show(Event $event)
    {
        return new EventResource($event->load(['creator', 'users']));
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->noContent();
    }

    public function subscribe(Event $event)
    {
        app(EventService::class)->subscribe($event, auth()->user());

        return response()->noContent();
    }

    public function unsubscribe(Event $event)
    {
        app(EventService::class)->unsubscribe($event, auth()->user());

        return response()->noContent();
    }

    public function myEvents()
    {
        return EventResource::collection(auth()->user()->events()->with('creator')->get());
    }
}
