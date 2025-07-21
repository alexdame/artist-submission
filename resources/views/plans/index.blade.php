@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Choose a Plan</h2>

    <form method="POST" action="{{ route('paystack.redirect') }}">
        @csrf
        <div class="form-group mb-3">
            <label>Email address</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Select a Plan</label>
            <select name="plan_id" class="form-control" required>
                @foreach($plans as $plan)
                    <option value="{{ $plan->id }}">
                        {{ $plan->name }} — ₦{{ number_format($plan->price) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Proceed to Paystack</button>
    </form>
</div>
@endsection
