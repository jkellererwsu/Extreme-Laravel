@extends('layouts.app')

@section('content')

    <h1>Edit: {!! $contact->fname !!} {!! $contact->lname !!}</h1>
    <hr/>

    {!! Form::model($contact, ['method' => 'PATCH', 'action' => ['ContactsController@update', $contact->id]]) !!}
    @include('contacts.form', ['submitButtonText' =>'Update Contact'])
    {!! Form::close() !!}

    @include('errors.list')
@stop