<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Group;
use App\Training;
use App\contact;
use App\Http\Requests;

class ApiTrainingsController extends Controller
{
    public function index(){
        $trainings = Training::get()->all();
        foreach ($trainings as $train){
            $train->contacts;
        }
        return response()->json(compact(
            'trainings'
        ));
    }
    public function show(Training $train)
    {
        $train_count = count($train->contacts);
        $attendance_mod =[];
        foreach($train->contacts as $item){
            if ($train->id = $item->pivot->training_id){
            $item->pivot->full_name = $item->full_name;
                $attendance_mod[]=($item->pivot);
            }
    }

        return response()->json(compact(
            'train',
            'train_count',
            'attendance_mod'
        ));

    }
    public function createAttend(Training $train)
    {
        $trainings = Training::get()->all();
        $contacts = contact::get()->all();

        return response()->json(compact(
            'trainings',
            'contacts'
        ));

    }
    public function saveAttend(Request $request)
    {
        $all_requests = $request->all();
        $contact_array = explode( ',',$all_requests['contacts']);
        $train = Training::findorfail($all_requests['trainid']);
        foreach($contact_array as $contact){
            $train->contacts()->attach([ $contact =>['date'=> $all_requests['date'], 'note'=> $all_requests['note']]]);
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
