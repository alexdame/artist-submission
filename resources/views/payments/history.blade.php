@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Your Payment History</h2>

    @if ($payment)
        <div class="card p-4 shadow">
            <p><strong>Plan:</strong> {{ $plan->name ?? 'Unknown' }}</p>
            <p><strong>Amount Paid:</strong> ₦{{ number_format($payment->amount, 2) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($payment->status) }}</p>
            <p><strong>Channel:</strong> {{ ucfirst($payment->channel) }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($payment->created_at)->toDayDateTimeString() }}</p>
        </div>
    @else
        <p>No payment history available.</p>
    @endif
</div>
@endsection
