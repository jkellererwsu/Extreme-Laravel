<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\contact;
use App\Event;
use App\Http\Requests;
use App\Http\Requests\EventRequest;


class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::oldest('displayOrder')->get();

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        Event::create($request->all());

        return redirect('events');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event_show)
    {
        $contacts = contact::lists('fname', 'id');
        return view('events.show', compact('event_show','contacts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, Event $event)
    {
        $event->update($request->all());

        return redirect('events');
    }
    /**
     * Link the specified Event with Contacts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addContacts(Request $request, Event $event)
    {
        $eventDate = $request->input('event_date');
        $eventNote = $request->input('event_text');
        foreach($request->input('contact_list') as $contact){
            $event->contacts()->sync([ $contact =>['date'=> $eventDate, 'note'=> $eventNote]], False);
        }

        return redirect()->back();

    }
    /**
     * Remove the specified resource from relationship with contact.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteContacts(Request $request, Event $event)
    {
        $event->contacts()->newPivotStatementForId($request->input('contact_id'))->whereEventId($event->id)->delete();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect('events');
    }
}
