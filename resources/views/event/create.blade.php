@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create New Event</div>
                <div class="card-body">
                    <form action="{{ route('events.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Event Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <div class="mb-3">
                            <label for="event_date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="event_date" name="event_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="event_time" class="form-label">Time</label>
                            <input type="time" class="form-control" id="event_time" name="event_time" required>
                        </div>
                        <div class="mb-3">
                            <label for="ticket_price" class="form-label">Ticket Price</label>
                            <input type="number" class="form-control" id="ticket_price" name="ticket_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="available_tickets" class="form-label">Available Tickets</label>
                            <input type="number" class="form-control" id="available_tickets" name="available_tickets" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Event</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection