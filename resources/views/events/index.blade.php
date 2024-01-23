@extends('layouts.app')

@section('content')
    <h1>Events</h1>
    @foreach($events as $event)
        <div>
            <h2>{{ $event->name }}</h2>
            <p>{{ $event->description }}</p>
        </div>
    @endforeach
@endsection