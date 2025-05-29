<!DOCTYPE html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'VisualImpairedAssistance') }} - @yield('title')</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid d-flex align-items-center">
            <!-- Back button uses browser history -->
            <button onclick="window.history.back()" class="btn btn-outline-secondary me-3">
                <i class="fas fa-arrow-left"></i> Back
            </button>
            <span class="fw-bold me-auto d-flex align-items-center">
                User <i class="fas fa-user ms-2"></i>
                @auth
                <form method="POST" action="{{ route('logout') }}" class="ms-4 d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger p-0 ms-2" style="text-decoration: none; font-weight: bold;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
                @endauth
            </span>
        </div>
    </nav>
    <main class="py-4">
        @if (session('success'))
            <div class="container">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="container">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @yield('content')
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
</body>
</html>