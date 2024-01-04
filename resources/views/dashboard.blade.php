@extends('layouts.template')
@section('content')
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
        @if (Auth::check() && Auth::user()->role == "admin")
        <h1>Dashboard</h1>
        <div class="mb-1">
            <a href="{{ route('home.page') }}">Home / </a>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </div><br>
        <div class="row">
            <div class="col-12 col-md-6 mb-4">
                <div class="card flex-fill border-0 illustration">
                    <div class="card-body p-0 d-flex flex-fill">
                        <div class="row g-0 w-100">
                            <div class="col-6">
                                <div class="p-3 m-1">
                                    <h4>Peserta Didik</h4>
                                </div>
                                <div class="user">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="40" width="55" class="userIcon"
                                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                                        <path fill="#0a27ff"
                                            d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                                    </svg>
                                    <h2>{{ $jumlahPesertaDidik }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 mb-4">
                <div class="card flex-fill border-0 illustration">
                    <div class="card-body p-0 d-flex flex-fill">
                        <div class="row g-0 w-100">
                            <div class="col-6">
                                <div class="p-3 m-1">
                                    <h4>Administator</h4>
                                </div>
                                <div class="user">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="40" width="55" class="userIcon"
                                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                                        <path fill="#0a27ff"
                                            d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                                    </svg>
                                    <h2>{{ $jumlahAdministrator }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-4">
                <div class="card flex-fill border-0 illustration">
                    <div class="card-body p-0 d-flex flex-fill">
                        <div class="row g-0 w-100">
                            <div class="col-6">
                                <div class="p-3 m-1">
                                    <h4>Pembimbing Siswa</h4>
                                </div>
                                <div class="user">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="40" width="55" class="userIcon"
                                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                                        <path fill="#0a27ff"
                                            d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                                    </svg>
                                    <h2>{{ $jumlahPembimbingSiswa }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-4">
                <div class="card flex-fill border-0 illustration">
                    <div class="card-body p-0 d-flex flex-fill">
                        <div class="row g-0 w-100">
                            <div class="col-6">
                                <div class="p-3 m-1">
                                    <h4>Rayon</h4>
                                </div>
                                <div class="user">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="countryIcon" height="40"
                                        width="55"
                                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                                        <path fill="#004be0"
                                            d="M448 48V384C385 407 366 416 329 416C266 416 242 384 179 384C159 384 143 388 128 392V328C143 324 159 320 179 320C242 320 266 352 329 352C349 352 364 349 384 343V135C364 141 349 144 329 144C266 144 242 112 179 112C128 112 104 133 64 141V448C64 466 50 480 32 480S0 466 0 448V64C0 46 14 32 32 32S64 46 64 64V77C104 69 128 48 179 48C242 48 266 80 329 80C366 80 385 71 448 48z" />
                                    </svg>
                                    <h2>{{    $jumlahRayon }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-4">
                <div class="card flex-fill border-0 illustration">
                    <div class="card-body p-0 d-flex flex-fill">
                        <div class="row g-0 w-100">
                            <div class="col-6">
                                <div class="p-3 m-1">
                                    <h4>Rombel</h4>
                                </div>
                                <div class="user">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="countryIcon" height="40"
                                        width="55"
                                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                                        <path fill="#004be0"
                                            d="M448 48V384C385 407 366 416 329 416C266 416 242 384 179 384C159 384 143 388 128 392V328C143 324 159 320 179 320C242 320 266 352 329 352C349 352 364 349 384 343V135C364 141 349 144 329 144C266 144 242 112 179 112C128 112 104 133 64 141V448C64 466 50 480 32 480S0 466 0 448V64C0 46 14 32 32 32S64 46 64 64V77C104 69 128 48 179 48C242 48 266 80 329 80C366 80 385 71 448 48z" />
                                    </svg>
                                    <h2>{{ $jumlahRombel }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @else  
        <h1>Dashboard</h1>
        <div class="mb-1">
            <a href="{{ route('home.page') }}">Home / </a>
            <a href="{{ route('dashboardPs') }}">Dashboard</a>
        </div><br>

        <div class="row">
            <div class="col-12 col-md-6 mb-4">
                <div class="card flex-fill border-0 illustration">
                    <div class="card-body p-0 d-flex flex-fill">
                        <div class="row g-0 w-100">
                            <div class="col-6">
                                @if($namaRayon->isNotEmpty())
                                <div class="p-3 m-1">
                                <h4>Peserta Didik Rayon {{ $namaRayon[0]->rayon }}</h4>
                                 </div>
                                @endif
                                <div class="user">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="40" width="55" class="userIcon"
                                        viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                                        <path fill="#0a27ff"
                                            d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                                    </svg>
                                    <h2>{{ $jumlahPesertaDidik }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 mb-4">
                <div class="card flex-fill border-0 illustration">
                    <div class="card-body p-0 d-flex flex-fill">
                        <div class="row g-0 w-100">
                            <div class="col-6">
                                @if($namaRayon->isNotEmpty())
                                <div class="p-3 m-1">
                                    <h4>Siswa Rayon {{ $namaRayon[0]->rayon }} Terlambat Hari Ini</h4>
                                </div>
                                @endif
                                <div class="user">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="40" width="55" class="userIcon"
                                        viewBox ="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.-->
                                        <path fill="#0a27ff"
                                            d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                                    </svg>
                                    <h2>{{ $jumlahSiswaTerlambat }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card flex-fill border-0 illustration">
                    <div class="card-body p-0 d-flex flex-fill">
                        <div class="row g-0 w-100">
                            <div class="col-6">
                                <div class="p-3 m-1">
                                    <h4 class="date">Tanggal {{ $currentTime }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/script.js') }}"></script>
        @stack('script')
    @endsection
</body>

</html>
