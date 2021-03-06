<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Group;
use App\contact;
use App\Http\Requests;

class ApiGroupsController extends Controller
{
    public function index(){
        $groups = Group::get()->all();
        $leaders = contact::Onlyposition(0, 1)->get()->all();
        foreach($leaders as $leader){
            $leader->follower;
        }
        return response()->json(compact(
            'groups',
            'leaders'
        ));
    }
    public function show(Group $group)
    {
        $member_count = count($group->leader->follower);
        $leader = $group->leader;
        $host = $group->host;
        $timothy = $group->timothy;
        $contacts = $group->contact;
        $allcontacts = contact::get()->all();
        $attendance = $group->contacts;
        $attendance_mod =[];
        foreach($attendance as $item){
            if ($group->id = $item->pivot->group_id){
            $item->pivot->full_name = $item->full_name;
                $attendance_mod[]=($item->pivot);
            }
    }

        return response()->json(compact(
            'group',
            'member_count',
            'leader',
            'host',
            'timothy',
            'contacts',
            'allcontacts',
            'attendance_mod'
        ));

    }
    public function createAttend(Group $group)
    {
        $groups = Group::get()->all();
        $contacts = $group->contact;
        $allcontacts = contact::get()->all();

        return response()->json(compact(
            'groups',
            'allcontacts',
            'contacts'
        ));

    }
    public function saveAttend(Request $request)
    {
        $all_requests = $request->all();
        $contact_array = explode( ',',$all_requests['contacts']);
        $group = Group::findorfail($all_requests['groupid']);
        foreach($contact_array as $contact){
            $group->contacts()->attach([ $contact =>['date'=> $all_requests['date'], 'note'=> $all_requests['note']]]);
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
