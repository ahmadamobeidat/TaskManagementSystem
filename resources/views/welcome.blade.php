@extends('layouts.app')

@section('content')
    {{-- =========================================================== --}}
    {{-- ================== Sweet Alert Section ==================== --}}
    {{-- =========================================================== --}}
    <div>
        @if (session()->has('success'))
            <script>
                swal("Great Job !!!", "{!! Session::get('success') !!}", "success", {
                    button: "OK",
                });
            </script>
        @endif

        @if (session()->has('danger'))
            <script>
                swal("oops !!!", "{!! Session::get('danger') !!}", "error", {
                    button: "Close",
                });
            </script>
        @endif
    </div>

    <div class="welcome-page">
        <!-- Hero Section -->
        <section class="hero-section bg-white text-dark text-center py-5">
            <div class="container">
                <h1 class="display-4 fw-bold">Welcome to Task Manager</h1>
                <p class="lead mt-3">
                    Organize your tasks, boost your productivity, and achieve your goals effortlessly.
                </p>
                @auth('user')
                    <a href="{{ route('tasks.index') }}" class="btn btn-dark fw-bold px-4 py-2 mt-4">Tasks</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-dark fw-bold px-4 py-2 mt-4">Get Started</a>
                @endauth
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-5" style="background-color: white;">
            <div class="container text-center">
                <h2 class="fw-bold mb-4" style="color: black;">Features</h2>
                <p class="text-muted mb-5">What makes our Task Manager unique</p>
                <div class="row">
                    <!-- Feature 1 -->
                    <div class="col-md-4 mb-4">
                        <div class="p-4 bg-light shadow-sm rounded">
                            <h4 class="fw-bold">Task Automation</h4>
                            <p class="text-muted">Automate repetitive tasks and workflows, saving you time and effort.</p>
                        </div>
                    </div>
                    <!-- Feature 2 -->
                    <div class="col-md-4 mb-4">
                        <div class="p-4 bg-light shadow-sm rounded">
                            <h4 class="fw-bold">Collaboration Tools</h4>
                            <p class="text-muted">Share tasks and updates with your team in real-time to boost
                                collaboration.</p>
                        </div>
                    </div>
                    <!-- Feature 3 -->
                    <div class="col-md-4 mb-4">
                        <div class="p-4 bg-light shadow-sm rounded">
                            <h4 class="fw-bold">Customizable Dashboards</h4>
                            <p class="text-muted">Tailor your workspace to fit your specific needs and preferences.</p>
                        </div>
                    </div>
                    <!-- Feature 4 -->
                    <div class="col-md-4 mb-4">
                        <div class="p-4 bg-light shadow-sm rounded">
                            <h4 class="fw-bold">Reminders and Notifications</h4>
                            <p class="text-muted">Get timely reminders and notifications to ensure you never miss a
                                deadline.</p>
                        </div>
                    </div>
                    <!-- Feature 5 -->
                    <div class="col-md-4 mb-4">
                        <div class="p-4 bg-light shadow-sm rounded">
                            <h4 class="fw-bold">Integration Options</h4>
                            <p class="text-muted">Seamlessly integrate with other tools like Google Calendar, Slack, and
                                more.</p>
                        </div>
                    </div>
                    <!-- Feature 6 -->
                    <div class="col-md-4 mb-4">
                        <div class="p-4 bg-light shadow-sm rounded">
                            <h4 class="fw-bold">Progress Tracking</h4>
                            <p class="text-muted">Visualize your progress with charts, graphs, and detailed insights.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Call-to-Action Section -->
        @auth('user')
        @else
            <section class="py-5 text-center" style="background-color: white;">
                <h2 class="mb-3" style="color: black;">Ready to take control of your tasks?</h2>
                <p class="mb-4" style="color: black;">
                    Join our growing community and make task management easier than ever!
                </p>
                <a href="{{ route('register') }}" class="btn btn-dark">Sign Up Now</a>
            </section>
        @endauth
    </div>
@endsection
