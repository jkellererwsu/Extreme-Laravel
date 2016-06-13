<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\contact;
use App\Group;
use App\Position;
use App\Http\Requests;
use App\Http\Requests\ContactRequest;


class ApiContactsController extends Controller
{
    public function index()
    {
        return contact::latest('fname')->get();
    }
    public function show(contact $contact_show)
    {
        $groups = Group::lists('name', 'id');
        $positions = $contact_show->positions;
        $followers = $contact_show->follower;
        $groupLeader = $contact_show->groupLeader;
        $groupHost = $contact_show->groupHost;
        $groupTimothy = $contact_show->groupTimothy;
        $group = $contact_show->group;
        $events = $contact_show->events;
        $trainings = $contact_show->trainings;
        $leader = $contact_show->leader;
        $all_positions = Position::get()->all();
        $all_leaders = contact::Onlyposition(0, 1)->get()->lists('full_name', 'id');

        return response()->json(compact(
            'contact_show',
            'leader',
            'groups',
            'positions',
            'followers',
            'groupLeader',
            'groupHost',
            'groupTimothy',
            'group',
            'events',
            'trainings',
            'all_positions',
            'all_leaders'));


    }
    public function create()
    {
        $groups = Group::lists('name', 'id');
        $all_positions = Position::get()->all();
        $all_leaders = contact::Onlyposition(0, 1)->get()->lists('full_name', 'id');

        return response()->json(compact(
            'groups',
            'all_positions',
            'all_leaders'));


    }
    public function store(Request $request)
    {
        $request->request->add(['church_id' => Auth::user()->church_id]);
        $all_requests = $request->all();
        $contact = Auth::user()->contacts()->create($request->all());
        $position_array = explode( ',',$request->input('position_list'));
        $this->syncAttr($contact, $position_array);
        return response()->json(compact(
            'all_requests',
            'contact'
        ));

    }
    public function update(contact $contact, Request $request)
    {
        $all_requests = $request->all();
        $contact->update($request->all());
        $this->syncAttr($contact, $request->input('position_list'));
        return response()->json(compact(
           'contact',
            'all_requests'
        ));

    }
    public function destroy(contact $contact)
    {
        $contact->delete();
        return "success";
    }

    private function syncAttr(contact $contact, array $positions)
    {
        $allPositionIds = array();
        foreach ($positions as $position) {
            $allPositionIds[] = $position;
        }
       $contact->positions()->sync($allPositionIds);
    }


}
