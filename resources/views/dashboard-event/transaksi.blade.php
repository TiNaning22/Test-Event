@extends('layouts-dashboard.main')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <h5>Data Transaksi</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No Hp</th>
                            <th>Jumlah Tiket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi as $key => $transaction)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                                <td>{{ $transaction->full_name }}</td>
                                <td>{{ $transaction->phone_number }}</td>
                                <td>{{ $transaction->ticket_quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection