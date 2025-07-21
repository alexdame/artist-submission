@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Paystack Transactions</h2>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="email" class="form-control" placeholder="Search by email" value="{{ request('email') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-control">
                <option value="">All Status</option>
                <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.transactions') }}" class="btn btn-secondary w-100">Reset</a>
        </div>
    </form>

<div class="mb-3 text-end">
    <a href="{{ route('admin.transactions.export', request()->all()) }}" class="btn btn-success">
        Export CSV
    </a>
</div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Reference</th>
                    <th>Email</th>
                    <th>Amount (₦)</th>
                    <th>Status</th>
                    <th>Channel</th>
                    <th>Paid At</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $tx)
                <tr>
                    <td>{{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}</td>
<td>
    <a href="{{ route('admin.transactions.view', $tx->reference) }}">
        {{ $tx->reference }}
    </a>
</td>
                    <td>{{ $tx->email }}</td>
                    <td>{{ number_format($tx->amount / 100, 2) }}</td>
                    <td>
                        <span class="badge bg-{{ $tx->status == 'success' ? 'success' : 'danger' }}">
                            {{ ucfirst($tx->status) }}
                        </span>
                    </td>
                    <td>{{ ucfirst($tx->channel) }}</td>
                    <td>{{ $tx->paid_at ? \Carbon\Carbon::parse($tx->paid_at)->format('Y-m-d H:i') : '-' }}</td>
                    <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No transactions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $transactions->withQueryString()->links() }}
</div>
@endsection
