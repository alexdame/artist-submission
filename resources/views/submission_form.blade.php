{{-- resources/views/submission_form.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Song Submission Form</title>
    <style>
        /* Google Fonts Import */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        :root {
            --primary-color: #4A90E2; /* A modern blue */
            --secondary-color: #50E3C2; /* A mint green accent */
            --text-color: #333;
            --light-bg: #F8F9FA; /* Lighter background */
            --card-bg: #FFFFFF;
            --border-color: #E0E0E0;
            --shadow-light: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-medium: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Align to top */
            min-height: 100vh;
        }

        .container {
            background-color: var(--card-bg);
            padding: 3.5rem; /* More padding */
            border-radius: 12px; /* Softer corners */
            box-shadow: var(--shadow-medium);
            margin-top: 3rem; /* Space from top */
            margin-bottom: 3rem; /* Space from bottom */
            border: 1px solid var(--border-color); /* Subtle border */
            max-width: 800px;
            width: 100%;
        }

        h1 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 2.5rem;
            font-size: 2.5rem; /* Larger heading */
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem; /* Consistent spacing between groups */
        }

        .form-label {
            display: block;
            font-weight: 600; /* Bolder labels */
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px; /* Consistent rounded corners */
            box-sizing: border-box; /* Include padding in width */
            font-size: 1rem;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        textarea:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 0.25rem rgba(74, 144, 226, 0.25); /* Primary color glow */
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        input[type="file"] {
            display: block;
            width: 100%;
            padding: 0.75rem 0; /* Adjust padding for file input */
            font-size: 1rem;
            color: var(--text-color);
        }

        input[type="file"]::-webkit-file-upload-button {
            background-color: var(--secondary-color);
            color: white;
            padding: 0.6rem 1rem;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-right: 15px; /* Space between button and file name */
        }

        input[type="file"]::file-selector-button {
            background-color: var(--secondary-color);
            color: white;
            padding: 0.6rem 1rem;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-right: 15px; /* Space between button and file name */
        }

        input[type="file"]::-webkit-file-upload-button:hover,
        input[type="file"]::file-selector-button:hover {
            background-color: #3FCBB1; /* Darker secondary on hover */
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            margin-right: 0.75rem;
            transform: scale(1.2); /* Slightly larger checkbox */
        }

        .checkbox-group label {
            margin-bottom: 0; /* Remove default label margin */
            font-weight: 400;
        }

        .btn-submit {
            display: block;
            width: 100%;
            padding: 1rem; /* Larger button */
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px; /* Consistent rounded corners */
            font-size: 1.25rem; /* Larger font */
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-submit:hover {
            background-color: #3A7BBF; /* Darker primary on hover */
            transform: translateY(-2px); /* Slight lift effect */
        }

        /* Alert styling */
        .alert {
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            border: 1px solid transparent;
            box-shadow: var(--shadow-light);
        }

        .alert-success {
            background-color: #e6ffed; /* Lighter green */
            color: #28a745; /* Green */
            border-color: #c3e6cb;
        }

        .alert-danger {
            background-color: #ffe6e6; /* Lighter red */
            color: #dc3545; /* Red */
            border-color: #f5c6cb;
        }

        .alert-warning {
            background-color: #fff3e0; /* Lighter orange */
            color: #ff9800; /* Orange */
            border-color: #ffe0b2;
        }

        .alert-heading {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block; /* Ensure it takes full width */
        }

        /* Grid for layout */
        .grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem; /* Gap between grid items */
            margin-bottom: 1.5rem;
        }

        @media (min-width: 768px) { /* Medium screens and up */
            .grid {
                grid-template-columns: repeat(2, 1fr); /* Two columns */
            }
        }

        /* Link style for Terms and Conditions */
        .terms-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .terms-link:hover {
            color: #3A7BBF; /* Darker primary on hover */
            text-decoration: underline;
        }

        /* Responsive adjustments for smaller screens */
        @media (max-width: 767px) {
            .container {
                padding: 1.5rem;
                margin-top: 1rem;
                margin-bottom: 1rem;
            }
            h1 {
                font-size: 2rem;
                margin-bottom: 2rem;
            }
            .btn-submit {
                font-size: 1rem;
                padding: 0.75rem;
            }
        }
    </style>
</head>
<body class="bg-light d-flex justify-content-center align-items-start min-vh-100 py-5">
    <div class="container">
        <h1>Submit Your Song</h1>

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Validation Error(s):</h4>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('submission.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid">
                <div class="form-group">
                    <label for="artist_name" class="form-label">Artist Name <span style="color: #dc3545;">*</span></label>
                    <input type="text" id="artist_name" name="artist_name" value="{{ old('artist_name') }}" class="form-control" required>
                    @error('artist_name')<p class="error-message">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label for="song_title" class="form-label">Song Title <span style="color: #dc3545;">*</span></label>
                    <input type="text" id="song_title" name="song_title" value="{{ old('song_title') }}" class="form-control" required>
                    @error('song_title')<p class="error-message">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label for="featured_artists" class="form-label">Featured Artist(s) (optional)</label>
                    <input type="text" id="featured_artists" name="featured_artists" value="{{ old('featured_artists') }}" class="form-control">
                    @error('featured_artists')<p class="error-message">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label for="genre" class="form-label">Genre <span style="color: #dc3545;">*</span></label>
                    <input type="text" id="genre" name="genre" value="{{ old('genre') }}" class="form-control" required>
                    @error('genre')<p class="error-message">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label for="language" class="form-label">Language <span style="color: #dc3545;">*</span></label>
                    <input type="text" id="language" name="language" value="{{ old('language') }}" class="form-control" required>
                    @error('language')<p class="error-message">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label for="composer_name" class="form-label">Composer Name <span style="color: #dc3545;">*</span></label>
                    <input type="text" id="composer_name" name="composer_name" value="{{ old('composer_name') }}" class="form-control" required>
                    @error('composer_name')<p class="error-message">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label for="writer_name" class="form-label">Writer Name <span style="color: #dc3545;">*</span></label>
                    <input type="text" id="writer_name" name="writer_name" value="{{ old('writer_name') }}" class="form-control" required>
                    @error('writer_name')<p class="error-message">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label for="release_date" class="form-label">Release Date (at least 7 days from now) <span style="color: #dc3545;">*</span></label>
                    <input type="date" id="release_date" name="release_date" value="{{ old('release_date') }}" class="form-control" required>
                    @error('release_date')<p class="error-message">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="alert alert-warning" role="alert">
                <h5 class="alert-heading">Artwork Guidelines Reminder:</h5>
                <p class="mb-0">Please ensure your artwork does not include logos, watermarks, or social media handles. This is a rule required by distributors.</p>
            </div>

            <div class="form-group">
                <label for="artwork_upload" class="form-label">Artwork Upload (PNG, JPG, PSD, etc.) <span style="color: #dc3545;">*</span></label>
                <input type="file" id="artwork_upload" name="artwork_upload" accept=".png,.jpg,.jpeg,.gif,.psd,.zip" class="form-control" required>
                @error('artwork_upload')<p class="error-message">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label for="music_file_upload" class="form-label">Music File Upload (MP3, WAV, ZIP, etc.) <span style="color: #dc3545;">*</span></label>
                <input type="file" id="music_file_upload" name="music_file_upload" accept=".mp3,.wav,.zip" class="form-control" required>
                @error('music_file_upload')<p class="error-message">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label for="social_media_links" class="form-label">Social Media Links (optional)</label>
                <textarea id="social_media_links" name="social_media_links" placeholder="e.g., https://instagram.com/artistname, https://twitter.com/artistname" class="form-control">{{ old('social_media_links') }}</textarea>
                @error('social_media_links')<p class="error-message">{{ $message }}</p>@enderror
            </div>

            <div class="grid">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address <span style="color: #dc3545;">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" required>
                    @error('email')<p class="error-message">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label for="phone_number" class="form-label">Phone Number (optional)</label>
                    <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" class="form-control">
                    @error('phone_number')<p class="error-message">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="agree_to_terms" name="agree_to_terms" value="1" {{ old('agree_to_terms') ? 'checked' : '' }} required>
                <label for="agree_to_terms">I agree to the <a href="#" class="terms-link">Terms and Conditions</a> <span style="color: #dc3545;">*</span></label>
            </div>
            @error('agree_to_terms')<p class="error-message">{{ $message }}</p>@enderror

            <button type="submit" class="btn-submit">Submit Song</button>
        </form>
    </div>

    {{-- No JavaScript required for this basic form if not using Bootstrap JS features --}}
</body>
</html>