@extends('layouts.app')

@section('content')
    <div class="container text-center my-5">
        <h1 class="display-4 text-danger">500</h1>
        <p class="lead">Something went wrong. Please try again later.</p>
        <a href="{{ route('tasks.index') }}" class="btn btn-primary">Back to Tasks</a>
    </div>
@endsection
