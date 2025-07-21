@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h3 class="text-danger">❌ {{ $message }}</h3>
    <p>There was a problem processing your payment.</p>
</div>
@endsection
