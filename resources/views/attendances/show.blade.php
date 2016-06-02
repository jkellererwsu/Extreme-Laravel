@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
                <div class="col-sm-12 well">
                    <div class="col-xs-12 col-sm-8 text-center">
                        <h1>{{$attendance->service->name}}</h1>
                        <h2>{{$attendance->date->formatLocalized('%B %d, %Y')}}</h2>
                    </div>
                    <div class="col-xs-12 col-sm-4 emphasis text-center">
                        <h2><strong> {{$attendance->adults + $attendance->kids + $attendance->extremies}} </strong></h2>
                        <p><small>total attendance</small></p>
                        <h2><strong> {{$attendance->offering+ $attendance->tithe +$attendance->offering}} </strong></h2>
                        <p><small>total donations</small></p>
                    </div>
                    <div class="col-sm-6">
                        <p><strong>Offering</strong> {{$attendance->offering}}</p>
                        <p><strong>Tithe</strong> {{$attendance->tithe}}</p>
                        <p><strong>Other</strong> {{$attendance->other_income}}</p>
                    </div>
                    <div class="col-sm-6">
                        <p><strong>Adults</strong> {{$attendance->adults}}</p>
                        <p><strong>Kids</strong> {{$attendance->kids}}</p>
                        <p><strong>Extremies</strong> {{$attendance->extremies}}</p>
                    </div>
                    <div class="col-sm-12">
                        <p>{{$attendance->note}}</p>
                    </div>
                </div>

                    <div class="panel-footer col-sm-12 well">
                        <span class="pull-right">
                            <a href="{{$attendance->id}}/edit" data-original-title="Edit this attendance" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                            {!! Form::open(['url' => route('attendances.destroy', $attendance->id), 'method' => 'delete', 'class' => 'pull-right']) !!}
                            <button type="submit" data-original-title="Remove this Attendance" data-toggle="tooltip" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
                            {!! Form::close() !!}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>





@stop

@section('footer')

@stop