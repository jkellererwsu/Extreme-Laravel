@extends('layouts.app')


@section('content')
<h1>New Contact</h1>
<hr/>

{!! Form::model($contact = new \App\contact, ['url' => 'contacts']) !!}
	@include('contacts.form', ['submitButtonText' =>'Add Contact'])
{!! Form::close() !!}

    @include('errors.list')
@stop