<!-- resources/views/submission/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Submit Your Music</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('submission.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title">Song Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="genre">Genre</label>
            <input type="text" name="genre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="audio_file">Upload Audio (MP3/WAV)</label>
            <input type="file" name="audio_file" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit Song</button>
    </form>
</div>
@endsection
