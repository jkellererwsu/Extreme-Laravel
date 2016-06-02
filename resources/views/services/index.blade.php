@extends('layouts.app')

@section('content')
    <h1>Servico</h1>
    <a href="/services/create/" type="button" class="btn btn-info btn-lg">Crea un servico</a>

    <div class="list-group">
        @foreach ($services as $service)
            <a href="{{ action('ServicesController@show', [$service->id])}}" class="list-group-item">{{$service->name}}
                @unless($service->attendance->isEmpty()) - ({{$service->attendance->first()->adults + $service->attendance->first()->kids + $service->attendance->first()->extremies}})
                @endunless
            </a>
        @endforeach
    </div>
@stop

@section('footer')
@stop