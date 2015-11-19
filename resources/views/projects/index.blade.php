@extends('layouts.app')

@section('content')

    <h1>Projects</h1>

    <hr>

    <table class="table">
        @foreach( $projects as $project )
            <tr>
                <td>{{ $project->name }}</td>
                <td>{{ str_limit($project->description, $limit = 150, $end = '...') }}</td>
            </tr>
        @endforeach
    </table>

    <button type="button" class="btn btn-primary btn-lg add" data-toggle="modal" data-target="#new">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
    </button>

    <div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">New Project</h4>
                </div>
                {!! Form::open(['route' => 'projects.store']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('name', 'Name') !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', 'Description') !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


@endsection