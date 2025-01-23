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
            <div class="col-md-12">
                <div class="card profile-card shadow-lg">
                    <div class="card-header text-center text-white bg-secondary">
                        <h4 class="fw-bold">Update User Info</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('myProfile.updateProfile') }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Display Global Error Messages --}}
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('danger'))
                                <div class="alert alert-danger">
                                    {{ session('danger') }}
                                </div>
                            @endif

                            {{-- Display Validation Errors --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                {{-- Name --}}
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label text-muted">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name', $user->name) }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label text-muted">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                {{-- Date of Birth --}}
                                <div class="col-md-6 mb-3">
                                    <label for="date_of_birth" class="form-label text-muted">Date of Birth:</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                        value="{{ old('date_of_birth', $user->date_of_birth) }}" required>
                                    @error('date_of_birth')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                {{-- Password --}}
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label text-muted">Password:</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Confirm Password --}}
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label text-muted">Confirm
                                        Password:</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation">
                                    @error('password_confirmation')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
