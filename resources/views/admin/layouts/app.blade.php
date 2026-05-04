<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Admin') - TalentBloom</title>

        {{-- Bootstrap CDN --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

        <style>
            body {
                background-color: #f5f6fa;
            }

            /* SIDEBAR */
            .sidebar {
                width: 250px;
                min-height: 100vh;
                background: #212529; /* ADMIN BLACK */
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

            /* TOGGLE */
            .sidebar.hide {
                margin-left: -250px;
            }

            /* CONTENT AREA */
            .content-area {
                width: 100%;
            }

            .user-btn {
                background: transparent;
                border: none;
                font-weight: 500;
                color: #333;
            }

            .user-btn:hover {
                color: #000;
            }

            .custom-dropdown {
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                border: none;
            }

            .nav-link.active {
                background: rgba(255,255,255,0.25);
                font-weight: 600;
            }

            .dropdown-item {
                padding: 10px 15px;
            }
        </style>
    </head>

    <body>
        <div class="d-flex">
            {{-- ✅ SIDEBAR --}}
            @include('admin.layouts.navbar')

            {{-- ✅ MAIN CONTENT --}}
            <div class="content-area">

                <!-- 🔝 TOP BAR -->
                <div class="d-flex justify-content-between align-items-center px-4 py-2 bg-white shadow-sm">

                    <!-- LEFT -->
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-dark btn-sm" onclick="toggleSidebar()">☰</button>
                    </div>

                    <!-- RIGHT -->
                    <div class="dropdown me-3">
                        <button class="user-btn" type="button" data-bs-toggle="dropdown">
                            {{ auth()->user()->name ?? 'Admin' }}
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end custom-dropdown">

                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.profile.edit') }}">
                                    <i class="bi bi-person"></i>
                                    My Profile
                                </a>
                            </li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item d-flex align-items-center gap-2 text-danger" type="submit">
                                        <i class="bi bi-box-arrow-right"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>

                        </ul>
                    </div>
                </div>

                <!-- 📦 PAGE CONTENT -->
                <div class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <strong>Please fix the errors:</strong>
                            <ul class="mb-0">
                                @foreach($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </div>

                <!-- 🔻 FOOTER -->
                <footer class="text-center text-muted py-3 border-top">
                    <small>© 2026 TalentBloom</small>
                </footer>
            </div>
        </div>

        <script>
        const sidebar = document.getElementById('sidebar');

        // load state
        if (localStorage.getItem('sidebar') === 'open') {
            sidebar.classList.remove('hide');
        }

        // toggle
        function toggleSidebar() {
            sidebar.classList.toggle('hide');

            if (sidebar.classList.contains('hide')) {
                localStorage.setItem('sidebar', 'closed');
            } else {
                localStorage.setItem('sidebar', 'open');
            }
        }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>