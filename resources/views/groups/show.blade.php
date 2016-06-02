@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-0 col-sm-12 col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8">
                    <div class="col-sm-12 text-center well">
                        <div class="col-xs-12 col-sm-8">
                            <h2>{{$group_show->name}}</h2>
                            <p><strong>Cuando: </strong> Los {{$group_show->day}} a las {{$group_show->time}}</p>
                            <p><strong>Dónde: </strong> {{$group_show->address}}, {{$group_show->city}} {{$group_show->church->country}} </p>
                            <p><strong>Fundado: </strong> {{$group_show->founded->diffForHumans()}}</p>
                        </div>
                        <div class="col-xs-12 col-sm-4 emphasis">
                            <h2><strong> {{count($group_show->leader->follower)}} </strong></h2>
                            <p><small>Miembros</small></p>
                            <a href="/contacts/{{$group_show->leader->id}}" class="btn btn-success btn-block">Líder - {{$group_show->leader->full_name}}</a>
                            @unless($group_show->host == '')
                                <a href="/contacts/{{$group_show->host->id}}" class="btn btn-success btn-block">Anfitrión - {{$group_show->host->full_name}}</a>
                            @endunless
                            @unless($group_show->timothy == '')
                                <a href="/contacts/{{$group_show->timothy->id}}" class="btn btn-success btn-block">Timoteo - {{$group_show->timothy->full_name}}</a>
                            @endunless
                        </div>
                    </div>
                    <div class="col-xs-12 well">
                        <h1>Contacts</h1>
                        @unless($group_show->contact->isEmpty())
                            <div class="list-group">
                                @foreach ($group_show->contact as $contact)
                                    <a href="{{ action('ContactsController@show', [$contact->id])}}" class="list-group-item">{{$contact->full_name}}</a>
                                @endforeach
                            </div>
                        @endunless
                        <h1>attendance</h1>
                        @unless($group_show->contacts->isEmpty())
                            <div class="list-group list-group-root well">
                            @foreach ($group_show->contacts as $index =>$contact)
                                    @unless($group_date == $contact->pivot->date)
                                        @unless($index == 0)
                                            </div>
                                        @endunless
                        <?php
                        $group_date = $contact->pivot->date;
                        ?>
                        <a href="#{{strtotime($group_date)}}" class="list-group-item" data-toggle="collapse">
                            <span class="glyphicon glyphicon-chevron-right"></span>{{Carbon\Carbon::createFromTimestamp(strtotime($group_date))->formatLocalized('%B %d, %Y')}} - ({{$group_show->CountByDate($contact->pivot->date, $group_show->id)}})
                        </a>
                        <div class="list-group collapse" id="{{strtotime($group_date)}}">

                            @endunless
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-8"><a href="{{ action('ContactsController@show', [$contact->id])}}">
                                            <h4 class="list-group-item-heading">{{$contact->full_name}}</h4>
                                            <p class="list-group-item-text">{{$contact->pivot->note}}</p>
                                        </a></div>
                                    <div class="col-md-4">
                                        {!! Form::open(['method' => 'delete', 'action' => ['GroupsController@deleteContacts', $group_show->id],  'class' => 'pull-right']) !!}
                                        {!! Form::hidden('contact_id', $contact->id, ['class' => 'form-control']) !!}
                                        {!! Form::hidden('pivot_id', $contact->pivot->id, ['class' => 'form-control']) !!}

                                        <button type="submit" data-original-title="Remove this Event" data-toggle="tooltip" class="btn btn-danger btn-sm">Delete <span class="glyphicon glyphicon-minus"></span></button></div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            @endforeach
                            </div>
                        </div>
                        @endunless


                    <div class="panel-footer">
                        <button data-original-title="Add Group Attendance" data-toggle="modal" data-target="#myModal" type="button" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-plus"></i> Añadir Asistencia</button>

                        <span class="pull-right">
                            <a href="{{$group_show->id}}/edit" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                            {!! Form::open(['url' => route('groups.destroy', $group_show->id), 'method' => 'delete', 'class' => 'pull-right']) !!}
                            <button type="submit" data-original-title="Remove this group" data-toggle="tooltip" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
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
                    <h4 class="modal-title">Asistencia de {!! $group_show->name !!}</h4>
                </div>
                <div class="modal-body">

                    {!! Form::model($group_show, ['method' => 'PATCH', 'action' => ['GroupsController@addContacts', $group_show->id]]) !!}
                    <div class="form-group">
                        {!! Form::label('contact_list','Evento Personal:') !!}
                        {!! Form::select('contact_list[]', $contacts, null, ['id'=>'contact_list', 'class' => 'form-control', 'multiple']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('group_date','Fecha:') !!}
                        {!! Form::input('date', 'group_date', date('Y-m-d'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('group_text','Note:') !!}
                        {!! Form::text('group_text', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Asistencia', ['class' => 'btn btn-primary form-control']) !!}
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