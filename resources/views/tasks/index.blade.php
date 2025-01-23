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
                swal("Oops !!!", "{!! Session::get('danger') !!}", "error", {
                    button: "Close",
                });
            </script>
        @endif
    </div>

    {{-- =========================================================== --}}
    {{-- ================== Tasks Section ========================== --}}
    {{-- =========================================================== --}}
    <div class="container my-5">
        {{-- Search --}}
        <div class="col-md-12 groove-container">
            <label>
                <h2>Search Section</h2>
            </label>
            <br>
            <form action="{{ route('tasks.search') }}" method="GET" class="row g-3" id="searchForm">
                {{-- Title --}}
                <div class="col-md-2">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title"
                        value="{{ $searchValues['title'] ?? '' }}" placeholder="Title">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="col-md-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                        id="description" value="{{ $searchValues['description'] ?? '' }}" placeholder="Description">
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status Dropdown --}}
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="">All</option>
                        <option value="1" @selected(isset($searchValues['status']) && $searchValues['status'] == 1)>To Do</option>
                        <option value="2" @selected(isset($searchValues['status']) && $searchValues['status'] == 2)>In Progress</option>
                        <option value="3" @selected(isset($searchValues['status']) && $searchValues['status'] == 3)>Completed</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Priority Dropdown --}}
                <div class="col-md-2">
                    <label for="priority" class="form-label">Priority</label>
                    <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror">
                        <option value="">All</option>
                        <option value="1" @selected(isset($searchValues['priority']) && $searchValues['priority'] == 1)>High</option>
                        <option value="2" @selected(isset($searchValues['priority']) && $searchValues['priority'] == 2)>Medium</option>
                        <option value="3" @selected(isset($searchValues['priority']) && $searchValues['priority'] == 3)>Low</option>
                    </select>
                    @error('priority')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Due Date --}}
                <div class="col-md-3">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input type="date" name="due_date" id="due_date" class="form-control @error('due_date') is-invalid @enderror"
                        value="{{ $searchValues['due_date'] ?? '' }}">
                    @error('due_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Search Button --}}
                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>

        </div>

        <br>
        <h1 class="text-center mb-4">My Tasks</h1>


        {{-- Tasks Table --}}
        {{-- Create --}}
        <div class="dropdown me-2">
            <a href="{{ route('tasks.create') }}" class="btn btn-dark">
                <i data-feather="plus" class="fill-white feather-sm"></i>Add New Task
            </a>
        </div>

        <br>

        <div>
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tasks as $index => $task)
                        <tr>
                            {{-- Title --}}
                            <td>{{ $task->title ?? '---' }}</td>

                            {{-- Description --}}
                            <td>{{ $task->description ?? '---' }}</td>

                            {{-- Status --}}
                            <td id="status" data-task-id="{{ $task->id }}" data-status="{{ $task->status }}"
                                class="text-center">
                                <!-- Status Badge -->
                                <span id="status-text" class="badge"
                                    style="cursor: pointer; background-color: {{ $task->status == 'Completed' ? 'green' : ($task->status == 'To Do' ? 'blue' : ($task->status == 'In Progress' ? 'orange' : 'red')) }}; color: white;">
                                    {{ $task->status ?? '---' }}
                                </span>

                                <!-- Status dropdown (hidden by default) -->
                                <select id="status-dropdown" class="form-select form-select-sm"
                                    style="display:none; width: auto;">
                                    <option value="1" {{ $task->status == 'To Do' ? 'selected' : '' }}>To Do
                                    </option>
                                    <option value="2" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In
                                        Progress</option>
                                    <option value="3" {{ $task->status == 'Completed' ? 'selected' : '' }}>
                                        Completed</option>
                                </select>
                            </td>

                            {{-- Priority --}}
                            <td id="priority" data-task-id="{{ $task->id }}" data-priority="{{ $task->priority }}"
                                class="text-center">
                                <!-- Priority Badge -->
                                <span id="priority-text" class="badge"
                                    style="cursor: pointer; background-color: {{ $task->priority == 'High' ? 'red' : ($task->priority == 'Medium' ? 'orange' : 'blue') }}; color: white;">
                                    {{ $task->priority ?? '---' }}
                                </span>

                                <!-- Priority dropdown (hidden by default) -->
                                <select id="priority-dropdown" class="form-select form-select-sm"
                                    style="display:none; width: auto;">
                                    <option value="1" {{ $task->priority == 'High' ? 'selected' : '' }}>High
                                    </option>
                                    <option value="2" {{ $task->priority == 'Medium' ? 'selected' : '' }}>Medium
                                    </option>
                                    <option value="3" {{ $task->priority == 'Low' ? 'selected' : '' }}>Low
                                    </option>
                                </select>
                            </td>

                            {{-- Due Date --}}
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                            </td>

                            {{-- Actions --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    {{-- Show Icon --}}
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-success"
                                        title="Show Task">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Edit Icon --}}
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-primary"
                                        title="Edit Task">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Delete Icon --}}
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                        class="d-inline m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete Task">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No tasks found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        @if ($tasks->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">Previous</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $tasks->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo; Previous</span>
                                </a>
                            </li>
                        @endif

                        @foreach ($tasks->getUrlRange(1, $tasks->lastPage()) as $page => $url)
                            <li class="page-item {{ $tasks->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        @if ($tasks->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $tasks->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">Next &raquo;</span>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Next</span>
                            </li>
                        @endif
                    </ul>
                </nav>
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

<!-- Include jQuery from a CDN -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

{{-- add csrf token --}}
<meta name="csrf-token" content="{{ csrf_token() }}" />

{{-- update the status DIRECTLY From show --}}
<script>
    $(document).ready(function() {
        // Show the dropdown when the badge is clicked
        $('#status-text').on('click', function() {
            const $statusCell = $('#status');
            const currentStatus = $statusCell.attr('data-status');

            // Hide the badge and show the dropdown
            $('#status-text').hide();
            $('#status-dropdown').val(currentStatus).show().focus();
        });

        // Handle dropdown change to update status
        $('#status-dropdown').on('change', function() {
            const selectedStatus = $(this).val(); // Get selected status
            const taskID = $('#status').attr('data-task-id'); // Get task ID

            // Make AJAX request to update status
            $.ajax({
                url: '{{ route('tasks.updateStatus') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                },
                data: {
                    task_id: taskID,
                    status: selectedStatus
                },
                success: function(response) {
                    if (response.success) {
                        // Update the badge with the new status
                        const statusText = getStatusText(selectedStatus);
                        const statusColor = getStatusColor(selectedStatus);

                        $('#status-text')
                            .text(statusText)
                            .css('background-color', statusColor)
                            .show();

                        // Update the data-status attribute
                        $('#status').attr('data-status', selectedStatus);

                        // Hide the dropdown
                        $('#status-dropdown').hide();

                        alert('Status updated successfully!');
                    } else {
                        alert('Failed to update status. Please try again.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText || error);
                    alert('An error occurred while updating the status.');
                }
            });
        });

        // Reset the view when clicking outside the badge or dropdown
        $(document).on('click', function(e) {
            const $statusText = $('#status-text');
            const $statusDropdown = $('#status-dropdown');
            const $statusCell = $('#status');
            const originalStatus = $statusCell.attr('data-status');

            if (!$(e.target).closest($statusText).length && !$(e.target).closest($statusDropdown)
                .length) {
                if ($statusDropdown.is(':visible')) {
                    // Revert to badge view
                    $statusText
                        .text(getStatusText(originalStatus))
                        .css('background-color', getStatusColor(originalStatus))
                        .show();

                    $statusDropdown.hide();
                }
            }
        });

        // Helper functions
        function getStatusText(value) {
            switch (value) {
                case '1':
                    return 'To Do';
                case '2':
                    return 'In Progress';
                case '3':
                    return 'Completed';
                default:
                    return '---';
            }
        }

        function getStatusColor(value) {
            switch (value) {
                case '1':
                    return 'blue';
                case '2':
                    return 'orange';
                case '3':
                    return 'green';
                default:
                    return 'red';
            }
        }
    });
</script>

<script>
    $(document).ready(function() {
        // Show the dropdown when the priority badge is clicked
        $('#priority-text').on('click', function() {
            const $priorityCell = $('#priority');
            const currentPriority = $priorityCell.attr('data-priority');

            // Hide the badge and show the dropdown
            $('#priority-text').hide();
            $('#priority-dropdown').val(currentPriority).show().focus();
        });

        // Handle dropdown change to update priority
        $('#priority-dropdown').on('change', function() {
            const selectedPriority = $(this).val(); // Get selected priority
            const taskID = $('#priority').attr('data-task-id'); // Get task ID

            // Make AJAX request to update priority
            $.ajax({
                url: '{{ route('tasks.updatePriority') }}', // Use the correct route or create a new one for priority
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Add CSRF token
                },
                data: {
                    task_id: taskID,
                    priority: selectedPriority // Pass selected priority
                },
                success: function(response) {
                    if (response.success) {
                        // Update the badge with the new priority
                        const priorityText = getPriorityText(selectedPriority);
                        const priorityColor = getPriorityColor(selectedPriority);

                        $('#priority-text')
                            .text(priorityText)
                            .css('background-color', priorityColor)
                            .show();

                        // Update the data-priority attribute
                        $('#priority').attr('data-priority', selectedPriority);

                        // Hide the dropdown
                        $('#priority-dropdown').hide();

                        alert('Priority updated successfully!');
                    } else {
                        alert('Failed to update priority. Please try again.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText || error);
                    alert('An error occurred while updating the priority.');
                }
            });
        });

        // Reset the view when clicking outside the badge or dropdown
        $(document).on('click', function(e) {
            const $priorityText = $('#priority-text');
            const $priorityDropdown = $('#priority-dropdown');
            const $priorityCell = $('#priority');
            const originalPriority = $priorityCell.attr('data-priority');

            if (!$(e.target).closest($priorityText).length && !$(e.target).closest($priorityDropdown)
                .length) {
                if ($priorityDropdown.is(':visible')) {
                    // Revert to badge view
                    $priorityText
                        .text(getPriorityText(originalPriority))
                        .css('background-color', getPriorityColor(originalPriority))
                        .show();

                    $priorityDropdown.hide();
                }
            }
        });

        // Helper functions
        function getPriorityText(value) {
            switch (value) {
                case '1':
                    return 'High';
                case '2':
                    return 'Medium';
                case '3':
                    return 'Low';
                default:
                    return '---';
            }
        }

        function getPriorityColor(value) {
            switch (value) {
                case '1':
                    return 'red';
                case '2':
                    return 'orange';
                case '3':
                    return 'blue';
                default:
                    return 'gray';
            }
        }
    });
</script>
