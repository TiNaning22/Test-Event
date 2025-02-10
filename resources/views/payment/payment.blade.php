@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payment Details</h3>
                </div>
                <div class="card-body">
                    <div class="order-summary mb-4">
                        <h4>Order Summary</h4>
                        @foreach ($payments as $item)
                            
                       
                        <table class="table">
                            <tr>
                                <td>Event</td>
                                <td>{{ $event->name }}</td>
                            </tr>
                            <tr>
                                <td>Tickets</td>
                                <td>{{ $peserta->ticket_quantity }}</td>
                            </tr>
                            <tr>
                                <td>Price per Ticket</td>
                                <td>Rp {{ number_format($event->ticket_price, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="fw-bold">
                                <td>Total Amount</td>
                                <td>Rp {{ number_format($peserta->ticket_quantity * $event->ticket_price, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                        @endforeach
                    </div>

                    <div class="payment-buttons text-center">
                        <button id="pay-button" class="btn btn-primary btn-lg">
                            Pay Now
                        </button>
                    </div>

                    <div id="payment-status" class="mt-4 d-none">
                        <div class="alert alert-info">
                            Processing payment...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
const payButton = document.getElementById('pay-button');
const statusDiv = document.getElementById('payment-status');

payButton.addEventListener('click', async () => {
    try {
        payButton.disabled = true;
        statusDiv.classList.remove('d-none');
        
        // Get snap token from backend
        const response = await fetch('/payments/token/${pesertaId}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        
        const data = await response.json();
        
        if (!data.snap_token) {
            throw new Error('Failed to get payment token');
        }

        // Open Snap payment popup
        window.snap.pay(data.snap_token, {
            onSuccess: function(result) {
                handlePaymentResult('success', result);
            },
            onPending: function(result) {
                handlePaymentResult('pending', result);
            },
            onError: function(result) {
                handlePaymentResult('error', result);
            },
            onClose: function() {
                payButton.disabled = false;
                statusDiv.classList.add('d-none');
            }
        });

    } catch (error) {
        console.error('Payment Error:', error);
        statusDiv.innerHTML = `
            <div class="alert alert-danger">
                Payment failed: ${error.message}
            </div>
        `;
        payButton.disabled = false;
    }
});

function handlePaymentResult(status, result) {
    const alertClass = {
        success: 'alert-success',
        pending: 'alert-warning',
        error: 'alert-danger'
    }[status];

    const message = {
        success: 'Payment successful! You will receive an email confirmation shortly.',
        pending: 'Payment is pending. Please complete the payment using the provided instructions.',
        error: 'Payment failed. Please try again or contact support.'
    }[status];

    statusDiv.innerHTML = `
        <div class="alert ${alertClass}">
            ${message}
        </div>
    `;

    if (status === 'success') {
        setTimeout(() => {
            window.location.href = '/dashboard';
        }, 2000);
    } else {
        payButton.disabled = false;
    }

    // Send result to backend
    fetch('/payments/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            order_id: result.order_id,
            status: status,
            payment_type: result.payment_type,
            transaction_time: result.transaction_time
        })
    });
}
</script>
@endpush
@endsection
