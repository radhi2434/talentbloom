<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Student') - TalentBloom</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f6fa;
        }

        /* 💙 LIGHT NAVY PREMIUM */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #3a5a80;
            display: flex;
            flex-direction: column;
            transition: 0.3s;
        }

        .sidebar .nav-link {
            padding: 10px;
            border-radius: 6px;
            color: white;
        }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.2);
        }

        .menu-toggle {
            background: #3a5a80;
            border: none;
            color: #fff;
            width: 40px;
            height: 40px;
            border-radius: 8px;

            display: flex;
            align-items: center;
            justify-content: center;

            transition: 0.2s;
        }

        .menu-toggle:hover {
            background: #2f4c6e;
        }

        .menu-toggle i {
            font-size: 18px;
        }
        .nav-link.active {
            background: rgba(255,255,255,0.25);
            font-weight: 600;
        }

        .sidebar.hide {
            margin-left: -250px;
        }

        .content-area {
            width: 100%;
        }

        .user-btn {
            background: transparent;
            border: none;
            font-weight: 500;
        }

        .custom-dropdown {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: none;
        }
    </style>
</head>

<body>

<div class="d-flex">

    {{-- SIDEBAR --}}
    @include('student.layouts.navbar')

    {{-- MAIN --}}
    <div class="content-area">

        <!-- TOP BAR -->
        <div class="d-flex justify-content-between align-items-center px-4 py-2 bg-white shadow-sm">

            <div class="d-flex align-items-center gap-2">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
            </div>

            <!-- USER -->
            <div class="dropdown">
                <button class="user-btn" data-bs-toggle="dropdown">
                    {{ auth()->user()->name }}
                </button>

                <ul class="dropdown-menu dropdown-menu-end custom-dropdown">
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('student.profile') }}">
                            <i class="bi bi-person"></i>
                            My Profile
                        </a>
                    </li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                <i class="bi bi-box-arrow-right"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>

        <!-- CONTENT -->
        <div class="p-4">
            @yield('content')
        </div>

        <footer class="text-center text-muted py-3 border-top">
            <small>© 2026 TalentBloom</small>
        </footer>

    </div>

</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('hide');
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>