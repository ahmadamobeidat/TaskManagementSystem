@extends('layouts.app')

@section('content')
    <div class="container text-center my-5">
        <h1 class="display-4 text-danger">403</h1>
        <p class="lead">Unauthorized access to this task.</p>
        <a href="{{ route('tasks.index') }}" class="btn btn-primary">Back to Tasks</a>
    </div>
@endsection
