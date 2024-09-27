<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\DealResource;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class EventController extends Controller
{
    public function all()
    {
        $events = Event::query()->with('media')->paginate(10);

        $events->withQueryString();

        return DealResource::collection($events);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::query()
            ->with('media')
            ->where('user_id', Auth::id())
            ->paginate(10);

        $events->withQueryString();

        return EventResource::collection($events);
    }

    /**
     * Store a newly created resource.
     */
    public function store(StoreEventRequest $request)
    {
        $event = Event::create($request->validated());

        $event->addMedia($request->image)->toMediaCollection();

        return response()->noContent(ResponseAlias::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($eventId)
    {
        $event = Event::query()->with('media')->where('id', $eventId)->first();

        return new EventResource($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->validated());

        if ($request->file('image')) {
            $event->clearMediaCollection();

            $event->addMedia($request->image)->toMediaCollection();
        }

        return response()->noContent(ResponseAlias::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthenticated.'], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $event->clearMediaCollection();
        $event->delete();

        return response()->noContent(ResponseAlias::HTTP_OK);
    }
}
