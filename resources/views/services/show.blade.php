@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8">
                <div class="col-sm-12 text-center well">
                    <div class="col-xs-12 col-sm-8">
                        <h2>{{$service_show->name}}</h2>
                    </div>
                    <div class="col-xs-12 col-sm-4 emphasis">
                        @unless($service_show->attendance->isEmpty())
                        <h2><strong> {{$service_show->attendance->first()->adults + $service_show->attendance->first()->kids + $service_show->attendance->first()->extremies}} </strong></h2>
                        <p><small>Servicio pasado</small></p>
                        @endunless
                    </div>
                </div>
                <div class="col-xs-12 well">
                    @unless($service_show->attendance->isEmpty())
                        <div class="list-group">
                            @foreach ($service_show->attendance as $attendance)
                                <div class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-8"><a href="/attendances/{{$attendance->id}}">
                                                <h4 class="list-group-item-heading">{{$attendance->date->formatLocalized('%B %d, %Y')}} -  ({{$attendance->adults + $attendance->kids + $attendance->extremies}})</h4>
                                                <p class="list-group-item-text">{{$attendance->note}}</p>
                                            </a></div>
                                        <div class="col-md-4">
                                            {!! Form::open(['url' => route('attendances.destroy', $attendance->id), 'method' => 'delete', 'class' => 'pull-right']) !!}
                                            <button type="submit" data-original-title="Remove this Event" data-toggle="tooltip" class="btn btn-danger btn-sm">Delete <span class="glyphicon glyphicon-minus"></span></button></div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endunless

                    <div class="panel-footer">
                        <a href="{{route('attendances.create','serviceId='.$service_show->id)}}" type="button" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-plus"></i> Añadir Asistencia</a>
                        <span class="pull-right">
                            <a href="{{$service_show->id}}/edit" data-original-title="Edit this Service" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                            {!! Form::open(['url' => route('services.destroy', $service_show->id), 'method' => 'delete', 'class' => 'pull-right']) !!}
                            <button type="submit" data-original-title="Remove this Service" data-toggle="tooltip" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
                            {!! Form::close() !!}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>





@stop

@section('footer')
    <script type="text/javascript">
        $(function() {

            $('.list-group-item').on('click', function() {
                $('.glyphicon', this)
                        .toggleClass('glyphicon-chevron-right')
                        .toggleClass('glyphicon-chevron-down');
            });

        });
    </script>
@stop