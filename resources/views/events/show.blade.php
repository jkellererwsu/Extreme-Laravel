@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
                <div class="col-sm-12 text-center well">
                    <div class="col-xs-12 col-sm-8">
                        <h2>{{$event_show->name}}</h2>
                    </div>
                    <div class="col-xs-12 col-sm-4 emphasis">
                        <h2><strong> {{count($event_show->contacts)}} </strong></h2>
                        <p><small>Eventos</small></p>
                    </div>
                </div>
                <div class="col-xs-12 well">
                    @unless($event_show->contacts->isEmpty())
                        <div class="list-group">
                            @foreach($event_show->contacts as $contact)

                                <div class="list-group-item" >
                                    <div class="row">
                                        <div class="col-md-8"><a href="/contacts/{{$contact->id}}">
                                                <h4 class="list-group-item-heading">{{$contact->full_name}} - {{Carbon\Carbon::createFromTimestamp(strtotime($contact->pivot->date))->formatLocalized('%B %d, %Y')}}
                                                </h4>
                                                <p class="list-group-item-text">{{$contact->pivot->note}}</p>
                                            </a></div>
                                        <div class="col-md-4">
                                            {!! Form::open(['method' => 'delete', 'action' => ['EventsController@deleteContacts', $event_show->id],  'class' => 'pull-right']) !!}
                                            {!! Form::hidden('contact_id', $contact->id, ['class' => 'form-control']) !!}
                                            <button type="submit" data-original-title="Remove this Event" data-toggle="tooltip" class="btn btn-danger btn-sm">Delete <span class="glyphicon glyphicon-minus"></span></button></div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    @endunless

                        <div class="panel-footer">
                            <button data-original-title="Add Event" data-toggle="modal" data-target="#myModal" type="button" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-plus"></i>Añadir evento</button>
                        <span class="pull-right">
                            <a href="{{$event_show->id}}/edit" data-original-title="Edit this event" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                            {!! Form::open(['url' => route('events.destroy', $event_show->id), 'method' => 'delete', 'class' => 'pull-right']) !!}
                            <button type="submit" data-original-title="Remove this Event" data-toggle="tooltip" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
                            {!! Form::close() !!}
                        </span>
                        </div>
                </div>
            </div>
        </div>
    </div>

            <!-- Bulk Add Contact Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add: {!! $event_show->name !!} Eventos a contactos</h4>
                    </div>
                    <div class="modal-body">

                        {!! Form::model($event_show, ['method' => 'PATCH', 'action' => ['EventsController@addContacts', $event_show->id]]) !!}
                        <div class="form-group">
                            {!! Form::label('contact_list','Evento Personal:') !!}
                            {!! Form::select('contact_list[]', $contacts, null, ['id'=>'contact_list', 'class' => 'form-control', 'multiple']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('event_date','Fecha:') !!}
                            {!! Form::input('date', 'event_date', date('Y-m-d'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('event_text','Note:') !!}
                            {!! Form::text('event_text', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Add Contact Eventos', ['class' => 'btn btn-primary form-control']) !!}
                        </div>
                        {!! Form::close() !!}

                        @include('errors.list')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

@stop

@section('footer')

@stop