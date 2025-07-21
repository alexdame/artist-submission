{{-- resources/views/admin/submissions/show.blade.php --}}

@extends('layouts.admin')

@section('title', 'Submission Details')

@section('content')
    <div class="content-card">
        <h1>Submission Details for "{{ $songSubmission->song_title }}"</h1>

        <div class="detail-item">
            <strong>ID:</strong> {{ $songSubmission->id }}
        </div>
        <div class="detail-item">
            <strong>Artist Name:</strong> {{ $songSubmission->artist_name }}
        </div>
        <div class="detail-item">
            <strong>Song Title:</strong> {{ $songSubmission->song_title }}
        </div>
        <div class="detail-item">
            <strong>Genre:</strong> {{ $songSubmission->genre }}
        </div>
        <div class="detail-item">
            <strong>Release Date:</strong> {{ $songSubmission->release_date->format('M d, Y') }}
        </div>
        <div class="detail-item">
            <strong>Email:</strong> {{ $songSubmission->email }}
        </div>
        <div class="detail-item">
            <strong>Status:</strong> <span class="status-badge status-{{ strtolower($songSubmission->status) }}">{{ $songSubmission->status }}</span>
        </div>
        <div class="detail-item">
            <strong>Streams:</strong> {{ $songSubmission->streams }} {{-- New: Display Stream Count --}}
        </div>
        <div class="detail-item">
            <strong>Internal Notes:</strong> {{ $songSubmission->internal_notes ?? 'N/A' }}
        </div>
        <div class="detail-item">
            <strong>Audio File:</strong>
            @if ($songSubmission->audio_path)
                <a href="{{ Storage::url($songSubmission->audio_path) }}" target="_blank" class="btn btn-primary">Listen/Download Audio</a>
            @else
                No audio file uploaded.
            @endif
        </div>
        <div class="detail-item">
            <strong>Submitted At:</strong> {{ $songSubmission->created_at->format('M d, Y H:i') }}
        </div>
        <div class="detail-item">
            <strong>Last Updated:</strong> {{ $songSubmission->updated_at->format('M d, Y H:i') }}
        </div>

        <div class="button-group">
            <a href="{{ route('admin.submissions.edit', $songSubmission->id) }}" class="btn btn-primary">Edit Submission</a>

            <form action="{{ route('admin.submissions.destroy', $songSubmission->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this submission? This action cannot be undone.');" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Submission</button>
            </form>

            <a href="{{ route('admin.submissions.index') }}" class="btn btn-secondary">Back to Submissions</a>
        </div>
    </div>

    @push('styles')
    <style>
        .detail-item {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f0f4f8; /* Light blue-gray for detail rows */
            border-left: 4px solid var(--primary-color);
            border-radius: 4px;
        }
        .detail-item strong {
            color: var(--primary-color);
            margin-right: 5px;
        }
    </style>
    @endpush
@endsection