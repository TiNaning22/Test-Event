@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Available Events</h2>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($events as $event)
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->name }}</h5>
                        <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                        <ul class="list-unstyled">
                            <li><strong>Location:</strong> {{ $event->location }}</li>
                            <li><strong>Date:</strong> {{ $event->date }}</li>
                            <li><strong>Price:</strong> Rp {{ number_format($event->price, 0, ',', '.') }}</li>
                            <li><strong>Available Tickets:</strong> {{ $event->total_tiket }}</li>
                        </ul>
                        <a href="{{ route('events.show', $event->id) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection