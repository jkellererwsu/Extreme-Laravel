@extends('layouts.app')

@section('content')

    <h1>Edit: {!! $attendance->date->format('Y-m-d') !!}</h1>
    <hr/>

    {!! Form::model($attendance, ['method' => 'PATCH', 'action' => ['AttendancesController@update', $attendance->id]]) !!}
    @include('attendances.form', ['submitButtonText' =>'Attendance actualización'])
    {!! Form::close() !!}

    @include('errors.list')
@stop