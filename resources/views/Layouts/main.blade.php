<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flash News - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        .navbar-brand {
            font-weight: bold;
            font-size: 24px;
        }

        .flash-news {
            color: #0d6efd;
        }

        .weather-widget {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .category-title {
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }

        .trending-item {
            margin-bottom: 15px;
        }

        .latest-news {
            margin-top: 30px;
        }

        .footer {
            background-color: #212529;
            color: white;
            padding: 30px 0;
            margin-top: 50px;
        }

        .footer a {
            color: #adb5bd;
            text-decoration: none;
        }

        .footer a:hover {
            color: white;
        }

        .social-icons i {
            font-size: 1.5rem;
            margin-right: 10px;
        }

        .news-item {
            margin-bottom: 20px;
        }

        .news-item img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .featured-news img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .white-space-nowrap {
            white-space: nowrap;
        }

        .navbar .nav-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.95rem;
        }

        @media (max-width: 576px) {
            .navbar .nav-link {
                font-size: 0.85rem;
                padding: 0.4rem 0.6rem;
            }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Navbar Baris Atas -->
    <nav class="navbar navbar-expand-lg bg-white border-bottom">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand fw-bold fs-3" href="{{ route('home') }}">
                <span class="fst-italic">FLASH</span><span class="text-primary fst-italic">NEWS</span>
            </a>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-3">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tentang') }}">Tentang Kami</a>
                    </li>
                </ul>
            </div>

            <div class="d-flex align-items-center">
                <form class="d-flex align-items-center" action="{{ route('search') }}" method="GET" role="search">
                    <div class="input-group">
                        <input type="search" class="form-control" placeholder="Cari Berita" name="query">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <div class="dropdown ms-3">
                    <a class="btn btn-link dropdown-toggle text-dark" href="#" role="button" id="userDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-4"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        @guest
                            <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                        @endguest

                        @auth
                            <li>
                                <span class="dropdown-item-text fw-bold">{{ Auth::user()->name }}</span>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">Profil Saya</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('news.saved') }}">Berita Tersimpan</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item w-100 text-start border-0 bg-transparent">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Navbar Baris Bawah -->
    <nav class="navbar navbar-expand-lg bg-black py-2">
        <div class="container-fluid px-3 d-flex justify-content-center">
            <div class="d-flex flex-nowrap overflow-auto gap-3" style="max-width: 100%;">
                <a class="nav-link text-white white-space-nowrap "
                    href="{{ route('category', 'business') }}">Bisnis</a>
                <a class="nav-link text-white white-space-nowrap"
                    href="{{ route('category', 'health') }}">Kesehatan</a>
                <a class="nav-link text-white white-space-nowrap"
                    href="{{ route('category', 'politics') }}">Politik</a>
                <a class="nav-link text-white white-space-nowrap"
                    href="{{ route('category', 'technology') }}">Teknologi</a>
                <a class="nav-link text-white white-space-nowrap" href="{{ route('category', 'culture') }}">Budaya</a>
                <a class="nav-link text-white white-space-nowrap" href="{{ route('category', 'sports') }}">Olahraga</a>
                <a class="nav-link text-white white-space-nowrap"
                    href="{{ route('category', 'environment') }}">Lingkungan</a>
                <a class="nav-link text-white white-space-nowrap"
                    href="{{ route('category', 'automotive') }}">Otomotif</a>
                <a class="nav-link text-white white-space-nowrap" href="{{ route('category', 'science') }}">Sains</a>
                <a class="nav-link text-white white-space-nowrap" href="{{ route('category', 'lifestyle') }}">Gaya
                    Hidup</a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="flex-fill">
        <div class="container mt-4">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer bg-black">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h4><span class="fst-italic">FLASH</span><span class="text-primary fst-italic">NEWS</span></h4>
                    <p>Portal berita terkini dan terpercaya.</p>
                </div>
                <div class="col-md-3">
                    <h5>Tentang</h5>
                    <ul class="list-unstyled">
                        <li><a class="nav-link" href="{{ route('tentang') }}">Tentang Kami</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Kategori</h5>
                    <div class="row">
                        @php
                            $categories = [
                                'business' => 'Bisnis',
                                'health' => 'Kesehatan',
                                'politics' => 'Politik',
                                'technology' => 'Teknologi',
                                'culture' => 'Budaya',
                                'sports' => 'Olahraga',
                                'environment' => 'Lingkungan',
                                'automotive' => 'Otomotif',
                                'science' => 'Sains',
                                'lifestyle' => 'Gaya Hidup',
                            ];

                            $chunks = array_chunk($categories, 5, true);
                        @endphp

                        @foreach ($chunks as $chunk)
                            <div class="col-6">
                                <ul class="list-unstyled">
                                    @foreach ($chunk as $slug => $name)
                                        <li>
                                            <a class="nav-link text-white p-0 mb-1 d-block"
                                                href="{{ route('category', $slug) }}">
                                                {{ $name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="social-icons mt-3">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; {{ date('Y') }} Flash News. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
