<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>App Rekapitulasi Keterlambatan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar" class="js-sidebar">
            <!-- Content For Sidebar -->
            <div class="h-100">
                <div class="sidebar-logo">
                    <a href="#">Rekam Keterlambatan</a>
                </div>
                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Admin Elements
                    </li>
                    @if (Auth::check() && Auth::user()->role == "admin")
                    <li class="sidebar-item">
                        <a href="{{ route('dashboard') }}" class="sidebar-link">
                            <i class="fa-solid fa-list pe-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-target="#pages"
                            data-bs-toggle="collapse" aria-expanded="false"><i class="fa-solid fa-file-lines pe-2"></i>
                            Data Master
                        </a>
                        <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="{{ route('rombels.index') }}" class="sidebar-link">Data Rombel</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('rayons.index') }}" class="sidebar-link">Data Rayon</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('students.index') }}" class="sidebar-link">Data Siswa</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('users.index') }}" class="sidebar-link">Data User</a>
                            </li>
                        </ul>
                        <li class="sidebar-item">
                            <a href="{{ route('lates.index') }}" class="sidebar-link"><i class="fa-solid fa-file-lines pe-2"></i>Data
                                Keterlambatan</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('logout') }}" class="sidebar-link"></i>Logout</a>
                        </li>

                        @endif
                        @if (Auth::check() && Auth::user()->role == "ps")
                        <li class="sidebar-item">
                            <a href="{{ route('dashboardPs') }}" class="sidebar-link">
                                <i class="fa-solid fa-list pe-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('students-ps.index') }}" class="sidebar-link"><i class="fa-solid fa-file-lines pe-2"></i>Data
                                Siswa</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('lates-ps.index') }}" class="sidebar-link"><i class="fa-solid fa-file-lines pe-2"></i>Data
                                Keterlambatan</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('logout') }}" class="sidebar-link"></i>Logout</a>
                        </li>
                        @endif
                    </li>
                </ul>
            </div>
        </aside>
        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" id="sidebar-toggle" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="{{ asset('img/logo.jpg') }}" class="avatar img-fluid" alt="">
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    </div>

                        @yield('content')
    
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                    <script src="{{ asset('js/script.js') }}"></script>
                    @stack('script')
</body>

</html>
