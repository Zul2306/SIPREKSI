<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPrekSi</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/iconly/bold.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css')}}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/icon_aplikasi.png')}}" type="image/png">
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex justify-content-center w-100">
                            <img src="{{ asset('assets/images/logo/logo_aplikasi.png') }}" alt="Logo" style="width: 125px; height: auto; " />
                        </div>
                        
                        <div class="toggler">
                            <a href="" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
               <div class="sidebar-menu">
<!-- Sidebar -->
<ul class="menu">
    @if(Auth::guard('admin')->check())
        {{-- Dashboard --}}
        <li class="sidebar-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                <i class="bi bi-bar-chart"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- Data Admin --}}
       @if(in_array($admin->id, [2])) {{-- ganti dengan ID yang diizinkan --}}
    <li class="sidebar-item {{ Request::is('admin/data') ? 'active' : '' }}">
        <a href="{{ route('admin.index') }}" class="sidebar-link">
            <i class="bi bi-person-badge"></i>
            <span>Data Admin</span>
        </a>
    </li>
    @endif

        {{-- Siswa --}}
        <li class="sidebar-item has-sub {{ Request::is('users/kelas*') ? 'active' : '' }}">
            <a href="#" class="sidebar-link">
                <i class="bi bi-stack"></i>
                <span>Siswa</span>
            </a>
            <ul class="submenu {{ Request::is('users/kelas*') ? 'd-block' : '' }}">
                <li class="submenu-item {{ Request::is('users/kelas/1') ? 'active' : '' }}">
                    <a href="{{ url('/users/kelas/1') }}">XI (1)</a>
                </li>
                <li class="submenu-item {{ Request::is('users/kelas/2') ? 'active' : '' }}">
                    <a href="{{ url('/users/kelas/2') }}">XI (2)</a>
                </li>
                <!-- Tambah kelas lainnya di sini -->
            </ul>
        </li>

        {{-- Logout --}}
        <li class="sidebar-item">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link btn btn-link text-start p-0 ps-3">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </li>
    @endif
</ul>



    <button class="sidebar-toggler btn x">
        <i data-feather="x"></i>
    </button>
</div>

        </div>
        <div id="main">
            <header class="mb-3 bg-white shadow-sm p-3 rounded">
                
                    <nav class="navbar navbar-expand navbar-light ">
                        <div class="container-fluid">
                            <a href="#" class="burger-btn d-block">
                                <i class="bi bi-justify fs-3"></i>
                            </a>
    
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                    {{-- <li class="nav-item dropdown me-1">
                                        <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class='bi bi-envelope bi-sub fs-4 text-gray-600'></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <h6 class="dropdown-header">Mail</h6>
                                            </li>
                                            <li><a class="dropdown-item" href="#">No new mail</a></li>
                                        </ul>
                                    </li> --}}
                                    {{-- <li class="nav-item dropdown me-3">
                                        <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <h6 class="dropdown-header">Notifications</h6>
                                            </li>
                                            <li><a class="dropdown-item">No notification available</a></li>
                                        </ul>
                                    </li> --}}
                                </ul>
                                <div class="dropdown">
                                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                        <div class="user-menu d-flex">
                                            <div class="user-name text-end me-3">
                                                {{-- <h6 class="mb-0 text-gray-600">{{ Auth::user()->name }}</h6> --}}
                                                {{-- <p class="mb-0 text-sm text-gray-600">{{ Auth::user()->role }}</p> --}}
                                            </div>
                                            <div class="user-img d-flex align-items-center">
                                                <div class="avatar avatar-md">
                                                    <img src="{{asset('assets/images/faces/1.jpg')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            {{-- <h6 class="dropdown-header">Hello, {{ Auth::user()->name }}!</h6> --}}
                                        </li>
                                        <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-person me-2"></i> My
                                                Profile</a></li>
                                            <hr class="dropdown-divider">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </nav>
            </header>
           
            
            <div class="page-heading">
                <h3></h3>
            </div>
            <div class="page-content">
               @yield('content')
            </div>
            
            

           
        </div>
        @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    </div>
    <script src="{{asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('assets/vendors/apexcharts/apexcharts.js')}}"></script>
    <script src="{{asset('assets/js/pages/dashboard.js')}}"></script>

    <script src="{{asset('assets/js/main.js')}}"></script>
</body>

</html>
 
