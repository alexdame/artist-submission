{{-- resources/views/artist/dashboard.blade.php --}}

@extends('layouts.app') {{-- This uses Laravel Breeze's default app layout --}}

@section('title', 'My Artist Dashboard')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                        {{ __('My Song Submissions') }}
                    </h2>

                    {{-- Session Messages --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @forelse ($submissions as $submission)
                        <div class="mb-6 p-4 border border-gray-200 rounded-lg shadow-sm">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold text-primary-color">{{ $submission->song_title }}</h3>
                                <span class="status-badge status-{{ strtolower($submission->status) }}">
                                    {{ $submission->status }}
                                </span>
                            </div>
                            <p class="text-gray-700 mb-1"><strong>Artist:</strong> {{ $submission->artist_name }}</p>
                            <p class="text-gray-700 mb-1"><strong>Genre:</strong> {{ $submission->genre }}</p>
                            <p class="text-gray-700 mb-1"><strong>Release Date:</strong> {{ $submission->release_date->format('M d, Y') }}</p>
                            <p class="text-gray-700 mb-1"><strong>Submitted On:</strong> {{ $submission->created_at->format('M d, Y H:i') }}</p>

                            @if ($submission->status === 'approved')
                                <p class="text-gray-700 mb-1">
                                    <strong>Streams:</strong> {{ $submission->streams }}
                                </p>
                                @php
                                    $hypotheticalRoyalty = $submission->streams * $royaltyRatePerStream;
                                @endphp
                                <p class="text-gray-700 mb-3">
                                    <strong>Hypothetical Royalty:</strong> ${{ number_format($hypotheticalRoyalty, 4) }}
                                    <span class="text-sm text-gray-500">(at ${{ number_format($royaltyRatePerStream, 4) }} per stream)</span>
                                </p>
                                @if ($submission->audio_path && Storage::disk('public')->exists($submission->audio_path))
                                    <audio controls class="w-full max-w-sm">
                                        <source src="{{ Storage::url($submission->audio_path) }}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                @endif
                            @elseif ($submission->status === 'rejected' && $submission->internal_notes)
                                <p class="text-gray-700 mt-2 p-2 bg-red-50 border border-red-200 rounded">
                                    <strong>Notes from Reviewer:</strong> {{ $submission->internal_notes }}
                                </p>
                            @endif

                            {{-- You could add an edit button here if you want artists to edit pending submissions --}}
                            {{-- <a href="#" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mt-4">Edit</a> --}}
                        </div>
                    @empty
                        <p class="text-center text-gray-600 p-8 border border-dashed border-gray-300 rounded-lg">
                            You haven't submitted any songs yet. <a href="{{ route('submission.create') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Submit your first song now!</a>
                        </p>
                    @endforelse

                    <div class="mt-6">
                        {{ $submissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        /* Re-using status badge styles from admin layout, or define here */
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
        .text-primary-color {
            color: #4A90E2; /* Or use Tailwind's `text-blue-600` if configured */
        }
    </style>
    @endpush
@endsection