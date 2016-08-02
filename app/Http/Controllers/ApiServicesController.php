<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Service;
use App\Attendance;
use App\Training;
use App\contact;
use App\Http\Requests;

class ApiServicesController extends Controller
{
    public function index(){
        $services = Service::oldest('displayOrder')->get();
        foreach ($services as $serve){
            $serve->attendance;
            if(!$serve->attendance->isEmpty()){
                $serve->total = $serve->attendance->first()->adults + $serve->attendance->first()->kids + $serve->attendance->first()->extremies;
            }else{
                $serve->total= 0;
            }

            //$serve->total = $serve->attendance->first()->adults;
        }
        return response()->json(compact(
            'services'
        ));
    }
    public function show(Service $serve)
    {
        if(!$serve->attendance->isEmpty()){
            $serve->total = $serve->attendance->first()->adults + $serve->attendance->first()->kids + $serve->attendance->first()->extremies;
            foreach($serve->attendance as $attend) {
                $attend->formdate = $attend->date->formatLocalized('%B %d, %Y');
                $attend->total = $attend->adults + $attend->kids + $attend->extremies;
                $attend->all_income = $attend->offering + $attend->tithe + $attend->other_income;
            }
        }else{
            $serve->total= 0;
        }



        return response()->json(compact(
            'serve'

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
        Attendance::create($request->all());
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
