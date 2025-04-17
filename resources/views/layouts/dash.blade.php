<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    <script src="https://kit.fontawesome.com/e785ddfc20.js" crossorigin="anonymous"></script>
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark"
        style="padding-right: 10px;padding-left: 10px  ;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">HelpCenter ICT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">Ticket</a>
                    </li>
                    @if (isset($userRole))
                        @if ($userRole)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user') }}">User management</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">FAQ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Analyst</a>
                            </li>
                        @endif
                    @endif

                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
    <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
        <div id="live-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="{{ asset('img/logo.png') }}" class="rounded me-2"
                    style="height: 25px;width: 25px;object-fit: cover;border-radius: 5px;">
                <strong class="me-auto">
                    @if (session('status'))
                        {{ session('status') }}
                    @else
                        Sucess!
                    @endif
                </strong>
                <small>Just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                @if (session('message'))
                    {{ session('message') }}
                @endif
            </div>
        </div>
    </div>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
    @if (session('message'))
        <script>
            const toastLiveExample = document.getElementById("live-toast");
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
            toastBootstrap.show();
        </script>
    @endif
</body>

</html>
