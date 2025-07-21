{{-- resources/views/layouts/admin.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - @yield('title', 'Artistt Submissions')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Google Fonts Import */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        :root {
            --primary-color: #4A90E2; /* A modern blue */
            --primary-dark: #3A7BBF;
            --secondary-color: #50E3C2; /* A mint green accent */
            --text-color: #333;
            --light-bg: #F8F9FA;
            --card-bg: #FFFFFF;
            --border-color: #E0E0E0;
            --shadow-light: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-medium: 0 8px 20px rgba(0, 0, 0, 0.12);
            --sidebar-width: 250px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
            line-height: 1.6;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        /* --- Header/Navbar --- */
        .header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-light);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .header .logo {
            font-size: 1.8rem;
            font-weight: 700;
            text-decoration: none;
            color: white;
        }
        .header .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        .header .nav-links a:hover {
            color: var(--secondary-color);
        }
        .header .logout-form {
            display: inline; /* To align button with links */
        }
        .header .logout-form button {
            background: none;
            border: none;
            color: white;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            padding: 0;
            margin-left: 20px;
            transition: color 0.2s ease;
        }
        .header .logout-form button:hover {
            color: var(--secondary-color);
        }

        /* --- Sidebar --- */
        .sidebar {
            width: var(--sidebar-width);
            background-color: #2c3e50; /* Darker tone for sidebar */
            color: white;
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh; /* Make sidebar fill height */
            z-index: 999;
        }
        .sidebar .sidebar-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        .sidebar .sidebar-header h2 {
            margin: 0;
            font-size: 1.5rem;
            color: var(--secondary-color);
        }
        .sidebar-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-nav ul li a {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: white;
            text-decoration: none;
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .sidebar-nav ul li a:hover,
        .sidebar-nav ul li a.active {
            background-color: var(--primary-dark);
            color: var(--secondary-color);
        }
        .sidebar-nav ul li a i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* --- Main Content Area --- */
        .main-content {
            flex-grow: 1; /* Allows content to take up remaining space */
            padding: 2.5rem;
            box-sizing: border-box; /* Include padding in element's total width and height */
        }
        .content-card {
            background-color: var(--card-bg);
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: var(--shadow-medium);
            border: 1px solid var(--border-color);
            margin-bottom: 20px; /* Space between cards if multiple on a page */
        }

        /* --- General Utilities & Overrides for existing elements --- */
        h1 {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 2rem;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            text-align: center;
        }
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: 1px solid var(--primary-color);
        }
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: 1px solid #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: 1px solid #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #c82333;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: capitalize;
        }
        .status-pending { background-color: #fff3e0; color: #ff9800; }
        .status-approved { background-color: #e6ffed; color: #28a745; }
        .status-rejected { background-color: #ffe6e6; color: #dc3545; }

        .button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px; /* Space between buttons */
            justify-content: center;
            margin-top: 2rem;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .sidebar {
                width: 80px; /* Collapse sidebar */
                align-items: center;
                padding: 20px 0;
            }
            .sidebar .sidebar-header h2 {
                display: none; /* Hide text logo */
            }
            .sidebar-nav ul li a {
                justify-content: center; /* Center icons */
                padding: 15px 0;
                width: 100%;
            }
            .sidebar-nav ul li a span {
                display: none; /* Hide link text */
            }
            .sidebar-nav ul li a i {
                margin-right: 0; /* No margin if text is hidden */
            }
            .main-content {
                padding: 1.5rem;
            }
            .header {
                padding: 1rem 1.5rem;
            }
            .header .nav-links a,
            .header .logout-form button {
                margin-left: 10px;
            }
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column; /* Stack header and sidebar on small screens */
            }
            .header {
                position: static; /* No longer sticky */
            }
            .sidebar {
                width: 100%; /* Full width sidebar */
                height: auto; /* Auto height */
                position: static;
                flex-direction: row; /* Layout items horizontally */
                justify-content: center;
                padding: 10px 0;
            }
            .sidebar .sidebar-header {
                display: none;
            }
            .sidebar-nav ul {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }
            .sidebar-nav ul li {
                flex: 1 1 auto; /* Allow items to grow/shrink */
                text-align: center;
            }
            .sidebar-nav ul li a {
                padding: 10px 15px; /* Adjust padding */
            }
            .sidebar-nav ul li a span {
                display: inline; /* Show text for horizontal menu */
                margin-left: 5px;
            }
            .sidebar-nav ul li a i {
                margin-right: 5px;
            }
            .main-content {
                padding: 1rem;
            }
        }
    </style>
    @stack('styles') {{-- For page-specific styles --}}
</head>
<body>
    <header class="header">
        <a href="{{ route('admin.dashboard') }}" class="logo">Admin Panel</a>
        <nav class="nav-links">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="{{ route('admin.submissions.index') }}"><i class="fas fa-music"></i> Submissions</a>
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </nav>
    </header>

    <div style="display: flex; flex: 1;">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Hub</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
                    <li><a href="{{ route('admin.submissions.index') }}" class="{{ request()->routeIs('admin.submissions.*') ? 'active' : '' }}"><i class="fas fa-music"></i> <span>Submissions</span></a></li>
                    {{-- Add more admin links here as you expand --}}
                    {{-- <li><a href="#"><i class="fas fa-users"></i> <span>Users</span></a></li> --}}
                    {{-- <li><a href="#"><i class="fas fa-cog"></i> <span>Settings</span></a></li> --}}
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            {{-- Session Messages --}}
            @if (session('success'))
                <div style="background-color: #e6ffed; color: #28a745; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #c3e6cb; box-shadow: var(--shadow-light);">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div style="background-color: #ffe6e6; color: #dc3545; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #f5c6cb; box-shadow: var(--shadow-light);">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts') {{-- For page-specific scripts --}}
</body>
</html>