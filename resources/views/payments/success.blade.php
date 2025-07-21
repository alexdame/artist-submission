<h2>Payment Successful!</h2>
<p>Reference: {{ $data->reference }}</p>
<p>Status: {{ $data->status }}</p>
<p>Amount: ₦{{ number_format($data->amount / 100, 2) }}</p>
