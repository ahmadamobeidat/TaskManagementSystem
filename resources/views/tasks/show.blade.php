@extends('layouts.app')

@section('content')
    <div class="container my-5">
        {{-- Success and Error Messages --}}
        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session()->has('danger'))
            <div class="alert alert-danger">{{ session('danger') }}</div>
        @endif

        <h1 class="text-center mb-4">Task Details</h1>

        <div class="card shadow">
            <div class="card-body">
                <h3 class="card-title">{{ $task->title }}</h3>
                <p class="card-text"><strong>Description:</strong> {{ $task->description }}</p>
                <p class="card-text"><strong>Status:</strong>
                    <span class="badge"
                        style="background-color: {{ $task->status == 'Completed' ? 'green' : ($task->status == 'To Do' ? 'blue' : 'orange') }}; color: white;">
                        {{ $task->status }}
                    </span>
                </p>
                <p class="card-text"><strong>Priority:</strong>
                    <span class="badge"
                        style="background-color: {{ $task->priority == 'High' ? 'red' : ($task->priority == 'Medium' ? 'orange' : 'blue') }}; color: white;">
                        {{ $task->priority }}
                    </span>
                </p>
                <p class="card-text"><strong>Due Date:</strong>
                    {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</p>
                <p class="card-text"><strong>Created At:</strong>
                    {{ \Carbon\Carbon::parse($task->created_at)->format('M d, Y') }}</p>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to Tasks</a>
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary">Edit Task</a>
            </div>
        </div>
    </div>
@endsection
<style>
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        /* Bootstrap Primary Color */
        border-color: #007bff;
        color: #fff;
    }

    .pagination .page-link {
        color: #007bff;
        /* Text Color */
    }

    .pagination .page-link:hover {
        background-color: #e9ecef;
        /* Light Grey Background */
        color: #0056b3;
        /* Darker Blue Text */
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .table .badge {
        font-size: 0.9rem;
        padding: 0.5em 0.75em;
    }

    .badge {
        display: inline-block !important;
    }

    .icon-group .btn {
        margin-right: 5px;
    }

    .icon-group .btn:last-child {
        margin-right: 0;
    }

    .action-icons {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .table {
        width: 100%;
        /* Ensure the table spans the entire container */
        table-layout: fixed;
        /* Prevent unnecessary horizontal scrolling */
        word-wrap: break-word;
        /* Wrap text to prevent overflow */
    }

    .table-responsive {
        overflow: hidden;
        /* Remove scrollbars */
    }

    td,
    th {
        text-align: center;
        /* Center-align all cells */
        vertical-align: middle;
        /* Vertically align content in the middle */
    }
</style>
