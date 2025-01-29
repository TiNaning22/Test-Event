@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Available Events</h2>
        </div>
        @auth
            <div class="col text-end">
                <a href="{{ route('events.create') }}" class="btn btn-primary">Create Event</a>
            </div>
        @endauth
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
                            <li><strong>Date:</strong> {{ $event->event_date->format('d M Y') }}</li>
                            <li><strong>Time:</strong> {{ $event->event_time }}</li>
                            <li><strong>Price:</strong> Rp {{ number_format($event->ticket_price, 0, ',', '.') }}</li>
                            <li><strong>Available Tickets:</strong> {{ $event->available_tickets }}</li>
                        </ul>
                        <a href="{{ route('events.show', $event) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection