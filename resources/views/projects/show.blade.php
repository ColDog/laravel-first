@extends('app')

@section('content')
    <script> var id = window.location.pathname.split('/')[2]; </script>
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

                                        <form action="/projects/{{ $project->id }}/tasks/{{ $task->id }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn-link pull-right glyphicon glyphicon-remove"></button>
                                        </form>
                                        <button data-task-id="{{ $task->id }}" class="btn-link text-default finish pull-right glyphicon glyphicon-check {{ $task->completed ? 'green' : '' }}"></button>
                                        <button
                                                type="button"
                                                class="btn-link text-default finish pull-right glyphicon glyphicon-pencil"
                                                data-toggle="modal"
                                                data-target="#edit"
                                                data-name="{{$task->name}}"
                                                data-slug="{{$task->slug}}"
                                                data-action="{{'/projects/' . $project->id . '/tasks/' . $task->id }}"
                                        >
                                        </button>

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
                            <div data-name="{{ $collaborator->name }}" draggable="true" id="{{ $collaborator->id }}" ondragstart="drag(event)" class="list-group-item">
                                <a href="/users/{{ $collaborator->id }}">
                                    {{ $collaborator->name }}
                                    <span class="badge pull-right">tasks: <span id="badge{{ $collaborator->id }}">{{ $collaborator->tasks()->count() }}</span></span>
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


    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Edit Task</h4>
                </div>
                <form id="editForm" method="POST" action="">
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">

                        <div class="form-group">
                            <label for="name" class="control-label">Name:</label>
                            <input name="name" type="text" class="form-control" id="name">
                        </div>

                        <div class="form-group">
                            <label for="slug" class="control-label">Slug:</label>
                            <input name="slug" type="text" class="form-control" id="slug">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>




    <script>

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
            var userId = ev.dataTransfer.getData("text");
            $.post(
                '/projects/'+id+'/tasks/assigned',
                {userId: userId, taskId: taskId, _token: '{{ csrf_token() }}' },
                function(data) {
                    console.log('badge'+userId, data);
                    $('#badge'+userId).text(data)
                }
            )
        }

        $('#edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            $('#editForm').attr('action', button.data('action'));
            modal.find('#name').val(button.data('name'));
            modal.find('#slug').val(button.data('slug'));
        })

    </script>


@endsection