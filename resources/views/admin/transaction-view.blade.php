@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Transaction Details</h4>

    <table class="table table-bordered mt-4">
        <tr><th>Reference</th><td>{{ $transaction->reference }}</td></tr>
        <tr><th>Email</th><td>{{ $transaction->email }}</td></tr>
        <tr><th>Amount</th><td>₦{{ number_format($transaction->amount / 100, 2) }}</td></tr>
        <tr><th>Status</th><td>{{ ucfirst($transaction->status) }}</td></tr>
        <tr><th>Channel</th><td>{{ $transaction->channel }}</td></tr>
        <tr><th>Currency</th><td>{{ $transaction->currency }}</td></tr>
        <tr><th>Paid At</th><td>{{ $transaction->paid_at }}</td></tr>
        <tr><th>Created At</th><td>{{ $transaction->created_at }}</td></tr>
    </table>

    <a href="{{ route('admin.transactions') }}" class="btn btn-secondary mt-3">Back to Transactions</a>
</div>
@endsection
