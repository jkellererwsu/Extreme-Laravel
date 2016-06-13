<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Group;
use App\Http\Requests;

class ApiGroupsController extends Controller
{
    public function index(){

        return Group::latest('name')->get();
    }
    public function show(Group $group)
    {
        $group = $group;
        $member_count = count($group->leader->follower);
        $leader = $group->leader;
        $host = $group->host;
        $timothy = $group->timothy;
        $contacts = $group->contact;
        $attendance = $group->contacts;


        return response()->json(compact(
            'group',
            'member_count',
            'leader',
            'host',
            'timothy',
            'contacts',
            'attendance'
        ));


    }
}
