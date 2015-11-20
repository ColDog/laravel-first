@extends('app')

@section('content')

    <h1>Projects</h1>

    <hr>

    <table class="table">
        <thead>
        <tr><th>Name</th><th>Collaborators</th><th>Description</th><th></th><th></th></tr>
        </thead>
        @foreach( $projects as $project )
            <tr>
                <td>{{ $project->name }}</td>
                <td>
                    @foreach($project->collaborators()->get() as $collaborator)
                        <a href="/users/{{ $collaborator->id }}" class="btn-xs btn-default">{{ $collaborator->name }}</a>
                    @endforeach
                </td>
                <td>{{ str_limit($project->description, $limit = 150, $end = '...') }}</td>
                <td>
                    <a class="btn btn-primary" href="/projects/{{ $project->id }}"><span class="glyphicon glyphicon-pencil"></span></a>
                </td>
                <td>
                    <form action="/projects/{{ $project->id }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger glyphicon glyphicon-trash"></button>
                    </form>
                </td>
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
                @include('projects.form')
            </div>
        </div>
    </div>


@endsection