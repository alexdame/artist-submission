@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Submit Your Music</h2>
    <form action="{{ route('artist.submission.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Artist and song fields -->
        <input type="text" name="artist_name" placeholder="Artist Name" required><br>
        <input type="text" name="song_title" placeholder="Song Title" required><br>
        <input type="text" name="featured_artists" placeholder="Featured Artists"><br>
        <input type="text" name="genre" placeholder="Genre"><br>
        <input type="text" name="language" placeholder="Language"><br>
        <input type="text" name="composer_name" placeholder="Composer Name" required><br>
        <input type="text" name="writer_name" placeholder="Writer Name" required><br>
        <input type="date" name="release_date" required><br>

        <label>Artwork Image:</label>
        <input type="file" name="artwork" required><br>

        <label>Music File:</label>
        <input type="file" name="music_file" required><br>

        <input type="text" name="social_media_links" placeholder="Social Media Links"><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="text" name="phone_number" placeholder="Phone Number"><br>

        <label>
            <input type="checkbox" name="agreed_to_terms" required> I agree to the terms and conditions
        </label><br>

        <button type="submit">Submit</button>
    </form>
</div>
@endsection
