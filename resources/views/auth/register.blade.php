@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">username</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="username" value="{{ old('username') }}">

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!--<div class="form-group{{ $errors->has('church_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Church</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="church_id" value="{{ old('church_id') }} - {{$churches}}">

                                @if ($errors->has('church_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('church_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>-->
                        <div class="form-group">
                            {!! Form::label('church_id','Church:') !!}
                            {!! Form::select('church_id', $churches, null, ['id'=>'church_id', 'class' => 'form-control']) !!}
                        </div>
                        <div id="church_hidden" style="display:none">
                            <div class="form-group">
                                {!! Form::label('church_address','Church Adress:') !!}
                                {!! Form::text('church_address', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('church_city','Church City:') !!}
                                {!! Form::text('church_city', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('church_country','Church Country:') !!}
                                {!! Form::text('church_country', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('church_district','Church District:') !!}
                                {!! Form::text('church_district', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
    <script type="text/javascript">
        $('#church_id').select2({
            placeholder: "Select or add Church",
            tags: true,
            tokenSeparators: [","],
            createTag: function(newChurch) {
                return {
                    id: 'new:' + newChurch.term,
                    text: newChurch.term + ' (new)'
                };
            }
        })
        .on("select2:select", function(e) {
            // mostly used event, fired to the original element when the value changes
           if((e['params']['data']['id']).substring(0,3) == 'new'){
               $('#church_hidden').show();
           }else{
               $('#church_hidden').hide();
           }
        });

    </script>
@endsection