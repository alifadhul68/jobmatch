<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Job Match</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('/icon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href={{asset('/icon/favicon-32x32.png')}}>
    <link rel="icon" type="image/png" sizes="16x16" href={{asset('/icon/favicon-16x16.png')}}>
    <link rel="manifest" href={{asset('/icon/site.webmanifest')}}>
    <link rel="mask-icon" href={{asset('/icon/safari-pinned-tab.svg')}} color="#5bbad5">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{asset('css/styles.css')}}" rel="stylesheet" />
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
<div class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand" href="/">Job Match</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link btn btn-dark {{ Request::is('/') ? 'active' : '' }}" aria-current="page" href="/">Home</a>

                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-dark {{ Request::is('jobs') ? 'active' : '' }}" href="{{route('jobs')}}">Jobs</a>
                </li>
                @if(Auth::check())
                    <li class="nav-item dropdown">
                        <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Storage::url(auth()->user()->profile_pic) }}" alt="Profile Picture" class="rounded-circle" width="30">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark text-center">
                            @if(auth()->user()->user_type == 'employer')
                                <li><a class="dropdown-item nav-link" href="{{route('employer.profile')}}">Profile</a></li>
                                <li><a class="dropdown-item nav-link" href="{{route('dashboard')}}">Employer Dashboard</a></li>
                            @else
                                <li><a class="dropdown-item nav-link" href="{{route('seeker.profile')}}">Profile</a></li>
                                <li><a class="dropdown-item nav-link" href="{{route('user.jobs')}}">Job Applications</a></li>
                            @endif
                                <li><a class="dropdown-item nav-link" href="{{route('messages')}}">Messages</a></li>
                                <li><a class="dropdown-item nav-link" id="logout" href="#">Logout</a></li>
                        </ul>
                    </li>
                @endif
                @if(!Auth::check())
                    <li class="nav-item">
                        <a class="nav-link btn btn-dark {{ Request::is('login') ? 'active' : '' }}" href="{{route('login')}}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-dark {{ Request::is('register/seeker') ? 'active' : '' }}" href="{{route('create.seeker')}}">Job Seeker</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-dark {{ Request::is('register/employer') ? 'active' : '' }}" href="{{route('create.employer')}}">Employer</a>
                    </li>
                @endif
                <form id="logoutForm" action="{{route('logout')}}" method="post">@csrf</form>
            </ul>
        </div>
    </div>
</nav>

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <footer class="mt-5 bg-body-tertiary text-center text-lg-start">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2023 Copyright: JobMatch. Inc
        </div>
        <!-- Copyright -->
    </footer>
</div>

<style>
    ul li:not(:last-child) {
        border-right:1px solid grey;
        margin-right:20px;
        padding-right:20px;
    }
</style>

<script>
    let logout = document.getElementById('logout');
    let logoutForm = document.getElementById('logoutForm');
    logout.addEventListener('click', function () {
        logoutForm.submit();
    })
</script>
<script src="{{asset('js/datatables-simple-demo.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
