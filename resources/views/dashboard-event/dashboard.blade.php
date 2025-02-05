@extends('layouts-dashboard.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Data Event
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Event</th>
                                    <th>Deskripsi</th>
                                    <th>Lokasi</th>
                                    <th>Tanggal</th>
                                    <th>Harga</th>
                                    <th>Available Tiket</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($event as $e)
                                    <tr>
                                        <td>{{ $e->name }}</td>
                                        <td>{{ $e->description }}</td>
                                        <td>{{ $e->location }}</td>
                                        <td>{{ $e->date }}</td>
                                        <td>Rp. {{ number_format($e->price, 0, ',', '.') }}</td>
                                        <td>{{ $e->total_tiket }}</td>
                                        <td>
                                            <a href="{{ route('events.show', $e->id) }}" class="btn btn-primary">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col text-end">
                            <a href="{{ route('dashboard.create') }}" class="btn btn-primary">Create Event</a>
                        </div>
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