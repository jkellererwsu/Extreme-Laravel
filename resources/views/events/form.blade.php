<div class="form-group">
    {!! Form::label('name','Nombre del evento:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('displayOrder','Display order:') !!}
    {!! Form::text('displayOrder', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>
@section('footer')
    <script type="text/javascript">

    </script>
@endsection