<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Traits\CanLoadRelationships;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{

  use CanLoadRelationships;



private $relationships = ['user', 'attendees', 'attendees.user'];
    public function index()
    {
        Gate::authorize('viewAny', Event::class);

        $query=$this->loadRelationships(Event::query());
        return EventResource::collection(
            $query->latest()->paginate()
        );
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Event::class);
        $event = Event::create([
            ...$request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
            ]),
            'user_id' => auth()->id(),
        ]);

        return new EventResource($this->loadRelationships($event ))->additional([
            'message' => 'Event created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        Gate::authorize('view', $event);
        return new EventResource($this->loadRelationships($event ))->additional([
            'message' => 'Event retrieved successfully',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Event $event)
    {
        Gate::authorize('update', $event);
        $event->update(
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'sometimes|date',
                'end_time' => 'sometimes|date|after:start_time',
            ])
        );
        return new EventResource($this->loadRelationships($event ))->additional([
            'message' => 'Event updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        Gate::authorize('delete', $event);
        $event->delete();
        return response(status: 204);
    }
}
