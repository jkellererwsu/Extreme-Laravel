<div class="form-group">
    {!! Form::label('name','Nombre del grupo:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('leader_id','Líder del grupo:') !!}
    {!! Form::select('leader_id', $leaders, null, ['id'=>'leader_list', 'class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('host_id','Anfitrión del Grupo:') !!}
    {!! Form::select('host_id', $host, null, ['id'=>'host_list', 'class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('timothy_id','Timoteo del Grupo:') !!}
    {!! Form::select('timothy_id', $timothy, null, ['id'=>'timothy_list', 'class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('day','Día de la semana:') !!}
    {!! Form::select('day', ['Lunes' => 'Lunes', 'Martes' => 'Martes', 'Miércoles' => 'Miércoles', 'Jueves' => 'Jueves', 'Viernes' => 'Viernes', 'Sábado' => 'Sábado', 'Domingo' => 'Domingo'], null, ['id'=>'day_list', 'class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('time','Hora:') !!}
    {!! Form::input('time', 'time', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('founded','Fecha de Fundación:') !!}
    {!! Form::input('date', 'founded', $group->founded->format('Y-m-d'), ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('address','Dirección:') !!}
    {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Calle']) !!}
    {!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => 'Ciudad']) !!}
</div>
<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>
@section('footer')
    <script type="text/javascript">
        $('#timothy_list').select2({
            placeholder: "Seleccione el Timoteo:",
            allowClear: true
        });
        $('#host_list').select2({
            placeholder: "Seleccione el Anfitrión:",
            allowClear: true
        });
    </script>
@endsection