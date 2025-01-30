@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">{{ $event->name }}</h2>
                    <p class="card-text">{{ $event->description }}</p>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>Event Details</h5>
                            <ul class="list-unstyled">
                                <li><strong>Location:</strong> {{ $event->location }}</li>
                                <li><strong>Date:</strong> {{ $event->date }}</li>
                                <li><strong>Price:</strong> Rp {{ number_format($event->price, 0, ',', '.') }}</li>
                                <li><strong>Available Tickets:</strong> {{ $event->total_tiket }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Register for Event</h5>
                    <form action="{{ route('events.register', $event) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="ticket_quantity" class="form-label">Number of Tickets</label>
                            <input type="number" class="form-control" id="ticket_quantity" name="ticket_quantity" min="1" max="{{ $event->available_tickets }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection