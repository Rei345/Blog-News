<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="user-auth" content="{{ auth('pengunjung')->check() || auth('user')->check() }}">
        <title>Reinhard News</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{ asset('assets-fe/assets/favicon.ico') }}" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('assets-fe/css/styles.css') }}" rel="stylesheet" />

        {{-- link ajax  --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

        {{-- link cdn fa fa --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

        <style>
            .kategori-wrapper {
                overflow-x: auto;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
            }
            .kategori-list {
                list-style-type: none;
                padding: 0;
                margin: 0;
            }
            .kategori-list li {
                display: inline-block;
            }
            .active-reply {
                background-color: #d4edda;
                border-color: #c3e6cb;
            }
            /* Warna tombol saat sudah di-like */
            .liked {
                background-color: #007bff !important;
                color: white !important;
                border-color: #007bff !important;
                transition: background-color 0.3s ease, color 0.3s ease;
            }
            /* Efek animasi untuk ikon like */
            .animate-like {
                animation: pop 0.4s ease-out;
            }
            /* Keyframe animasi pop */
            @keyframes pop {
                0% { transform: scale(1); }
                50% { transform: scale(1.4); }
                100% { transform: scale(1); }
            }
        </style>
            
    </head>
    <body class="d-flex flex-column">
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
                    <a class="navbar-brand" href="{{ route('home.index') }}"><img src="{{ asset('assets-fe/assets/logo.png') }}" alt="" style="width: 180px;"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                @if (Auth::guard('pengunjung')->check()) 
                                    <!-- Jika pengguna (pengunjung) login -->
                                    <a class="nav-link" href="{{ route('auth.logout') }}">Logout</a>
                                @elseif (auth('user')->check())
                                    <!-- Jika pengguna (user) login -->
                                    <a class="nav-link" href="{{ route('admin.auth.logout') }}">Logout</a>
                                @else
                                    <!-- Jika pengguna belum login -->
                                    <a class="nav-link" href="{{ route('auth.index') }}">Login</a>
                                @endif
                            </li>                                                                                    

                            @foreach ($menu as $dm)
                                @if (sizeof($dm['itemMenu']) > 0)
                                    <li class="nav-item dropdown">
                                        <a href="{{ $dm['url'] }}" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">
                                            {{ $dm['menu'] }}
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @foreach ($dm['itemMenu'] as $idm)
                                                <li>
                                                    <a href="{{ $idm['sub_menu_url'] }}" class="dropdown-item" target="{{ $idm['sub_menu_target'] }}">
                                                        {{ $idm['sub_menu_nama'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a href="{{ $dm['url'] }}" class="nav-link" target="{{ $dm['target'] }}">
                                            {{ $dm['menu'] }}
                                        </a>
                                    </li>    
                                @endif
                            @endforeach

                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Search and Categories Section -->
            <div class="container py-2 px-3">
                <div class="row align-items-center">
                    <!-- Kolom Pencarian -->
                    <div class="col-md-6 mb-2">
                        <form action="{{ route('home.berita') }}" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Cari berita..." value="{{ request('search') }}">
                                <button class="btn btn-outline-primary" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>
                    <!-- Kategori -->
                    <div class="col-md-6 mb-2">
                        <div class="kategori-wrapper">
                            <ul class="kategori-list d-flex">
                                @foreach($kategori as $kat)
                                <li class="btn btn-outline-secondary m-1">
                                    <a class="nav-link" href="{{ route('home.kategoriBerita', ['id' => $kat->id_kategori]) }}">
                                        {{ $kat->nama_kategori }}
                                    </a>
                                </li>                            
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content-->
            @yield('content')
        </main>
        <!-- Footer-->
        <footer class="bg-dark py-4 mt-auto">
            <div class="container px-5">
                <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                    <div class="col-auto"><div class="small m-0 text-white">Copyright &copy; Your Website 2025</div></div>
                    <div class="col-auto">
                        <a class="link-light small" href="#!">Privacy</a>
                        <span class="text-white mx-1">&middot;</span>
                        <a class="link-light small" href="#!">Terms</a>
                        <span class="text-white mx-1">&middot;</span>
                        <a class="link-light small" href="#!">Contact</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('assets-fe/js/scripts.js') }}"></script>
    </body>
</html>
