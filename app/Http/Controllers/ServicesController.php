<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\contact;
use App\Service;
use App\Http\Requests;
use App\Http\Requests\ServiceRequest;


class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::oldest('displayOrder')->get();

        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        Service::create($request->all());

        return redirect('services');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service_show)
    {
        $service_type = '';
        $contacts = contact::lists('fname', 'id');
        return view('services.show', compact('service_show','contacts','service_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, Service $service)
    {
        $service->update($request->all());

        return redirect('services');
    }
    /**
     * Link the specified Event with Contacts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addContacts(Request $request, Service $service)
    {
        $eventDate = $request->input('event_date');
        $eventNote = $request->input('event_text');
        foreach($request->input('contact_list') as $contact){
            $service->contacts()->attach([ $contact =>['date'=> $eventDate, 'note'=> $eventNote]]);
        }

        return redirect()->back();

    }
    /**
     * Remove the specified resource from relationship with contact.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteContacts(Request $request, Service $service)
    {
        $service->contacts()->newPivotStatementForId($request->input('contact_id'))->whereId($request->input('pivot_id'))->delete();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect('services');
    }
}
