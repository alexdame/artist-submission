{{-- resources/views/admin/submissions/index.blade.php --}}

@extends('layouts.admin') {{-- This line tells it to use the admin layout --}}

@section('title', 'Submissions List') {{-- This sets the page title --}}

@section('content') {{-- This section's content will be placed in @yield('content') in the layout --}}
    <div class="content-card"> {{-- Wrapping existing content in a content-card for consistent styling --}}
        <h1>All Song Submissions</h1>

        {{-- Existing Search and Filter Form --}}
        <form action="{{ route('admin.submissions.index') }}" method="GET" style="margin-bottom: 25px; display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end;">
            <div style="flex: 1; min-width: 200px;">
                <label for="search" style="display: block; margin-bottom: 5px; font-weight: 600;">Search (Artist, Title, Email):</label>
                <input type="text" name="search" id="search" value="{{ $search }}" placeholder="Search submissions..." style="width: 100%; padding: 8px; border: 1px solid var(--border-color); border-radius: 6px;">
            </div>

            <div style="flex: 0 0 auto;">
                <label for="status_filter" style="display: block; margin-bottom: 5px; font-weight: 600;">Filter by Status:</label>
                <select name="status_filter" id="status_filter" style="padding: 8px; border: 1px solid var(--border-color); border-radius: 6px;">
                    <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>All Statuses</option>
                    <option value="pending" {{ $statusFilter == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $statusFilter == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ $statusFilter == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <button type="submit" style="padding: 8px 15px; background-color: var(--primary-color); color: white; border: none; border-radius: 6px; cursor: pointer; transition: background-color 0.2s ease;">Apply Filters</button>
            <a href="{{ route('admin.submissions.index') }}" style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 6px; text-decoration: none; transition: background-color 0.2s ease;">Reset</a>
        </form>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Artist Name</th>
                        <th>Song Title</th>
                        <th>Genre</th>
                        <th>Release Date</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Submitted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($submissions as $submission)
                        <tr>
                            <td>{{ $submission->id }}</td>
                            <td>{{ $submission->artist_name }}</td>
                            <td>{{ $submission->song_title }}</td>
                            <td>{{ $submission->genre }}</td>
                            <td>{{ $submission->release_date->format('M d, Y') }}</td>
                            <td>{{ $submission->email }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($submission->status) }}">
                                    {{ $submission->status }}
                                </span>
                            </td>
                            <td>{{ $submission->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.submissions.show', $submission->id) }}" class="btn btn-primary">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="no-submissions">No song submissions found yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Existing Pagination Links --}}
        <div style="margin-top: 25px; display: flex; justify-content: center;">
            {{ $submissions->links() }}
        </div>
    </div>
@endsection