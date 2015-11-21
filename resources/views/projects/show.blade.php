@extends('app')

@section('content')
    <style>
        .green { color: green !important; }
        [draggable] {
            -moz-user-select: none;
            -khtml-user-select: none;
            -webkit-user-select: none;
            user-select: none;
            /* Required to make elements draggable in old WebKit */
            -khtml-user-drag: element;
            -webkit-user-drag: element;
        }
    </style>

    <h1>{{ $project->name }}</h1>
    <hr>
    <div class="row">
        <div class="col-md-8">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Tasks</h3>
                </div>

                <div class="panel-body">

                    <div class="row">
                        @forelse($project->tasks()->get() as $task)
                            <div class="col-sm-6 col-md-4">
                                <div class="thumbnail" id="{{ $task->id }}" ondrop="dragged(event, this.id)" ondragover="allow(event)">
                                    <div class="caption">
                                        <span data-task-id="{{ $task->id }}" class="finish close glyphicon glyphicon-check {{ $task->completed ? 'green' : '' }}"></span>
                                        <h3>{{ $task->name }}</h3>
                                        <p>{{ $task->slug }}</p>
                                        <small>Target Date: {{ $task->intended_completion }}</small>
                                        <hr>
                                        <h6>Description</h6>
                                        <small>{{ $task->description }}</small>
                                        <h6>Assigned to: <span id="name{{ $task->id }}">{{ $task->user()->get()->isEmpty() ? '' : $task->user()->get()[0]->name }}</span></h6>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <h4>No Tasks Found</h4>
                        @endforelse
                    </div>

                </div>

                <div class="panel-footer">
                    <h5>New Task</h5>
                    {!! Form::open(['route' => ['projects.tasks.store', $project->id], 'class' => 'form-inline']) !!}

                    <div class="form-group">
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'task name']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'short description']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::input('date', 'intended_completion', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Add Task', ['class' => 'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}
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
                            <div data-name="{{ $collaborator->name }}" draggable="true" id="{{ $project->id }}" ondragstart="drag(event)" class="list-group-item">
                                <a href="/users/{{ $collaborator->id }}">
                                    {{ $collaborator->name }}
                                    <span class="badge pull-right">tasks: 2</span>
                                </a>
                            </div>
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




    <script>
        var id = window.location.pathname.split('/')[2];

        $('[data-task-id]').click(function(evt){
            $(this).toggleClass( 'green' );
            $.post(
                '/projects/'+id+'/tasks/completion',
                {id: $(this).data('task-id'), _token: '{{ csrf_token() }}' }
            )
        });

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
            ev.dataTransfer.setData("name", ev.target.dataset.name);
        }

        function allow(ev) {
            ev.preventDefault();
        }

        function dragged(ev, taskId) {
            $('#name'+taskId).text(ev.dataTransfer.getData("name"));
            $.post(
                '/projects/'+id+'/tasks/assigned',
                {userId: ev.dataTransfer.getData("text"), taskId: taskId, _token: '{{ csrf_token() }}' }
            )
        }

    </script>


@endsection