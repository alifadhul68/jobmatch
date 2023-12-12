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
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet"/>
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
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                @if(!Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('login')}}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('create.seeker')}}">Job Seeker</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('create.employer')}}">Employer</a>
                    </li>
                @endif
                @if(Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('seeker.profile')}}">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="logout" href="#">Logout</a>
                    </li>
                @endif
                <form id="logoutForm" action="{{route('logout')}}" method="post">@csrf</form>
            </ul>
        </div>
    </div>
</nav>
@yield('content')
<script>
    let logout = document.getElementById('logout');
    let logoutForm = document.getElementById('logoutForm');
    logout.addEventListener('click', function () {
        logoutForm.submit();
    })
</script>
</body>
</html>
