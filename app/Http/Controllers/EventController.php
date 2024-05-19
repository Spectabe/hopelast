<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $events = Event::where('user_id', $userId)->get();

        return response()->json(['events' => $events], 201);
    }

    public function show(Request $request, $id)
    {
        $userId = auth()->id();
        $event = Event::findOrFail($id);

        if ($event->user_id != $userId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($event);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'description' => 'string|max:1000',
            'date_time_start' => 'date',
            'date_time_end' => 'date|after:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()->first()], 422);
        }

        $event->title = $request->input('title') ?? $event->title;
        $event->description = $request->input('description') ?? $event->description;
        $event->date_time_start = $request->input('date_time_start') ?? $event->date_time_start;
        $event->date_time_end = $request->input('date_time_end') ?? $event->date_time_end;
        $event->save(); 
        
        return response()->json(['message' => 'Data updated successful'], 200);
    }


    public function store(Request $request) // usare storeEventRequest
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'string|max:1000',
            'date_time_start' => 'required|date',
            'date_time_end' => 'required|date|after:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()->first()], 422);
        }

        $event = new Event;
        $event->title = $request->title;
        $event->description = $request->description;
        $event->date_time_start = $request->date_time_start;
        $event->date_time_end = $request->date_time_end;
        $event->user_id = auth()->id();
        $event->save();

        return response()->json(['message' => 'Evento aggiunto correttamente'], 201);
    }

    public function getEventsByDate(Request $request, $date)
    {
        $userId = auth()->id();

        $events = Event::where('user_id', $userId)
            ->whereDate('date_time_start', $date)
            ->get();

            return response()->json(['events' => $events], 201);
    }

    public function destroy($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'message' => 'Evento non trovato'
            ], 404);
        }

        $event->delete();

        return response()->json([
            'message' => 'Evento eliminato con successo'
        ], 201);
    }
}
