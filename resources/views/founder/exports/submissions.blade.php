<table>
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Genre</th>
            <th>Track Link</th>
            <th>Submitted At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($submissions as $submission)
            <tr>
                <td>{{ $submission->full_name }}</td>
                <td>{{ $submission->email }}</td>
                <td>{{ $submission->phone }}</td>
                <td>{{ $submission->genre }}</td>
                <td>{{ $submission->track_link }}</td>
                <td>{{ $submission->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
