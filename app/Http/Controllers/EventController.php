<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function all(){
        $events = Event::all();

        return response()->json(['events' => EventResource::collection($events)], 200);
    }

    public function save(Request $request){

        $request->validate([
            'event_name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'event_days' => 'array',
            'event_days.*' => 'integer|min:0|max:6'
        ]);
        
        //Format the given start and end date.
        $start_date = date('Y-m-d', strtotime($request->input('start_date')));
        $end_date = date('Y-m-d', strtotime($request->input('end_date')));

        /**
         * Since I don't know the validations required for the event days
         * I'll considered it as whole week when the user submitted a form without
         * the event days checked.
         */
        $event_days = $request->input('event_days');
        if(empty($request->input('event_days'))){
            $event_days = [0,1,2,3,4,5,6];    
        }

        //UpSert the given data
        $event = Event::updateOrCreate(
            [
                'start_date' => $start_date, 
                'end_date' => $end_date
            ],
            [
                'event_name' => $request->input('event_name'),
                'start_date' => $start_date,
                'end_date' => $end_date,
                'event_days' => serialize($event_days)
            ]
        );

        return response()->json(['event' => new EventResource($event)], 201);
    }
}
