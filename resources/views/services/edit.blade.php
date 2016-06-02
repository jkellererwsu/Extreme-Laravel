@extends('layouts.app')

@section('content')

    <h1>Edit: {!! $service->name !!}</h1>
    <hr/>

    {!! Form::model($service, ['method' => 'PATCH', 'action' => ['ServicesController@update', $service->id]]) !!}
    @include('services.form', ['submitButtonText' =>'Servico actualización'])
    {!! Form::close() !!}

    @include('errors.list')
@stop