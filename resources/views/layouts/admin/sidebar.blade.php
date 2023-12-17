<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Main</div>
            <a class="nav-link" href="{{route('dashboard')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>
            <a id="logout" class="nav-link" href="#">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Logout
            </a>
            <form id="logoutForm" action="{{route('logout')}}" method="post">@csrf</form>
            <div class="sb-sidenav-menu-heading">Company Management</div>
            <a class="nav-link" href="{{route('employer.profile')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Profile
            </a>
            <a class="nav-link" href="{{route('pay')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Subscribe
            </a>
            <div class="sb-sidenav-menu-heading">HR Management</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
               aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Jobs
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                 data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{route('job.create')}}">Post Job</a>
                    <a class="nav-link" href="{{route('job.index')}}">Your Jobs</a>
                </nav>
            </div>
            <a class="nav-link" href="{{route('applicants.index')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Applicants
            </a>
            <a class="nav-link" href="{{route('messages')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Messages
            </a>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        {{ auth()->user()->name }}
    </div>
</nav>

<script>
    let logout = document.getElementById('logout');
    let logoutForm = document.getElementById('logoutForm');
    logout.addEventListener('click', function () {
        logoutForm.submit();
    })
</script>
<style>
    .note-insert {
        display: none;
    }
</style>
