@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Upload Royalty Data (CSV)</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.royalty.upload') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Royalty CSV File:</label>
            <input type="file" name="csv_file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Upload & Match</button>
    </form>
</div>
@endsection
