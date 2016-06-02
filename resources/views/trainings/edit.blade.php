@extends('layouts.app')

@section('content')

    <h1>Edit: {!! $training->name !!}</h1>
    <hr/>

    {!! Form::model($training, ['method' => 'PATCH', 'action' => ['TrainingsController@update', $training->id]]) !!}
    @include('trainings.form', ['submitButtonText' =>'Clase actualización'])
    {!! Form::close() !!}

    @include('errors.list')
@stop