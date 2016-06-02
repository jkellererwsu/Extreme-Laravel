<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\contact;
use App\Group;
use App\Http\Requests;
use App\Http\Requests\GroupRequest;


class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::get()->all();
        $leaders = contact::Onlyposition(0, 1)->get()->all();

        return view('groups.index', compact('groups','leaders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leaders = contact::Onlyposition(0, 2)->get()->lists('full_name', 'id');
        $host = contact::Onlyposition(0, 4)->get()->lists('full_name', 'id');
        $timothy = contact::Onlyposition(0, 3)->get()->lists('full_name', 'id');
        return view('groups.create', compact('leaders', 'host', 'timothy'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        $request->request->add(['church_id' => Auth::user()->church_id]);
        Group::create($request->all());

        return redirect('groups');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group_show)
    {
        $group_date = '';
        $contacts = contact::get()->lists('full_name', 'id');
        return view('groups.show', compact('group_show', 'contacts', 'group_date'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        $leaders = contact::Onlyposition(0, 2)->get()->lists('full_name', 'id');
        $host = contact::Onlyposition(0, 4)->get()->lists('full_name', 'id');
        $timothy = contact::Onlyposition(0, 3)->get()->lists('full_name', 'id');

        return view('groups.edit', compact('group', 'leaders', 'host', 'timothy'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRequest $request, Group $group)
    {
        $group->update($request->all());

        return redirect('groups');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return redirect('groups');
    }

    public function addContacts(Request $request, Group $group)
    {
        $eventDate = $request->input('group_date');
        $eventNote = $request->input('group_text');
        foreach($request->input('contact_list') as $contact){
            $group->contacts()->attach([ $contact =>['date'=> $eventDate, 'note'=> $eventNote]]);
        }

        return redirect()->back();

    }
    /**
     * Remove the specified resource from relationship with contact.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteContacts(Request $request, Group $group)
    {
        $group->contacts()->newPivotStatementForId($request->input('contact_id'))->whereId($request->input('pivot_id'))->delete();

        return redirect()->back();
    }
}
