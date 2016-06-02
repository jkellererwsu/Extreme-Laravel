@extends('layouts.app')


@section('content')
    <h1>New Event</h1>
    <hr/>

    {!! Form::model($event = new \App\Event, ['url' => 'events']) !!}
    @include('events.form', ['submitButtonText' =>'Añadir evento'])
    {!! Form::close() !!}

    @include('errors.list')
@stop