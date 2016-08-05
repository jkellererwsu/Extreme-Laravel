@extends('layouts.app')

@section('content')
    <h1>Users</h1>
    <div class="list-group">
        @foreach ($users as $user)
            <a href="{{ action('ContactsController@show', [$user->id])}}" class="list-group-item">ID: {{$user->id}} - {{$user->email}} - {{$user->roles()->pluck('name')}}</a>
        @endforeach
    </div>
@stop

@section('footer')
@stop