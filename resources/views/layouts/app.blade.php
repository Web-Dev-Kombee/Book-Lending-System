<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Lending Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #2d3748;
            --light-bg: #f8f9fa;
            --border-color: #e2e8f0;
            --sidebar-width: 250px;
        }
        
        body {
            min-height: 100vh;
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .auth-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e7ec 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .auth-card {
            width: 100%;
            max-width: 450px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
        }
        
        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--secondary) 0%, #1a202c 100%);
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 100;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-brand {
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .sidebar a {
            color: #cbd5e0;
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            gap: 0.75rem;
        }
        
        .sidebar a:hover, .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.05);
            color: white;
            border-left-color: var(--primary);
        }
        
        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.08);
        }
        
        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .content-wrapper {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .full-width {
            margin-left: 0;
        }
        
        .top-navbar {
            background-color: white;
            border-bottom: 1px solid var(--border-color);
            padding: 0.75rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .nav-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .user-info {
            display: flex;
            flex-direction: column;
        }
        
        .user-name {
            font-weight: 600;
            color: var(--secondary);
        }
        
        .user-role {
            font-size: 0.75rem;
            color: #718096;
        }
        
        .main-content {
            flex: 1;
            padding: 1.5rem;
            background-color: var(--light-bg);
        }
        
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.04);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
            font-weight: 600;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .content-wrapper {
                margin-left: 0;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
        }
        </style>
</head>
<body>
    
    @if(request()->is('login') || request()->is('register'))
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <h1><i class="fas fa-book"></i> Library</h1>
                <p class="text-muted">Book Lending Administration</p>
            </div>
            @yield('content')
        </div>
    </div>
@else
<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <i class="fas fa-book-open"></i>
                <span>Library Admin</span>
            </a>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('users.index') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
                <span>Manage Users</span>
            </a>
            <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'active' : '' }}">
                <i class="fas fa-book"></i>
                <span>Books</span>
            </a>
            <a href="{{ route('lendings.index') }}" class="{{ request()->routeIs('lendings.*') ? 'active' : '' }}">
                <i class="fas fa-handshake"></i>
                <span>Lending</span>
            </a>
            {{-- <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a> --}}
            <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
                <i class="fas fa-user-tag"></i>
                <span>Roles</span>
            </a>
            <a href="{{ route('user-role.index') }}" class="{{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                <i class="fas fa-key"></i>
                <span>Permissions</span>
            </a>
            <a href="{{ route('lendings.mine') }}" class="{{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                <i class="fas fa-book-reader"></i>
                <span>My Borrowed Books</span>
            </a>
        </div>
        
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="GET">
                @csrf
                <button class="btn btn-sm btn-outline-light w-100">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </button>
            </form>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="content-wrapper">
        <nav class="top-navbar">
            <button class="btn btn-sm d-lg-none" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="nav-user">
                @auth
                <div class="user-avatar">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">{{ Auth::user()->getRoleNames()->implode(', ') }}</span>
                </div>
                @else
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Login</a>
                @endauth
            </div>
        </nav>
        
        <main class="main-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>
    </div>
    @endif
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                const sidebar = document.querySelector('.sidebar');
                sidebar.classList.toggle('show');
            });
        }
    });
</script>
    @stack('scripts')
</body>
</html>