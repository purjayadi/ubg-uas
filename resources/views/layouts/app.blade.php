<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RevResto')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding: 1rem;
        }

        /* Navbar Styling */
        .navbar {
            /* warm restaurant palette: soft orange gradient */
            background: linear-gradient(90deg,#682b1e 0%, #682b1e 100%) !important;
            box-shadow: 0 4px 18px rgba(255, 122, 69, 0.18);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 900;
            font-size: 1.8rem;
            color: white !important;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand::before {
            content: "🍽️";
            font-size: 1.5rem;
        }

        .nav-link {
            color: white !important;
            font-weight: 600;
            margin: 0 10px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: #ffe0e0 !important;
            transform: translateY(-2px);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: white;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .dropdown-menu {
            background: linear-gradient(135deg, #682b1e 0%,#682b1e 100%);
            border: none;
        }

        .dropdown-item {
            color: white;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .dropdown-item:focus {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Card Styling */
        .card-restaurant {
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            height: 100%;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            background: white;
        }

        .card-restaurant:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 14px 30px rgba(255, 122, 69, 0.12);
        }

        .card-restaurant img {
            transition: transform 0.3s ease;
            height: 200px;
            object-fit: cover;
        }

        .card-restaurant:hover img {
            transform: scale(1.1);
        }

        .stars {
            color:#682b1e;
            font-size: 1.2rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            color: #604545;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(90deg,#682b1e 0%, #682b1e 100%);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.22s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(255, 122, 69, 0.18);
        }

        .btn-success {
            background: linear-gradient(90deg, #61440b 0%, #61440b 100%);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(81, 207, 102, 0.3);
            color: white;
        }

        /* Container */
        .container {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            margin: 2rem auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 1100px;
            width: calc(100% - 2rem);
        }

        /* Footer */
        footer {
            background: linear-gradient(90deg, #682b1e 0%, #682b1e 100%) !important;
            color: white !important;
            margin-top: 4rem;
        }

        footer p {
            color: white !important;
        }

        /* Alert */
        .alert {
            border-radius: 10px;
            border: none;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(90deg, #51cf66 0%, #69db7c 100%);
            color: white;
        }

        .alert-danger {
            background: linear-gradient(90deg, #682b1e 0%, #682b1e 100%);
            color: white;
        }

        /* Heading */
        h1 {
            color: #8a3b2a; /* warm brown heading for food sites */
            font-weight: 800;
            margin-bottom: 2rem;
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('restaurants.index') }}">RevResto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('restaurants.index') }}">
                            <i class="fas fa-utensils me-2"></i>Restoran
                        </a>
                    </li>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('restaurants.create') }}">
                                    <i class="fas fa-plus me-2"></i>Tambah Restoran
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-2"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-2"></i>Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success"><i class="fas fa-check me-2"></i>{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger"><i class="fas fa-exclamation me-2"></i>{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

    {{-- <footer class="border-top mt-5 py-4">
        <div class="container text-center">
            <p><i class="fas fa-copyright me-2"></i>2026 RevResto. Semua hak dilindungi.</p>
        </div>
    </footer> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>