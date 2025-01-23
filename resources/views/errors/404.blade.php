@extends('layouts.app')

@section('content')
    <div class="container text-center my-5">
        <h1 class="display-1">404</h1>
        <h3 class="text-danger">Task Not Found</h3>
        <p>The task you are looking for does not exist or has been deleted.</p>
        <a href="{{ route('tasks.index') }}" class="btn btn-primary">Back to Tasks</a>
    </div>
@endsection
