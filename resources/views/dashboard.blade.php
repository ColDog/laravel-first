@extends('app')

@section('content')
    <h1>My Dashboard</h1>


    <ul class="list-group">
        @forelse($messages as $message)
            <li class="list-group-item">{{ $message }}</li>
        @empty
            <li class="list-group-item">No Messages</li>
        @endforelse
    </ul>

@endsection