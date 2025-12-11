<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Seller Dashboard</title>
    
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

        .navbar {
            background: linear-gradient(135deg, #ff6b9d 0%, #ff8fb3 100%);
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(255, 107, 157, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            color: white;
            font-size: 24px;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-menu {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .nav-link.active {
            background: white;
            color: #ff6b9d;
            font-weight: 600;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ff6b9d;
            font-weight: 600;
            font-size: 16px;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: white;
            color: #ff6b9d;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .navbar-menu {
                flex-wrap: wrap;
                justify-content: center;
            }

            .container {
                padding: 0 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="{{ route('store.dashboard') }}" class="navbar-brand">
            <span>🛍️</span>
            <span>Seller Dashboard</span>
        </a>
        
        @if(auth()->user()->store && auth()->user()->store->is_verified)
        <div class="navbar-menu">
            <a href="{{ route('store.dashboard') }}" 
               class="nav-link {{ request()->routeIs('store.dashboard') ? 'active' : '' }}">
                📊 Dashboard
            </a>
            <a href="{{ route('store.edit') }}" 
               class="nav-link {{ request()->routeIs('store.edit') ? 'active' : '' }}">
                ⚙️ Pengaturan Toko
            </a>
        </div>
        @endif

        <div class="user-menu">
            <div class="user-avatar">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div style="color: white;">
                <div style="font-weight: 600; font-size: 14px;">{{ auth()->user()->name }}</div>
                <div style="font-size: 12px; opacity: 0.9;">Seller</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
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

        @if(session('info'))
            <div class="alert alert-info">
                ℹ {{ session('info') }}
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </div>
</body>
</html>