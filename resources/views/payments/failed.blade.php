<h2>Payment Failed</h2>
<p>Something went wrong with your transaction.</p>
@if(session('error'))
    <p>{{ session('error') }}</p>
@endif
