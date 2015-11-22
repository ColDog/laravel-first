@extends('app')

@section('content')
    <h1>My Dashboard</h1>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Notifications</h3></div>
                <div class="panel-body">
                    <ul class="list-group">
                        @forelse($messages as $message)
                            <li class="list-group-item">{!! $message !!}</li>
                        @empty
                            <li class="list-group-item">No Messages</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">My Tasks</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        @forelse($tasks as $task)
                            <li class="list-group-item">{{ $task->name }}</li>
                        @empty
                            <li class="list-unstyled"><h4>No Tasks Found</h4></li>
                        @endforelse
                    </ul>
                </div>

            </div>
        </div>
    </div>

@endsection