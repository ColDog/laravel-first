@extends('layouts.app')

@section('content')

    <h1>Projects</h1>
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
                <div class="modal-body">
                    {!! Form::open(array('method' => 'POST', 'route' => array('projects.destroy', $project->slug))) !!}
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


@endsection