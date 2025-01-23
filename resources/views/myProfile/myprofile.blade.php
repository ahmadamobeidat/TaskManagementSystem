@extends('layouts.app')

@section('content')
    {{-- Sweet Alert Section --}}
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
                swal("Oops !!!", "{!! Session::get('danger') !!}", "error", {
                    button: "Close",
                });
            </script>
        @endif
    </div>

    {{-- Profile Section --}}
    <div class="container mt-5">
        <div class="row">
            {{-- Profile Section --}}
            <div class="col-md-6">
                <div class="card profile-card shadow-lg">
                    <div class="card-header text-center text-white bg-secondary">
                        <h4 class="fw-bold">User Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="{{ asset('front_end_style/images/profile.jpg') }}" alt="Profile Picture"
                                class="rounded-circle profile-picture">
                        </div>
                        <table class="table table-borderless">
                            <tr>
                                <th class="text-muted">Name:</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Email:</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Date of Birth:</th>

                                <td>{{ $user->date_of_birth }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Joined:</th>
                                <td>{{ $user->created_at->format('F d, Y') }}</td>
                            </tr>
                        </table>
                        <hr>
                        <div class="stats-section text-center">
                            <h5 class="text-muted mb-3">Your Stats</h5>
                            <div class="row text-center">
                                <div class="col">
                                    <h6 class="fw-bold text-primary">{{ $completedTasks ?? 0 }}</h6>
                                    <p class="text-muted">Tasks Completed</p>
                                </div>
                                <div class="col">
                                    <h6 class="fw-bold text-warning">{{ $inProgressTasks ?? 0 }}</h6>
                                    <p class="text-muted">In Progress Tasks</p>
                                </div>
                                <div class="col">
                                    <h6 class="fw-bold text-success">{{ $toDoTasks ?? 0 }}</h6>
                                    <p class="text-muted">To Do</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center mt-4">
                            <a href="{{ route('myProfile.editUserProfile') }}" class="btn btn-primary">Edit Profile</a>

                            {{-- logout --}}
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Additional Info Section --}}
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white text-center">
                        <h4 class="fw-bold">Achivments</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th class="text-muted">Achivemnt Prize 1:</th>
                                <td>🏆 Gold Medalist x 3</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Achivemnt Prize 2:</th>
                                <td>🎖 Best Coder 2025</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Achievements:</th>
                                <td>5 Hackathons Completed</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Total Points:</th>
                                <td>1020 XP</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
