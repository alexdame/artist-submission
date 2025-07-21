{{-- resources/views/admin/submissions/edit.blade.php --}}

@extends('layouts.admin')

@section('title', 'Edit Submission')

@section('content')
    <div class="content-card">
        <h1>Edit Submission for "{{ $songSubmission->song_title }}"</h1>

        {{-- Session Messages (removed from here as they are now in the layout) --}}
        {{-- Error messages are still handled by @error directive per field --}}

        <form action="{{ route('admin.submissions.update', $songSubmission->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="artist_name" class="form-label">Artist Name:</label>
                <input type="text" id="artist_name" name="artist_name" value="{{ old('artist_name', $songSubmission->artist_name) }}" class="form-control" readonly>
                <small style="color: #666; font-size: 0.9em;">(Cannot be edited directly via admin panel)</small>
            </div>

            <div class="form-group">
                <label for="song_title" class="form-label">Song Title:</label>
                <input type="text" id="song_title" name="song_title" value="{{ old('song_title', $songSubmission->song_title) }}" class="form-control" readonly>
                <small style="color: #666; font-size: 0.9em;">(Cannot be edited directly via admin panel)</small>
            </div>

            <div class="form-group">
                <label for="status" class="form-label">Status <span style="color: #dc3545;">*</span></label>
                <select id="status" name="status" class="form-control" required>
                    <option value="pending" {{ old('status', $songSubmission->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ old('status', $songSubmission->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ old('status', $songSubmission->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                @error('status')<p class="error-message">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label for="internal_notes" class="form-label">Internal Notes</label>
                <textarea id="internal_notes" name="internal_notes" class="form-control">{{ old('internal_notes', $songSubmission->internal_notes) }}</textarea>
                @error('internal_notes')<p class="error-message">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-submit">Update Submission</button>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('admin.submissions.show', $songSubmission->id) }}" class="btn-secondary">Cancel and Back to Details</a>
        </div>
    </div>

    {{-- Basic form group styles repeated here for clarity, will eventually be global --}}
    @push('styles')
    <style>
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; font-weight: 600; color: var(--text-color); margin-bottom: 0.5rem; }
        input[type="text"], select, textarea {
            width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-color);
            border-radius: 8px; box-sizing: border-box; font-size: 1rem;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05); transition: all 0.3s ease;
        }
        input[type="text"]:focus, select:focus, textarea:focus {
            border-color: var(--primary-color); outline: none; box-shadow: 0 0 0 0.25rem rgba(74, 144, 226, 0.25);
        }
        textarea { resize: vertical; min-height: 120px; }
        .btn-submit {
            display: block; width: 100%; padding: 1rem; background-color: var(--primary-color);
            color: white; border: none; border-radius: 8px; font-size: 1.25rem; font-weight: 600;
            cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease; margin-top: 2rem;
        }
        .btn-submit:hover { background-color: #3A7BBF; transform: translateY(-2px); }
        .error-message { color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem; display: block; }
    </style>
    @endpush
@endsection