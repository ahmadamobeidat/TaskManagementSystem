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
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        id="title" value="{{ $searchValues['title'] ?? '' }}" placeholder="Title">
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
                    <input type="date" name="due_date" id="due_date"
                        class="form-control @error('due_date') is-invalid @enderror"
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
                                <span class="status-text badge"
                                    style="cursor: pointer; background-color: {{ $task->status == 'Completed' ? 'green' : ($task->status == 'To Do' ? 'blue' : ($task->status == 'In Progress' ? 'orange' : 'red')) }}; color: white;">
                                    {{ $task->status ?? '---' }}
                                </span>

                                <!-- Status dropdown (hidden by default) -->
                                <select class="status-dropdown form-select form-select-sm"
                                    style="display:none; width: auto;">
                                    <option value="1" {{ $task->status == 'To Do' ? 'selected' : '' }}>To Do</option>
                                    <option value="2" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In
                                        Progress</option>
                                    <option value="3" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed
                                    </option>
                                </select>
                            </td>

                            {{-- priority --}}
                            <td id="priority" data-task-id="{{ $task->id }}" data-priority="{{ $task->priority }}"
                                class="text-center">
                                <!-- Priority Badge -->
                                <span class="priority-text badge"
                                    style="cursor: pointer; background-color: {{ $task->priority == 'High' ? 'red' : ($task->priority == 'Medium' ? 'orange' : 'blue') }}; color: white;">
                                    {{ $task->priority ?? '---' }}
                                </span>

                                <!-- Priority dropdown (hidden by default) -->
                                <select class="priority-dropdown form-select form-select-sm"
                                    style="display:none; width: auto;">
                                    <option value="1" {{ $task->priority == 'High' ? 'selected' : '' }}>High</option>
                                    <option value="2" {{ $task->priority == 'Medium' ? 'selected' : '' }}>Medium
                                    </option>
                                    <option value="3" {{ $task->priority == 'Low' ? 'selected' : '' }}>Low</option>
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
                                    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-success"
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

