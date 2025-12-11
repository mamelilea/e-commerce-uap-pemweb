<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Admin Panel</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #fce4ec 0%, #fff0f5 100%);
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #ff6b9d 0%, #ff8fb3 100%);
            padding: 20px;
            box-shadow: 4px 0 15px rgba(255, 107, 157, 0.3);
            overflow-y: auto;
        }

        .sidebar-header {
            color: white;
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 30px;
        }

        .sidebar-header h2 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }

        .nav-link.active {
            background: white;
            color: #ff6b9d;
            font-weight: 600;
        }

        .nav-icon {
            margin-right: 12px;
            font-size: 18px;
        }

        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
        }

        .top-bar {
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar h1 {
            color: #ff6b9d;
            font-size: 28px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b9d, #ff8fb3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
        }

        .logout-btn {
            background: #ff6b9d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #ff5089;
            transform: translateY(-2px);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }

            .sidebar-header h2,
            .sidebar-header p,
            .nav-text {
                display: none;
            }

            .main-content {
                margin-left: 70px;
            }

            .nav-link {
                justify-content: center;
            }

            .nav-icon {
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>🛍️ Admin Panel</h2>
            <p>E-Commerce Manager</p>
        </div>
        
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" 
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">📊</span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.store.verification') }}" 
                   class="nav-link {{ request()->routeIs('admin.store.verification') ? 'active' : '' }}">
                    <span class="nav-icon">✅</span>
                    <span class="nav-text">Verifikasi Toko</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users') }}" 
                   class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <span class="nav-icon">👥</span>
                    <span class="nav-text">Manajemen User</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.stores') }}" 
                   class="nav-link {{ request()->routeIs('admin.stores') ? 'active' : '' }}">
                    <span class="nav-icon">🏪</span>
                    <span class="nav-text">Manajemen Toko</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <h1>@yield('page-title')</h1>
            <div class="user-info">
                <div class="user-avatar">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <div style="font-weight: 600; color: #333;">{{ auth()->user()->name }}</div>
                    <div style="font-size: 12px; color: #666;">Administrator</div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                ✗ {{ session('error') }}
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </main>
</body>
</html>