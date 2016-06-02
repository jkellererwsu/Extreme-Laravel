<div class="form-group">
    {!! Form::label('fname','Primer nombre:') !!}
    {!! Form::text('fname', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('lname','Apellido:') !!}
    {!! Form::text('lname', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('email','Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('phone','Teléfono:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('position_list','Posición en la Iglesia:') !!}
    {!! Form::select('position_list[]', $positions, null, ['id'=>'position_list', 'class' => 'form-control' , 'multiple']) !!}
</div>
<div class="form-group">
    {!! Form::label('address','Dirección:') !!}
    {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Calle']) !!}
    {!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => 'Ciudad']) !!}
    </div>
<div class="form-group">
    {!! Form::label('leader_id','Líder de Contacto:') !!}
    {!! Form::select('leader_id', $leaders, null, ['id'=>'leader_list', 'class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('group_id','Groupo de Contacto:') !!}
    {!! Form::select('group_id', $groups, null, ['id'=>'group_list', 'class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('bday','Cumpleaños:') !!}
    {!! Form::input('date', 'bday', $contact->bday->format('Y-m-d'), ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('anniversary','Aniversario:') !!}
    {!! Form::input('date', 'anniversary', $contact->anniversary->format('Y-m-d'), ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('tag_list','Tags:') !!}
    {!! Form::select('tag_list[]', $tags, null, ['id'=>'tag_list', 'class' => 'form-control', 'multiple']) !!}
</div>
<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>
@section('footer')
<script type="text/javascript">
    $('#tag_list').select2({
        placeholder: "Seleccionar o añadir tags",
        tags: true,
        tokenSeparators: [",", " "],
        createTag: function(newTag) {
            return {
                id: 'new:' + newTag.term,
                text: newTag.term + ' (nuevo)'
            };
        }
    });
    $('#leader_list').select2({
        placeholder: "Seleccione su líder:",
        allowClear: true
    });
    $('#group_list').select2({
        placeholder: "Seleccione su gropo:",
        allowClear: true
    });
    $('#position_list').select2({
        placeholder: "Seleccione su Posición:",
        allowClear: true
    });
</script>
@endsection