@extends('app')

@section('content')

    <div class="row">
        <div class="col-md-8">
            {{--@foreach ($project->tasks() as $task)--}}
                {{--<li>{{ $task }}</li>--}}
            {{--@endforeach--}}
        </div>
        <div class="col-md-4">
            @include('projects.form')
        </div>
    </div>


@endsection