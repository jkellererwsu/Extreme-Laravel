@extends('layouts.app')


@section('content')
    <h1>New Group</h1>
    <hr/>

    {!! Form::model($group = new \App\Group, ['url' => 'groups']) !!}
    @include('groups.form', ['submitButtonText' =>'Añadir grupo'])
    {!! Form::close() !!}

    @include('errors.list')
@stop