@extends('layouts.app')

@section('content')

    <h1>Edit: {!! $group->name !!}</h1>
    <hr/>

    {!! Form::model($group, ['method' => 'PATCH', 'action' => ['GroupsController@update', $group->id]]) !!}
    @include('groups.form', ['submitButtonText' =>'Grupo actualización'])
    {!! Form::close() !!}

    @include('errors.list')
@stop