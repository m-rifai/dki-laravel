<!-- resources/views/layouts/sidebar.blade.php -->

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <!-- Dashboard Link -->
            <li class="nav-item">
                <a class="nav-link @if(request()->routeIs('dashboard')) active @endif" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Dashboard
                </a>
            </li>

            @if(Auth::check())
                @if(Auth::user()->role->name === 'Supervisor')
                    <!-- All Applications -->
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('applications.indexAll')) active @endif" href="{{ route('applications.indexAll') }}">
                            <i class="bi bi-folder2-open me-2"></i>
                            All Applications
                        </a>
                    </li>

                    <!-- User Management -->
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('users.index')) active @endif" href="{{ route('users.index') }}">
                            <i class="bi bi-people me-2"></i>
                            User Management
                        </a>
                    </li>
                @endif

                @if(Auth::user()->role->name === 'CS')
                    <!-- Applications -->
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('applications.index')) active @endif" href="{{ route('applications.index') }}">
                            <i class="bi bi-file-earmark-text me-2"></i>
                            Applications
                        </a>
                    </li>
                @endif


            @endif
        </ul>
    </div>
</nav>
