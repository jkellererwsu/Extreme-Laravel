@extends('layouts.app')

@section('content')
    <h1>Grupos</h1>
    <a href="/groups/create/" type="button" class="btn btn-info btn-lg">Crea un grupo abierto</a>
    <br />
    <a href="#openGroups" class="list-group-item" data-toggle="collapse">
        <span class="glyphicon glyphicon-chevron-right"></span>Grupos abiertos
    </a>
    <div class="list-group collapse" id="openGroups">
    <div class="list-group">
        @foreach ($groups as $group)
            <a href="{{ action('GroupsController@show', [$group->id])}}" class="list-group-item">{{$group->name}} - ({{count($group->contact)}})</a>
        @endforeach
    </div>
    </div>

    <a href="#GroupOf12" class="list-group-item" data-toggle="collapse">
        <span class="glyphicon glyphicon-chevron-right"></span>Grupos de 12
    </a>
    <div class="list-group collapse" id="GroupOf12">
    <div class="list-group">
        @foreach ($leaders as $leader)
            <a href="{{ action('ContactsController@show', [$leader->id])}}" class="list-group-item">12 de {{$leader->full_name}} - ({{count($leader->follower)}})</a>
        @endforeach
    </div>
    </div>
@stop

@section('footer')
    
@stop