@extends('layouts.app')


@section('content')
    <h1>New attendance</h1>
    <hr/>

    {!! Form::model($attendance = new \App\Attendance, ['url' => 'attendances']) !!}
    @include('attendances.form', ['submitButtonText' =>'Añadir attendance'])
    {!! Form::close() !!}

    @include('errors.list')
@stop