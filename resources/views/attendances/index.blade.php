@extends('layouts.app')

@section('content')
    <h1>Attendance</h1>
    <a href="/attendances/create/" type="button" class="btn btn-info btn-lg">Crea un attendance</a>

    <div class="list-group">
        @foreach ($attendances as $attendance)
            <a href="{{ action('AttendancesController@show', [$attendance->id])}}" class="list-group-item">{{$attendance->date->formatLocalized('%B %d, %Y')}} - {{$attendance->service->name}}
            </a>
        @endforeach
    </div>
@stop

@section('footer')
    <h1>the footer</h1>
@stop