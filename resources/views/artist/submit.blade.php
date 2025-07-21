@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Submit Your Song</h2>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('artist.submit') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Artist Name</label>
            <input type="text" name="artist_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Song Title</label>
            <input type="text" name="song_title" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Featured Artists</label>
            <input type="text" name="featured_artists" class="form-control">
        </div>

        <div class="form-group">
            <label>Genre</label>
            <input type="text" name="genre" class="form-control">
        </div>

        <div class="form-group">
            <label>Language</label>
            <input type="text" name="language" class="form-control">
        </div>

        <div class="form-group">
            <label>Composer Name</label>
            <input type="text" name="composer_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Writer Name</label>
            <input type="text" name="writer_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Release Date</label>
            <input type="date" name="release_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Artwork (jpg/png)</label>
            <input type="file" name="artwork" class="form-control-file" required>
        </div>

        <div class="form-group">
            <label>Music File (mp3/wav)</label>
            <input type="file" name="music_file" class="form-control-file" required>
        </div>

        <div class="form-group">
            <label>Social Media Links</label>
            <textarea name="social_media_links" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone_number" class="form-control">
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="agreed_to_terms" class="form-check-input" required>
            <label class="form-check-label">I agree to the <a href="#">terms and conditions</a></label>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
