@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Founder Dashboard</h2>

    <form method="GET" class="mb-4 row g-2">
        <div class="col-md-3"><input type="text" name="artist_name" class="form-control" placeholder="Artist Name" value="{{ request('artist_name') }}"></div>
        <div class="col-md-3"><input type="text" name="title" class="form-control" placeholder="Song Title" value="{{ request('title') }}"></div>
        <div class="col-md-2"><input type="text" name="genre" class="form-control" placeholder="Genre" value="{{ request('genre') }}"></div>
        <div class="col-md-2"><input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}"></div>
        <div class="col-md-2"><input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}"></div>
        <div class="col-md-12 mt-2">
            <button class="btn btn-primary">Filter</button>
            <a href="{{ route('founder.dashboard') }}" class="btn btn-secondary">Reset</a>
            <a href="{{ route('founder.export.csv', request()->query()) }}" class="btn btn-success">Export CSV</a>
            <a href="{{ route('founder.export.excel', request()->query()) }}" class="btn btn-warning">Export Excel</a>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Artist</th>
                <th>Title</th>
                <th>Genre</th>
                <th>Composer</th>
                <th>Writer</th>
                <th>Release Date</th>
                <th>Email</th>
                <th>Artwork</th>
                <th>Music</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($submissions as $sub)
            <tr>
                <td>{{ $sub->artist_name }}</td>
                <td>{{ $sub->song_title }}</td>
                <td>{{ $sub->genre }}</td>
                <td>{{ $sub->composer_name }}</td>
                <td>{{ $sub->writer_name }}</td>
                <td>{{ $sub->release_date }}</td>
                <td>{{ $sub->email }}</td>
                <td><a href="{{ route('founder.download.artwork', $sub->id) }}" class="btn btn-sm btn-info">Download</a></td>
                <td><a href="{{ route('founder.download.music', $sub->id) }}" class="btn btn-sm btn-dark">Download</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <form method="GET" action="{{ route('founder.export.csv') }}" style="display:inline;">
    <button class="btn btn-sm btn-primary">Export CSV</button>
</form>

<form method="GET" action="{{ route('founder.export.xlsx') }}" style="display:inline;">
    <button class="btn btn-sm btn-success">Export Excel</button>
</form>

    {{ $submissions->links() }}
</div>
@endsection
