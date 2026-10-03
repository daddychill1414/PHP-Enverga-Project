<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TuitionClearance;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search');

        $query = Event::with('ticketTypes')->where('status', 'upcoming');

        if ($category) {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $events = $query->orderBy('event_date', 'asc')->get();
        $featuredEvents = Event::where('is_featured', true)->get();

        return view('events.index', compact('events', 'featuredEvents', 'category', 'search'));
    }

    public function show($slug)
    {
        $event = Event::with('ticketTypes')->where('slug', $slug)->firstOrFail();
        return view('events.show', compact('event'));
    }
}
