{{-- resources/views/admin/dashboard.blade.php --}}

@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="content-card">
        <h1>Welcome to the Admin Dashboard!</h1>
        <p>This is your central hub for managing the Artistt platform.</p>

        <div style="margin-top: 30px; display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
            <div style="background-color: #e3f2fd; border-left: 5px solid #2196f3; padding: 20px; border-radius: 8px; box-shadow: var(--shadow-light); flex: 1; min-width: 250px; text-align: center;">
                <i class="fas fa-music fa-3x" style="color: #2196f3; margin-bottom: 10px;"></i>
                <h3 style="margin-top: 0;">Manage Submissions</h3>
                <p>View, edit, and delete song submissions.</p>
                <a href="{{ route('admin.submissions.index') }}" class="btn btn-primary" style="margin-top: 15px;">Go to Submissions</a>
            </div>

            {{-- You can add more dashboard widgets here later --}}
            <div style="background-color: #e8f5e9; border-left: 5px solid #4caf50; padding: 20px; border-radius: 8px; box-shadow: var(--shadow-light); flex: 1; min-width: 250px; text-align: center;">
                <i class="fas fa-users-cog fa-3x" style="color: #4caf50; margin-bottom: 10px;"></i>
                <h3 style="margin-top: 0;">User Management</h3>
                <p>Manage users and their roles (future feature).</p>
                <a href="#" class="btn btn-secondary" style="margin-top: 15px; opacity: 0.7;">Coming Soon</a>
            </div>
        </div>
    </div>
@endsection