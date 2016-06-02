<!-- Service Modal -->
<div id="{{$modalId}}" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit: {!! $contact_show->full_name !!} Grupo</h4>
            </div>
            <div class="modal-body">

                {!! Form::model($contact_show, ['method' => 'PATCH', 'action' => ['ContactsController@syncGroups', $contact_show->id]]) !!}
                <div class="form-group">
                    {!! Form::label('group_id','Gropo:') !!}
                    {!! Form::select('group_id', $groups, /*$contact_show->group->id*/ null , ['id'=>'service_list', 'class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('group_date','Fecha:') !!}
                    {!! Form::input('date', 'group_date', date('Y-m-d'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('group_text','Note:') !!}
                    {!! Form::text('group_text', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::submit('Add Contact Gropo', ['class' => 'btn btn-primary form-control']) !!}
                </div>
                {!! Form::close() !!}

                @include('errors.list')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>