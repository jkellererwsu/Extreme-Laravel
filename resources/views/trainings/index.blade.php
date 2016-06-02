@extends('layouts.app')

@section('content')
    <h1>Entrenamientos</h1>
   <!-- <a href="/trainings/create/" type="button" class="btn btn-info btn-lg">Agregar clase de formación</a>-->
    <div class="list-group">
        @foreach ($trainings as $index => $training)
            @unless($trainingCat == $training->category)
                @unless($index == 0)
                    </div>
                @endunless
                <?php $trainingCat = $training->category; ?>
                <a href="#{{preg_replace("/[^A-Za-z0-9]/", "", $training->category)}}" class="list-group-item" data-toggle="collapse">
                    <span class="glyphicon glyphicon-chevron-right"></span>{{$training->category}}
                </a>
                <div class="list-group collapse" id="{{preg_replace("/[^A-Za-z0-9]/", "", $training->category)}}">
             @endunless
            <a href="{{ action('TrainingsController@show', [$training->id])}}" class="list-group-item">{{$training->name}} - {{count($training->contacts)}}</a>
        @endforeach
        </div><!--Extra Div closure to close last group-->
    </div>
@stop

@section('footer')

@stop