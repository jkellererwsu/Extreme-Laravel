<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\contact;
use App\Training;
use App\Http\Requests;
use App\Http\Requests\TrainingRequest;

class TrainingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trainings = Training::oldest('displayOrder')->get();
        $trainingCat = '';

        return view('trainings.index', compact('trainings', 'trainingCat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('trainings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrainingRequest $request)
    {
        Training::create($request->all());

        return redirect('trainings');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Training $training_show)
    {
        $contacts = contact::lists('fname', 'id');
        return view('trainings.show', compact('training_show','contacts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Training $training)
    {
        return view('trainings.edit', compact('training'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TrainingRequest $request, Training $training)
    {
        $training->update($request->all());

        return redirect('trainings');
    }
    /**
     * Link the specified Event with Contacts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addContacts(Request $request, Training $training)
    {
        $trainingDate = $request->input('training_date');
        $trainingNote = $request->input('training_text');
        foreach($request->input('contact_list') as $contact){
            $training->contacts()->sync([ $contact =>['date'=> $trainingDate, 'note'=> $trainingNote]], False);
        }

        return redirect()->back();

    }
    /**
     * Remove the specified resource from relationship with contact.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteContacts(Request $request, Training $training)
    {
        $training->contacts()->newPivotStatementForId($request->input('contact_id'))->whereEventId($training->id)->delete();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Training $training)
    {
        $training->delete();
        return redirect('trainings');
    }
}
