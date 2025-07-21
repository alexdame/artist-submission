@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-lg font-bold">Choose a Distribution Plan</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($plans as $plan)
            <div class="border p-4 rounded-lg shadow-sm">
                <h3 class="text-xl font-bold">{{ $plan->name }}</h3>
                <p class="text-gray-600 mt-2">₦{{ number_format($plan->price) }}</p>
                <ul class="mt-2 text-sm text-gray-700 space-y-1">
                    @foreach (explode("\n", $plan->features) as $feature)
                        <li>✅ {{ $feature }}</li>
                    @endforeach
                </ul>
                <form action="{{ route('pay') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                    @if ($plan->price > 0)
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Pay with Paystack
                        </button>
                    @else
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Select Free Plan
                        </button>
                    @endif
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection
