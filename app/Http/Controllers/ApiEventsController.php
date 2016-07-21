<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Event;
use App\Group;
use App\contact;
use App\Http\Requests;

class ApiEventsController extends Controller
{
    public function index(){
        $events = Event::get()->all();
        /*$leaders = contact::Onlyposition(0, 1)->get()->all();
        foreach($leaders as $leader){
            $leader->follower;
        }*/
        return response()->json(compact(
            'events'
        ));
    }
    public function show(Event $event_show)
    {
        $event_count = count($event_show->contacts);
        $event_attend = $event_show->contacts;
        $event_attend_mod = [];
        foreach($event_attend as $item){
            if ($event_show->id = $item->pivot->event_id){
                $item->pivot->full_name = $item->full_name;
                $event_attend_mod[]=($item->pivot);
            }
        }

        return response()->json(compact(
            'event_show',
            'event_attend',
            'event_attend_mod',
            'event_count'

        ));

    }
    public function createAttend(Event $event_show)
    {
        $events = Event::get()->all();
        $allcontacts = contact::get()->all();

        return response()->json(compact(
            'events',
            'allcontacts'
        ));

    }
    public function saveAttend(Request $request)
    {
        $all_requests = $request->all();
        $contact_array = explode( ',',$all_requests['contacts']);
        $event = Event::findorfail($all_requests['eventid']);
        foreach($contact_array as $contact){
            $event->contacts()->attach([ $contact =>['date'=> $all_requests['date'], 'note'=> $all_requests['note']]]);
        }
        return response()->json(compact(
            'all_requests'
        ));

    }
    public function create()
    {
        $leaders = contact::Onlyposition(0, 2)->get()->lists('full_name', 'id');
        $host = contact::Onlyposition(0, 4)->get()->lists('full_name', 'id');
        $timothy = contact::Onlyposition(0, 3)->get()->lists('full_name', 'id');

        return response()->json(compact(
            'leaders',
            'host',
            'timothy'
        ));


    }
    public function store(Request $request)
    {
        $all_requests = $request->all();
        $request->request->add(['church_id' => Auth::user()->church_id]);
        $group = Group::create($request->all());
        return response()->json(compact(
            'all_requests',
            'group'
        ));

    }
    public function update(Request $request, Group $group)
    {
        $all_requests = $request->all();
        $groupResp = $group->update($request->all());

        return response()->json(compact(
            'all_requests',
            'groupResp'
        ));
    }
    public function destroy(Group $group)
    {
        $group->delete();
        return "success";
    }
}
