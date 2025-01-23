<header class="bg-dark text-white shadow-sm">
    <div class="container d-flex justify-content-between align-items-center py-3">
        <!-- Navigation Links -->
        <nav class="d-flex">
            <a href="{{ route('welcome') }}" class="nav-link text-white fw-bold px-3">Home</a>
            @auth('user')
                <a href="#" class="nav-link text-white fw-bold px-3">Dashboard</a>
                <a href="#" class="nav-link text-white fw-bold px-3">Tasks</a>
            @endauth
        </nav>

        <!-- Action Buttons -->
        <div class="d-flex align-items-center">
            @auth('user')
                <div class="position-relative me-3">
                    <!-- Bell Icon -->
                    {{-- {{ route('tasks.reminders') }} --}}
                    <a href="#" class="text-white">
                        <i class="fas fa-bell" style="font-size: 1.5rem;"></i>
                        <!-- Notification Count Badge -->
                        <span id="task-reminder-count"
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            0
                        </span>
                    </a>
                </div>

                <span class="text-white fw-bold me-3">Welcome, {{ Auth::guard('user')->user()->name }}</span>

                <a href="{{ route('myProfile.userProfile') }}" class="btn btn-outline-light fw-bold me-2">My Profile</a>

                {{-- log out  --}}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline-light fw-bold me-2">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light fw-bold me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-light fw-bold">Register</a>
            @endauth
        </div>
    </div>
</header>
