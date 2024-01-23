@extends('layouts.app')

@section('content')
    <h1>Show Events</h1>
    
        <div>
            <h2>{{ $event->name }}</h2>
            <p>{{ $event->description }}</p>
        </div>
@endsection