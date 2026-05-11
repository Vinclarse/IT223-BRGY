<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventsController extends Controller
{
    /**
     * Show community page for guests with events from the database.
     */
    public function communityGuest()
    {
        $events = Event::orderBy('event_date', 'asc')->get();

        return view('community_guest', ['events' => $events]);
    }

    /**
     * Show community page for authenticated residents with events from the database.
     */
    public function community()
    {
        $events = Event::orderBy('event_date', 'asc')->get();

        return view('community', ['events' => $events]);
    }

    // Return JSON list of events, optional q filter
    public function data(Request $request)
    {
        $q = trim($request->query('q', ''));

        $query = Event::query();
        if ($q !== '') {
            $query->where('title', 'like', "%{$q}%");
        }

        $events = $query->orderBy('event_date', 'desc')->limit(200)->get();

        // Normalize date fields to predictable ISO formats so client JS parses reliably
        $events = $events->map(function ($e) {
            // event_date: prefer date-only string if time is midnight, otherwise ISO datetime
            if (isset($e->event_date) && method_exists($e->event_date, 'toDateTimeString')) {
                // If time is 00:00:00, send date only to avoid showing a time like 8:00 AM
                $timePart = $e->event_date->format('H:i:s');
                if ($timePart === '00:00:00') {
                    $e->event_date = $e->event_date->toDateString();
                    $e->event_date_display = $e->event_date->format('F j, Y');
                } else {
                    $e->event_date = $e->event_date->toIso8601String();
                    $e->event_date_display = $e->event_date->format('F j, Y, g:i A');
                }
            } elseif (isset($e->event_date)) {
                $e->event_date = (string) $e->event_date;
                // try to format a display string if possible
                try {
                    $dt = \Carbon\Carbon::parse($e->event_date);
                    $timePart = $dt->format('H:i:s');
                    $e->event_date_display = $timePart === '00:00:00' ? $dt->format('F j, Y') : $dt->format('F j, Y, g:i A');
                } catch (\Throwable $ex) {
                    $e->event_date_display = (string) $e->event_date;
                }
            }

            // created_at: send full ISO-8601 with offset so client displays correct local time
            if (isset($e->created_at) && method_exists($e->created_at, 'toIso8601String')) {
                $e->created_at = $e->created_at->toIso8601String();
                $e->created_at_display = \Carbon\Carbon::parse($e->created_at)->format('m/d/Y, g:i:s A');
            } elseif (isset($e->created_at)) {
                $e->created_at = (string) $e->created_at;
                try {
                    $e->created_at_display = \Carbon\Carbon::parse($e->created_at)->format('m/d/Y, g:i:s A');
                } catch (\Throwable $ex) {
                    $e->created_at_display = (string) $e->created_at;
                }
            }

            return $e;
        });

        return response()->json($events);
    }

    // Create new event
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'event_date' => 'required|date',
            'location' => 'required|string|max:100',
        ]);

        // generate id if not provided
        $id = 'EVT' . time();

        $event = Event::create([
            'event_id' => $id,
            'title' => $request->input('title'),
            'event_date' => $request->input('event_date'),
            'location' => $request->input('location'),
            'created_at' => now(),
        ]);

        if ($request->wantsJson()) {
            return response()->json($event, 201);
        }

        return back()->with('success', 'Event added');
    }

    // Delete event
    public function destroy($eventId)
    {
        Event::where('event_id', $eventId)->delete();

        if (request()->wantsJson()) {
            return response()->json(['deleted' => true]);
        }

        return back()->with('success', 'Event deleted');
    }

    // Update event
    public function update(Request $request, $eventId)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'event_date' => 'required|date',
            'location' => 'required|string|max:100',
        ]);

        $event = Event::where('event_id', $eventId)->firstOrFail();
        $event->update([
            'title' => $request->input('title'),
            'event_date' => $request->input('event_date'),
            'location' => $request->input('location'),
        ]);

        if ($request->wantsJson()) {
            return response()->json($event);
        }

        return back()->with('success', 'Event updated');
    }
}
