@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-0 toppad" >


            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$contact_show->full_name}}</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <!--<div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="http://babyinfoforyou.com/wp-content/uploads/2014/10/avatar-300x300.png" class="img-circle img-responsive"> </div>-->

                        <div class=" col-md-9 col-lg-9 ">
                            <table class="table table-user-information">
                                <tbody>

                                @unless($contact_show->positions->isEmpty())
                                    <tr>
                                        <td>Posición:</td>
                                        <td>
                                            <ul>
                                                @foreach($contact_show->positions as $position)
                                                    <li><a href="/positions/{{$position->title}}">{{$position->title}}</a></li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endunless
                                <tr>
                                    <td>Fecha de aniversario:</td>
                                    <td>{{$contact_show->anniversary->formatLocalized('%B %d, %Y') }} - ({{$contact_show->anniversary->diffForHumans()}})</td>
                                </tr>
                                <tr>
                                    <td>Fecha de Nacimiento</td>
                                    <td>{{$contact_show->bday->formatLocalized('%B %d, %Y') }} - Años: {{$contact_show->bday->age }}</td>
                                </tr>
                                @unless($contact_show->leader_id == '')
                                <tr>
                                    <td>Líder</td>
                                    <td><a href="{{$contact_show->leader->id}}">{{$contact_show->leader->full_name}}</a></td>
                                </tr>
                                @endunless
                                <tr>
                                    <td>Direccion de casa</td>
                                    <td>{{$contact_show->address}}, {{$contact_show->city}}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><a href="mailto:{{$contact_show->email}}">{{$contact_show->email}}</a></td>
                                </tr>
                                <td>Teléfono</td>
                                <td>{{$contact_show->phone}}
                                </td>

                                </tr>
                                @unless($contact_show->follower->isEmpty())
                                <tr>
                                    <td>Discípulos - ({{count($contact_show->follower)}})</td>
                                    <td>
                                            <ul>
                                                @foreach($contact_show->follower as $follow)
                                                    <li><a href="{{$follow->id}}">{{$follow->full_name}} - {{count($follow->follower)}}</a></li>
                                                @endforeach
                                            </ul>
                                        </td>
                                </tr>
                                @endunless
                                @unless($contact_show->tags->isEmpty())
                                <tr>
                                    <td>Tags</td>
                                    <td>
                                            <ul>
                                                @foreach($contact_show->tags as $tag)
                                                    <li><a href="/tags/{{$tag->name}}">{{$tag->name}}</a></li>
                                                @endforeach
                                            </ul>
                                        </td>
                                </tr>
                                @endunless

                                <tr>
                                    <td>Grupos</td>
                                    <td>
                                        @unless($contact_show->groupLeader == '')
                                            <li>Líder de <a href="/groups/{{$contact_show->groupLeader->id}}">{{$contact_show->groupLeader->name}}</a></li>
                                        @endunless
                                        @unless($contact_show->groupHost == '')
                                            <li>Anfitrión de <a href="/groups/{{$contact_show->groupHost->id}}">{{$contact_show->groupHost->name}}</a></li>
                                        @endunless
                                        @unless($contact_show->groupTimothy == '')
                                            <li>Timoteo de <a href="/groups/{{$contact_show->groupTimothy->id}}">{{$contact_show->groupTimothy->name}}</a></li>
                                        @endunless
                                        @unless($contact_show->group_id == '')
                                            <li>Membro de <a href="/groups/{{$contact_show->group->id}}">{{$contact_show->group->name}}</a></li>
                                        @endunless

                                    </td>
                                </tr>
                                @unless($contact_show->events->isEmpty())
                                    <tr>
                                        <td>Eventos Personal</td>
                                        <td>
                                            <div class="list-group">
                                                @foreach($contact_show->events as $event)
                                                    <div class="list-group-item" >
                                                        <div class="row">
                                                            <div class="col-md-8"><a href="/events/{{$event->id}}">
                                                                    <h4 class="list-group-item-heading">{{$event->name}} - {{Carbon\Carbon::createFromTimestamp(strtotime($event->pivot->date))->formatLocalized('%B %d, %Y')}}
                                                                    </h4>
                                                                    <p class="list-group-item-text">{{$event->pivot->note}}</p>
                                                                </a></div>
                                                            <div class="col-md-4">
                                                                {!! Form::open(['method' => 'delete', 'action' => ['EventsController@deleteContacts', $event->id],  'class' => 'pull-right']) !!}
                                                                {!! Form::hidden('contact_id', $contact_show->id, ['class' => 'form-control']) !!}
                                                                <button type="submit" data-original-title="Remove this Event" data-toggle="tooltip" class="btn btn-danger btn-sm">Delete <span class="glyphicon glyphicon-minus"></span></button></div>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endunless
                                @unless($contact_show->trainings->isEmpty())
                                    <tr>
                                        <td>Formación</td>
                                        <td>
                                            <div class="list-group">
                                                @foreach($contact_show->trainings as $index => $training)
                                                    @unless($trainingCat == $training->category)
                                                        @unless($index == 0)
                                                        </div>
                                                        @endunless
                                                        <?php $trainingCat = $training->category; ?>
                                                        <a href="#{{preg_replace("/[^A-Za-z0-9]/", "", $training->category)}}" class="list-group-item" data-toggle="collapse">
                                                            <span class="glyphicon glyphicon-chevron-right"></span>{{$training->category}}
                                                        </a>
                                                        <div class="list-group collapse" id="{{preg_replace("/[^A-Za-z0-9]/", "", $training->category)}}">
                                                    @endunless
                                                    <div class="list-group-item" >
                                                        <div class="row">
                                                            <div class="col-md-8"><a href="/events/{{$training->id}}">
                                                                    <h4 class="list-group-item-heading">{{$training->name}} - {{Carbon\Carbon::createFromTimestamp(strtotime($training->pivot->date))->formatLocalized('%B %d, %Y')}}
                                                                    </h4>
                                                                    <p class="list-group-item-text">{{$training->pivot->note}}</p>
                                                                </a></div>
                                                            <div class="col-md-4">
                                                                {!! Form::open(['method' => 'delete', 'action' => ['EventsController@deleteContacts', $training->id],  'class' => 'pull-right']) !!}
                                                                {!! Form::hidden('contact_id', $contact_show->id, ['class' => 'form-control']) !!}
                                                                <button type="submit" data-original-title="Remove this Event" data-toggle="tooltip" class="btn btn-danger btn-sm">Delete <span class="glyphicon glyphicon-minus"></span></button></div>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                @endforeach
                                                </div><!--Extra Div closure to close last group-->
                                            </div>
                                        </td>
                                    </tr>
                                @endunless
                                        

                                </tbody>
                            </table>

                            <!-- Trigger the Eventmodal with a button -->
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#eventModal">Añadir Evento Personal</button>
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#groupModal">Añadir Asistencia de Gropo</button>
                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#trainingModal">Añadir Formación</button>

                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <!--<a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>-->
                        <span class="pull-right">
                            <a href="{{ url('/contacts/'.$contact_show->id.'/edit') }}" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                            {!! Form::open(['url' => route('contacts.destroy', $contact_show->id), 'method' => 'delete', 'class' => 'pull-right']) !!}
                            <button type="submit" data-original-title="Remove this user" data-toggle="tooltip" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
                            {!! Form::close() !!}
                        </span>
                </div>

            </div>
        </div>
    </div>
</div>



@include('contacts.modals.event', ['modalId' =>'eventModal'])
@include('contacts.modals.group', ['modalId' =>'groupModal'])
@include('contacts.modals.training', ['modalId' =>'trainingModal'])


@stop

@section('footer')

@stop