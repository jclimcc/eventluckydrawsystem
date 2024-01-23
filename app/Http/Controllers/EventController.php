<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {

        $events = Event::all();
        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function participate(Event $event)
    {
        return view('events.participate', compact('event'));
    }

    public function storeParticipation(Request $request, Event $event)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'contact_number' => [
                'required',
                Rule::unique('visitors')->where(function ($query) use ($request,$event) {
                    return $query->where('contact_number', $request->contact_number)
                    ->where('event_id', $event->id)
                        ->whereDate('created_at', Carbon::today());
                }),
            ],
            'email' => 'required|email',
        ], [
            'contact_number.unique' => 'This phone number has already registered for today\'s event participation.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
        // Store the visitor's information
        $visitor = new Visitor;
        $visitor->name = $request->name;
        $visitor->contact_number = $request->contact_number;
        $visitor->email = $request->email;
        $visitor->event_id = $event->id;
        $visitor->save();

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully registered for the event.',
        ]);
    }
}
