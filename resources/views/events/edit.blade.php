@extends('layouts.app')

@section('content')

    <h1>Edit: {!! $event->name !!}</h1>
    <hr/>

    {!! Form::model($event, ['method' => 'PATCH', 'action' => ['EventsController@update', $event->id]]) !!}
    @include('events.form', ['submitButtonText' =>'Evento actualización'])
    {!! Form::close() !!}

    @include('errors.list')
@stop