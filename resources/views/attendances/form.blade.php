<div class="form-group">
    {!! Form::label('service_id','Service Type:') !!}
    {!! Form::select('service_id', $services, null, ['id'=>'service_list', 'class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('adults','Adultos:') !!}
    {!! Form::number('adults', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('kids','Ninos:') !!}
    {!! Form::number('kids', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('extremies','Personas de Extreme:') !!}
    {!! Form::number('extremies', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('offering','Offering:') !!}
        {!! Form::number('offering', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('tithe','Tithe:') !!}
    {!! Form::number('tithe', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('other_income','Other Income:') !!}
    {!! Form::number('other_income', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('date','Fecha:') !!}
    {!! Form::input('date', 'date', $attendance->date->format('Y-m-d'), ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('note','Note:') !!}
    {!! Form::text('note', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>
@section('footer')
    <script type="text/javascript">
        $('#service_list').select2({
            placeholder: "Seleccione su Servico:",
            allowClear: false
        });

    </script>
@endsection