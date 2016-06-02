@extends('layouts.app')


@section('content')
    <h1>New Service</h1>
    <hr/>

    {!! Form::model($service = new \App\Service, ['url' => 'services']) !!}
    @include('services.form', ['submitButtonText' =>'Añadir servico'])
    {!! Form::close() !!}

    @include('errors.list')
@stop