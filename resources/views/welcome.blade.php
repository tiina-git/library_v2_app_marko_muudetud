<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">Raamatukogu v2</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/home') }}">Avaleht</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Logi sisse</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Registreeru</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-8 text-center">
                <h1 class="display-3 fw-bold mb-4">Tere tulemast Laravel'i</h1>
                <p class="lead text-muted mb-5">
                    Alusta oma järgmise suurepärase projekti loomist koos Laravel'i ja Bootstrapiga
                </p>
                
                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-primary btn-lg px-4 gap-3">
                            Mine avalehele
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4 gap-3">
                            Alusta
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg px-4">
                            Logi sisse
                        </a>
                    @endauth
                </div>

                <div class="mt-5 pt-5">
                    <p class="text-muted">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>