<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body {
            background: #f4f6fb;
            font-family: 'Segoe UI', sans-serif;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #111827;
            color: white;
            padding: 25px 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar-title {
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }

        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 10px 15px;
            border-radius: 10px;
            transition: .2s;
            font-size: 14px;
        }

        .sidebar .nav-link:hover {
            background: #1f2937;
            color: white;
        }

        .sidebar .nav-link.active {
            background: #2563eb;
            color: white;
        }

        /* CONTENT */
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* TOPBAR */
        .topbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-title {
            font-weight: 600;
            font-size: 16px;
        }

        .user-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn-logout {
            border-radius: 10px;
            padding: 6px 14px;
            font-size: 13px;
            transition: .2s;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
        }

        .content {
            padding: 30px;
            flex-grow: 1;
        }

        @media (max-width: 992px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main-wrapper {
                margin-left: 0;
            }
        }

    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <div class="sidebar-title">SkodePresent</div>

        <ul class="nav flex-column gap-2">

            <li>
                <a href="{{ route('admin.home') }}"
                   class="nav-link {{ request()->routeIs('admin.home') ? 'active' : '' }}">
                    🏠 Home
                </a>
            </li>

            <li>
                <a href="{{ route('admin.users.index') }}"
                   class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    👤 Users
                </a>
            </li>

            <li>
                <a href="{{ route('admin.perizinan.index') }}"
                   class="nav-link {{ request()->routeIs('admin.perizinan.*') ? 'active' : '' }}">
                    📄 Perizinan
                </a>
            </li>

            <li>
                <a href="{{ route('admin.laporan.index') }}"
                   class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                    📊 Laporan
                </a>
            </li>

            <li>
                <a href="{{ route('admin.settings.index') }}"
                   class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    ⚙ Settings
                </a>
            </li>

        </ul>
    </div>

    {{-- MAIN WRAPPER --}}
    <div class="main-wrapper">

        {{-- TOPBAR --}}
        <div class="topbar">
            <div class="topbar-title">
                Admin Dashboard
            </div>

            <div class="user-area">

                <span class="text-muted small">
                    {{ auth()->user()->name ?? 'Admin' }}
                </span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            onclick="return confirm('Yakin mau logout?')"
                            class="btn btn-sm btn-danger btn-logout">
                        Logout
                    </button>
                </form>

            </div>
        </div>

        {{-- CONTENT --}}
        <div class="content">
            @yield('content')
        </div>

    </div>

</body>
</html>