<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Modern Business - Start Bootstrap Template</title>
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
    </head>
    <body class="d-flex flex-column">
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container px-5">
                    <a class="navbar-brand" href="{{ route('home.index') }}"><img src="{{ asset('assets-fe/assets/logo.png') }}" alt="" style="width: 180px;"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

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
            <!-- Page Content-->
            @yield('content')
        </main>
        <!-- Footer-->
        <footer class="bg-dark py-4 mt-auto">
            <div class="container px-5">
                <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                    <div class="col-auto"><div class="small m-0 text-white">Copyright &copy; Your Website 2023</div></div>
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
