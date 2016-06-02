@extends('layouts.app')

@section('content')
<h1>Contactos</h1>
<a href="/contacts/create" type="button" class="btn btn-info btn-lg">Nuevo contacto</a>
<br />
<div class="list-group">
@foreach ($contacts as $contact)
        <a href="{{ action('ContactsController@show', [$contact->id])}}" class="list-group-item">{{$contact->full_name}}</a>
@endforeach
</div>
@stop

@section('footer')
@stop