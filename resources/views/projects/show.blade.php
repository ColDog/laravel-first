@extends('app')

@section('content')
    <h1>{{ $project->name }}</h1>
    <hr>
    <div class="row">
        <div class="col-md-8">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Tasks</h3>
                </div>

                <div class="panel-body">
                    <div class="list-group">
                        @forelse($project->tasks()->get() as $task)
                            <li>{{ $task }}</li>
                        @empty
                            <h4>No Tasks Found</h4>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Collaborators</h3>
                </div>
                <div class="panel-body">
                    <div class="list-group">
                        @forelse($project->collaborators()->get() as $collaborator)
                            <a href="/users/{{ $collaborator->id }}" class="list-group-item">
                                <span class="badge">tasks: 2</span>
                                {{ $collaborator->name }}
                            </a>
                        @empty
                            <h4>No Collaborators Found</h4>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary btn-lg add" data-toggle="modal" data-target="#new">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
    </button>

    <div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">New Project</h4>
                </div>

                {!! Form::model($project, ['method' => 'put' ,'action' => ['ProjectsController@update', $project->id]]) !!}
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
                    {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>



@endsection