<header class="bg-dark text-white shadow-sm">
    <div class="container d-flex justify-content-between align-items-center py-3">
        <!-- Navigation Links -->
        <nav class="d-flex">
            <a href="{{ route('welcome') }}" class="nav-link text-white fw-bold px-3">Home</a>
            @auth('user')
                <a href="{{ route('tasks.index') }}" class="nav-link text-white fw-bold px-3">Tasks</a>
            @endauth
        </nav>

        <!-- Action Buttons -->
        <div class="d-flex align-items-center">
            @auth('user')
                <!-- Welcome Message -->
                <span class="text-white fw-bold me-3">
                    Welcome, {{ Auth::guard('user')->user()->name }}
                </span>

                <!-- My Profile Button -->
                <a href="{{ route('myProfile.userProfile') }}" class="btn btn-outline-light fw-bold me-2">
                    My Profile
                </a>

                <!-- Logout Form -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn btn-outline-light fw-bold">Logout</button>
                </form>
            @else
                <!-- Login and Register Buttons -->
                <a href="{{ route('login') }}" class="btn btn-outline-light fw-bold me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-light fw-bold">Register</a>
            @endauth
        </div>
    </div>
</header>
