@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Dashboard</h2>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    My Registered Events
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Date</th>
                                    <th>Tickets</th>
                                    <th>Total Amount</th>
                                    <th>Payment Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registrations as $registration)
                                    <tr>
                                        <td>{{ $registration->event->name }}</td>
                                        <td>{{ $registration->event->event_date->format('d M Y') }}</td>
                                        <td>{{ $registration->ticket_quantity }}</td>
                                        <td>Rp {{ number_format($registration->ticket_quantity * $registration->event->ticket_price, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $registration->payment_status === 'paid' ? 'success' : 'warning' }}">
                                                {{ ucfirst($registration->payment_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($registration->payment_status === 'pending')
                                                <button class="btn btn-sm btn-primary pay-button" 
                                                        data-token="{{ $registration->payment->snap_token }}">
                                                    Pay Now
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.pay-button').forEach(button => {
        button.addEventListener('click', function() {
            const token = this.dataset.token;
            snap.pay(token, {
                onSuccess: function(result) {
                    window.location.reload();
                },
                onPending: function(result) {
                    alert('Payment pending');
                },
                onError: function(result) {
                    alert('Payment failed');
                }
            });
        });
    });
</script>
@endsection