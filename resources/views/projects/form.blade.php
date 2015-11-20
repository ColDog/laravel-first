{!! Form::open(['route' => 'projects.store']) !!}
<div class="modal-body">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-group">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('description', 'Description') !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('users', 'Project Collaborators') !!}
        {!! Form::select('users[]', $users, null, ['class' => 'form-control', 'multiple' => 'true']) !!}
    </div>
</div>
<div class="modal-footer">
    {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>
</div>
{!! Form::close() !!}