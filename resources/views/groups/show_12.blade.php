@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
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
                    @unless($group_show->leader->follower->isEmpty())
                        <div class="list-group">
                            @foreach ($group_show->leader->follower as $contact)
                                <a href="{{ action('ContactsController@show', [$contact->id])}}" class="list-group-item">{{$contact->full_name}}</a>
                            @endforeach
                        </div>
                    @endunless


                    <div class="panel-footer">
                        <!--<a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>-->
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



@stop

@section('footer')

@stop