{{-- status --}}
<script>
    $(document).ready(function() {
        // Show the dropdown when the status badge is clicked
        $(document).on('click', '.status-text', function() {
            const $statusCell = $(this).closest(
                'td'); // Get the closest <td> containing the data-task-id
            const taskID = $statusCell.data(
                'task-id'); // Retrieve the task ID from the data-task-id attribute

            if (!taskID) {
                alert('Task ID is missing!');
                return;
            }

            const currentStatus = $statusCell.attr('data-status');

            // Hide the badge and show the dropdown
            $statusCell.find('.status-text').hide();
            $statusCell.find('.status-dropdown').val(currentStatus).show().focus();
        });

        // Handle dropdown change to update status
        $(document).on('change', '.status-dropdown', function() {
            const $statusCell = $(this).closest('td'); // Get the closest <td>
            const taskID = $statusCell.data('task-id'); // Retrieve the task ID
            const selectedStatus = $(this).val(); // Get the selected status value

            if (!taskID) {
                alert('Task ID is missing!');
                return;
            }

            // Make AJAX request to update status
            $.ajax({
                url: '{{ route('tasks.updateStatus') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                },
                data: {
                    task_id: taskID, // Pass the task ID
                    status: selectedStatus // Pass the selected status
                },
                success: function(response) {
                    if (response.success) {
                        const statusText = getStatusText(selectedStatus);
                        const statusColor = getStatusColor(selectedStatus);

                        // Update the badge with the new status
                        $statusCell
                            .attr('data-status',
                                selectedStatus) // Update the data-status attribute
                            .find('.status-text')
                            .text(statusText) // Update text
                            .css('background-color', statusColor)
                            .show();

                        $statusCell.find('.status-dropdown').hide();

                        alert('Status updated successfully!');

                        // Remove the task row if it no longer matches search criteria
                        const currentSearchStatus = $('#status')
                            .val(); // Get the searched status
                        if (currentSearchStatus && currentSearchStatus !== selectedStatus) {
                            $statusCell.closest('tr').remove(); // Remove the task row
                        }
                    } else {
                        alert(response.message || 'Failed to update status.');
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    alert(xhr.responseJSON?.message ||
                        'An error occurred while updating the status.');
                }
            });
        });

        // Reset the view when clicking outside
        $(document).on('click', function(e) {
            const $dropdown = $('.status-dropdown:visible'); // Find visible dropdown
            if ($dropdown.length && !$(e.target).closest($dropdown).length && !$(e.target).closest(
                    '.status-text').length) {
                const $statusCell = $dropdown.closest('td'); // Get the associated <td>
                const originalStatus = $statusCell.attr('data-status'); // Get original status

                // Revert back to badge view
                $statusCell.find('.status-text')
                    .text(getStatusText(originalStatus)) // Reset the text
                    .css('background-color', getStatusColor(originalStatus)) // Reset the color
                    .show();

                $dropdown.hide(); // Hide the dropdown
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
                    return 'gray';
            }
        }
    });
</script>

{{-- priority --}}
<script>
    $(document).ready(function() {
        // Show the dropdown when the priority badge is clicked
        $(document).on('click', '.priority-text', function() {
            const $priorityCell = $(this).closest('td'); // Get the closest <td> with priority details
            const currentPriority = $priorityCell.attr('data-priority'); // Get the current priority
            const taskID = $priorityCell.data('task-id'); // Get the task ID

            if (!taskID) {
                alert('Task ID is missing!');
                return;
            }

            // Hide the badge and show the dropdown
            $priorityCell.find('.priority-text').hide();
            $priorityCell.find('.priority-dropdown').val(currentPriority).show().focus();
        });

        // Handle dropdown change to update priority
        $(document).on('change', '.priority-dropdown', function() {
            const $priorityCell = $(this).closest('td'); // Get the closest <td>
            const taskID = $priorityCell.data('task-id'); // Retrieve the task ID
            const selectedPriority = $(this).val(); // Get selected priority value

            if (!taskID) {
                alert('Task ID is missing!');
                return;
            }

            // Make AJAX request to update priority
            $.ajax({
                url: '{{ route('tasks.updatePriority') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                },
                data: {
                    task_id: taskID, // Pass the task ID
                    priority: selectedPriority // Pass the selected priority
                },
                success: function(response) {
                    if (response.success) {
                        const priorityText = getPriorityText(selectedPriority);
                        const priorityColor = getPriorityColor(selectedPriority);

                        // Update the badge with the new priority
                        $priorityCell
                            .attr('data-priority',
                                selectedPriority) // Update the data-priority attribute
                            .find('.priority-text')
                            .text(priorityText) // Update the text
                            .css('background-color', priorityColor) // Update the color
                            .show();

                        // Hide the dropdown
                        $priorityCell.find('.priority-dropdown').hide();

                        alert('Priority updated successfully!');

                        // Remove the row if the updated priority doesn't match the filter
                        const currentSearchPriority = $('#priority')
                            .val(); // Get the searched priority
                        if (currentSearchPriority && currentSearchPriority !==
                            selectedPriority) {
                            $priorityCell.closest('tr').remove(); // Remove the task row
                        }
                    } else {
                        alert(response.message || 'Failed to update priority.');
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText || xhr.statusText);
                    alert(xhr.responseJSON?.message ||
                        'An error occurred while updating the priority.');
                }
            });
        });

        // Hide the dropdown and reset view when clicking outside
        $(document).on('click', function(e) {
            const $dropdown = $('.priority-dropdown:visible'); // Find visible dropdown
            if ($dropdown.length && !$(e.target).closest($dropdown).length && !$(e.target).closest(
                    '.priority-text').length) {
                const $priorityCell = $dropdown.closest('td'); // Get the associated <td>
                const originalPriority = $priorityCell.attr('data-priority'); // Get original priority

                // Revert back to badge view
                $priorityCell.find('.priority-text')
                    .text(getPriorityText(originalPriority)) // Reset the text
                    .css('background-color', getPriorityColor(originalPriority)) // Reset the color
                    .show();

                $dropdown.hide(); // Hide the dropdown
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
