@extends('layouts.app')


@section('content')
    <h1>New Training</h1>
    <hr/>

    {!! Form::model($training = new \App\Training, ['url' => 'trainings']) !!}
    @include('trainings.form', ['submitButtonText' =>'Añadir Clase'])
    {!! Form::close() !!}

    @include('errors.list')
@stop