<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <x-application-logo class="d-inline-block align-text-top" />
        </a>

        <!-- Hamburger Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="nav-link">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </li>

                @if(Auth::user()->role->name === 'Supervisor')
                    <!-- <li class="nav-item">
                        <x-nav-link :href="route('applications.indexAll')" :active="request()->routeIs('applications.indexAll')" class="nav-link">
                            {{ __('All Application') }}
                        </x-nav-link>
                    </li>
                    <li class="nav-item">
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="nav-link">
                            {{ __('User Management') }}
                        </x-nav-link>
                    </li> -->
                @endif

                @if(Auth::user()->role->name === 'CS')
                <!-- <li class="nav-item">
                        <x-nav-link :href="route('applications.index')" :active="request()->routeIs('applications.index')" class="nav-link">
                            {{ __('Application') }}
                        </x-nav-link>
                    </li> -->
                @endif
            </ul>

            <!-- Right Side -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <!-- Authentication Links -->
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();" class="dropdown-item">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <x-nav-link :href="route('login')" class="nav-link">
                            {{ __('Log in') }}
                        </x-nav-link>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <x-nav-link :href="route('register')" class="nav-link">
                                {{ __('Register') }}
                            </x-nav-link>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>
</nav>
