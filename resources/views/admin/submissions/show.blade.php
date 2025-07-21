{{-- resources/views/admin/submissions/show.blade.php --}}

@extends('layouts.admin')

@section('title', 'Submission Details')

@section('content')
    <div class="content-card">
        <h1>Submission Details for "{{ $songSubmission->song_title }}"</h1>

        {{-- Session Messages (for success/error from other actions) --}}
        @if (session('success'))
            <div style="background-color: #e6ffed; color: #28a745; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #c3e6cb; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div style="background-color: #ffe6e6; color: #dc3545; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #f5c6cb; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);">
                {{ session('error') }}
            </div>
        @endif

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
            <strong>Streams:</strong> {{ $songSubmission->streams }}
        </div>
        <div class="detail-item">
            <strong>Hypothetical Royalty:</strong> ${{ number_format($hypotheticalRoyalty, 4) }}
            <span style="font-size: 0.8em; color: #666;">(based on ${{ number_format($royaltyRatePerStream, 4) }} per stream)</span>
        </div>
        <div class="detail-item">
            <strong>Internal Notes:</strong> {{ $songSubmission->internal_notes ?? 'N/A' }}
        </div>
        <div class="detail-item">
            <strong>Audio File:</strong>
            @if ($songSubmission->audio_path)
                <a href="{{ Storage::url($songSubmission->audio_path) }}" target="_blank" class="btn btn-primary">Listen/Download Audio</a>
                <audio controls style="width: 100%; max-width: 300px; margin-top: 10px;">
                    <source src="{{ Storage::url($songSubmission->audio_path) }}" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
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

        <div class="button-group" style="margin-top: 30px; display: flex; gap: 10px; flex-wrap: wrap;">
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
        /* Styles for status badges, copied from index.blade.php or admin layout if not there */
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: capitalize;
        }
        .status-pending { background-color: #fff3e0; color: #ff9800; } /* orange */
        .status-approved { background-color: #e6ffed; color: #28a745; } /* green */
        .status-rejected { background-color: #ffe6e6; color: #dc3545; } /* red */
    </style>
    @endpush
@endsection