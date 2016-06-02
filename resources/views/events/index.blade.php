@extends('layouts.app')

@section('content')
    <h1>Eventos</h1>
    <a href="/events/create/" type="button" class="btn btn-info btn-lg">Crea un evento</a>


    <div class="list-group">
        @foreach ($events as $event)
            <a href="{{ action('EventsController@show', [$event->id])}}" class="list-group-item">{{$event->name}} - ({{count($event->contacts)}})</a>
        @endforeach
    </div>
@stop

@section('footer')
    
@stop