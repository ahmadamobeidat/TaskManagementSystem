<?php

namespace App\Http\Controllers\Frontend\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TasksController extends Controller
{

    // ========================================================================
    // ======================= index Function =================================
    // =========================Created By :Ahmad Abdulmonem Obeidat ==========
    // ========================================================================
    // public function index()
    // {
    //     try {
    //         // Get the authenticated user
    //         $user = Auth::guard('user')->user();

    //         if (!$user) {
    //             return redirect()->route('login')->with('danger', 'You must be logged in to view tasks.');
    //         }

    //         // Retrieve tasks belonging to the authenticated user with pagination
    //         $tasks = Task::where('user_id', '=', $user->id)->orderBy('due_date', 'asc')->paginate(10);

    //         // Pass tasks to the view
    //         return view('tasks.index', compact('tasks'));
    //     } catch (\Throwable $th) {
    //         // Log the error for debugging purposes
    //         Log::error('Error in TasksController@index: ' . $th->getMessage(), [
    //             'file' => $th->getFile(),
    //             'line' => $th->getLine(),
    //         ]);

    //         // Redirect to a generic error page with an error message
    //         return redirect()->route('welcome')->with('danger', 'Something went wrong. Please try again later.');
    //     }
    // }

    // ========================================================================
    // ======================= index Function =================================
    // =========================Created By :Ahmad Abdulmonem Obeidat ==========
    // ========================================================================
    public function index()
    {
        try {
            // Get the authenticated user
            $user = Auth::guard('user')->user();

            if (!$user) {
                return redirect()->route('login')->with('danger', 'You must be logged in to view tasks.');
            }

            // Cache key for the user's task list
            $cacheKey = "user.{$user->id}.tasks.list";

            // Retrieve tasks with caching
            $tasks = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($user) {
                return Task::where('user_id', '=', $user->id)->orderBy('due_date', 'asc')->paginate(10);
            });

            // Pass tasks to the view
            return view('tasks.index', compact('tasks'));
        } catch (\Throwable $th) {
            // Log the error for debugging purposes
            Log::error('Error in TasksController@index: ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            // Redirect to a generic error page with an error message
            return redirect()->route('welcome')->with('danger', 'Something went wrong. Please try again later.');
        }
    }

    // ========================================================================
    // ======================= Update Status Function =========================
    // ========================================================================
    // public function updateStatus(Request $request)
    // {
    //     // Validate the incoming request
    //     $request->validate([
    //         'task_id' => 'required|exists:tasks,id',
    //         'status' => 'required|in:1,2,3',
    //     ]);

    //     try {
    //         // Retrieve the task by ID
    //         $task = Task::findOrFail($request->task_id);

    //         // Ensure the authenticated user owns the task
    //         if ($task->user_id !== auth()->guard('user')->user()->id) {
    //             return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    //         }

    //         // Update the task's status
    //         $task->status = $request->status;
    //         $task->save();

    //         return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    //     } catch (\Exception $e) {
    //         return response()->json(['success' => false, 'message' => 'Failed to update status']);
    //     }
    // }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'status' => 'required|in:1,2,3',
        ]);

        try {
            $task = Task::findOrFail($request->task_id);

            if ($task->user_id !== auth()->guard('user')->user()->id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $task->status = $request->status;
            $task->save();

            // Clear the cache for the task list
            Cache::forget("user.{$task->user_id}.tasks.list");

            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status']);
        }
    }


    // ========================================================================
    // ======================= Update Priority Function =======================
    // ========================================================================
    // public function updatePriority(Request $request)
    // {
    //     $request->validate([
    //         'task_id' => 'required|exists:tasks,id',
    //         'priority' => 'required|in:1,2,3',
    //     ]);

    //     try {
    //         $task = Task::findOrFail($request->task_id);

    //         // Ensure only the authenticated user can modify their tasks
    //         if ($task->user_id !== auth()->guard('user')->user()->id) {
    //             return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    //         }

    //         $task->priority = $request->priority;
    //         $task->save();

    //         return response()->json(['success' => true, 'message' => 'Priority updated successfully']);
    //     } catch (\Exception $e) {
    //         return response()->json(['success' => false, 'message' => 'Failed to update priority']);
    //     }
    // }

    public function updatePriority(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'priority' => 'required|in:1,2,3',
        ]);

        try {
            $task = Task::findOrFail($request->task_id);

            if ($task->user_id !== auth()->guard('user')->user()->id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $task->priority = $request->priority;
            $task->save();

            // Clear the cache for the task list
            Cache::forget("user.{$task->user_id}.tasks.list");

            return response()->json(['success' => true, 'message' => 'Priority updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update priority']);
        }
    }


    // ========================================================================
    // ======================= Search Function ================================
    // ========================================================================
    // public function search(Request $request)
    // {
    //     try {
    //         // Retrieve search inputs
    //         $title = $request->input('title');
    //         $description = $request->input('description');
    //         $status = $request->input('status');
    //         $priority = $request->input('priority');
    //         $due_date = $request->input('due_date');

    //         // Ensure only authenticated users can access this method
    //         $user = Auth::guard('user')->user();
    //         if (!$user) {
    //             return redirect()->route('login')->with('danger', 'You must be logged in to perform this action.');
    //         }

    //         // Initialize task query for the authenticated user's tasks
    //         $taskQuery = Task::where('user_id', $user->id);

    //         // Filter by title
    //         if (!empty($title)) {
    //             $taskQuery->where('title', 'like', '%' . $title . '%');
    //         }

    //         // Filter by description
    //         if (!empty($description)) {
    //             $taskQuery->where('description', 'like', '%' . $description . '%');
    //         }

    //         // Filter by status
    //         if (!empty($status)) {
    //             $taskQuery->where('status', intval($status));
    //         }

    //         // Filter by priority
    //         if (!empty($priority)) {
    //             $taskQuery->where('priority', intval($priority));
    //         }

    //         // Filter by due date
    //         if (!empty($due_date)) {
    //             $taskQuery->whereDate('due_date', $due_date);
    //         }

    //         // Get the filtered tasks
    //         $tasks = $taskQuery->orderBy('due_date', 'desc')->paginate(10);

    //         // Prepare search values for the view
    //         $searchValues = [
    //             'title' => $title,
    //             'description' => $description,
    //             'priority' => $priority,
    //             'status' => $status,
    //             'due_date' => $due_date,
    //         ];

    //         return view('tasks.index', compact('searchValues', 'tasks'));
    //     } catch (\Throwable $th) {
    //         Log::error('Error in search function: ' . $th->getMessage());
    //         return redirect()->back()->with('danger', 'Something went wrong.');
    //     }
    // }

    public function search(Request $request)
    {
        try {
            $user = Auth::guard('user')->user();
            if (!$user) {
                return redirect()->route('login')->with('danger', 'You must be logged in to perform this action.');
            }

            $cacheKey = "user.{$user->id}.tasks.search." . md5(json_encode($request->all()));

            $tasks = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($user, $request) {
                $taskQuery = Task::where('user_id', $user->id);

                if (!empty($request->input('title'))) {
                    $taskQuery->where('title', 'like', '%' . $request->input('title') . '%');
                }
                if (!empty($request->input('description'))) {
                    $taskQuery->where('description', 'like', '%' . $request->input('description') . '%');
                }
                if (!empty($request->input('status'))) {
                    $taskQuery->where('status', intval($request->input('status')));
                }
                if (!empty($request->input('priority'))) {
                    $taskQuery->where('priority', intval($request->input('priority')));
                }
                if (!empty($request->input('due_date'))) {
                    $taskQuery->whereDate('due_date', $request->input('due_date'));
                }

                return $taskQuery->orderBy('due_date', 'desc')->paginate(10);
            });

            return view('tasks.index', compact('tasks'));
        } catch (\Throwable $th) {
            Log::error('Error in search function: ' . $th->getMessage());
            return redirect()->back()->with('danger', 'Something went wrong.');
        }
    }


    // ========================================================================
    // =========================== Store Function =============================
    // =========================Created By :Ahmad Abdulmonem Obeidat ==========
    // ========================================================================
    // public function store(Request $request)
    // {
    //     try {
    //         // Ensure only authenticated users can access this
    //         if (!auth()->guard('user')->check()) {
    //             return redirect()->route('login')->with('danger', 'You must be logged in to create a task.');
    //         }

    //         // Validate the request data
    //         $validated = $request->validate([
    //             'title' => 'required|string|max:255',
    //             'description' => 'required|string',
    //             'due_date' => 'required|date',
    //             'status' => 'required|in:1,2,3', //  1=To Do, 2=In Progress, 3=Completed
    //             'priority' => 'required|in:1,2,3', // 1=High, 2=Medium, 3=Low
    //         ]);

    //         // Add the authenticated user's ID to the task data
    //         $created_data = array_merge($validated, [
    //             'user_id' => auth()->guard('user')->user()->id,
    //         ]);

    //         // Use a database transaction to ensure data consistency
    //         DB::transaction(function () use ($created_data) {
    //             Task::create($created_data);
    //         });

    //         // Redirect to the tasks page with a success message
    //         return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    //     } catch (\Throwable $th) {
    //         // Log the error for debugging
    //         Log::error('Error in store method: ' . $th->getMessage(), [
    //             'file' => $th->getFile(),
    //             'line' => $th->getLine(),
    //         ]);

    //         // Redirect back with a generic error message
    //         return redirect()->back()->with('danger', 'Something went wrong. Please try again.');
    //     }
    // }

    public function store(Request $request)
    {
        try {
            if (!auth()->guard('user')->check()) {
                return redirect()->route('login')->with('danger', 'You must be logged in to create a task.');
            }

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'due_date' => 'required|date',
                'status' => 'required|in:1,2,3',
                'priority' => 'required|in:1,2,3',
            ]);

            $user = auth()->guard('user')->user();
            $taskData = array_merge($validated, ['user_id' => $user->id]);

            DB::transaction(function () use ($taskData, $user) {
                Task::create($taskData);

                // Clear the cache for the task list
                Cache::forget("user.{$user->id}.tasks.list");
            });

            return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
        } catch (\Throwable $th) {
            Log::error('Error in store method: ' . $th->getMessage(), ['file' => $th->getFile(), 'line' => $th->getLine()]);
            return redirect()->back()->with('danger', 'Something went wrong. Please try again.');
        }
    }


    // ========================================================================
    // ======================= create Function ================================
    // =========================Created By :Ahmad Abdulmonem Obeidat ==========
    // ========================================================================
    public function create()
    {
        try {

            // Ensure only authenticated users can access this
            if (!auth()->guard('user')->check()) {
                return redirect()->route('login')->with('danger', 'You must be logged in to create a task.');
            }
            // Get the authenticated user
            return view('tasks.create');
        } catch (\Throwable $th) {
            // Log the error for debugging purposes
            Log::error('Error in TasksController@index: ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            // Redirect to a generic error page with an error message
            return redirect()->route('welcome')->with('danger', 'Something went wrong. Please try again later.');
        }
    }

    // ========================================================================
    // ==================== destroy Function ==================================
    // =========================Created By :Ahmad Abdulmonem Obeidat ==========
    // ========================================================================
    // public function destroy($id, Route $route)
    // {
    //     try {
    //         // Find the lead transaction by ID

    //         // Get the authenticated user
    //         $user = Auth::guard('user')->user();

    //         if (!$user) {
    //             return redirect()->route('login')->with('danger', 'You must be logged in to view tasks.');
    //         }

    //         $task = Task::find($id);

    //         // Ensure only the authenticated user can modify their tasks
    //         if ($task->user_id !== auth()->guard('user')->user()->id) {
    //             return redirect()->back()->with('danger', 'This record is not yours to manuipulate.');
    //         }

    //         if ($task) {
    //             // Finally, delete the lead transaction
    //             $task->delete();

    //             return redirect()->back()->with('success', 'Deleted Successfully');
    //         } else {
    //             return redirect()->back()->with('danger', 'This record does not exist in the records');
    //         }
    //     } catch (\Throwable $th) {
    //         // Log the error for debugging purposes
    //         Log::error('Error in TasksController@index: ' . $th->getMessage(), [
    //             'file' => $th->getFile(),
    //             'line' => $th->getLine(),
    //         ]);

    //         // Redirect to a generic error page with an error message
    //         return redirect()->route('welcome')->with('danger', 'Something went wrong. Please try again later.');
    //     }
    // }
    public function destroy($id)
    {
        try {
            $user = Auth::guard('user')->user();

            if (!$user) {
                return redirect()->route('login')->with('danger', 'You must be logged in to delete tasks.');
            }

            $task = Task::find($id);

            if (!$task || $task->user_id !== $user->id) {
                return redirect()->back()->with('danger', 'This task does not belong to you.');
            }

            $task->delete();

            // Clear the cache for the task list
            Cache::forget("user.{$user->id}.tasks.list");

            return redirect()->back()->with('success', 'Task deleted successfully.');
        } catch (\Throwable $th) {
            Log::error('Error in destroy function: ' . $th->getMessage());
            return redirect()->route('welcome')->with('danger', 'Something went wrong. Please try again later.');
        }
    }


    // ========================================================================
    // ==================== show Function =====================================
    // =========================Created By :Ahmad Abdulmonem Obeidat ==========
    // ========================================================================
    public function show(Task $task)
    {
        try {
            // Ensure the authenticated user owns the task
            if ($task->user_id !== auth()->guard('user')->user()->id) {
                abort(403, 'Unauthorized access to this task.');
            }

            $user = Auth::guard('user')->user();


            $cacheKey = "user.{$user->id}.task.{$task->id}";

            $cachedTask = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($task) {
                return $task;
            });

            // Return the task details view with the task data
            return view('tasks.show', compact('task'));
        } catch (\Throwable $th) {
            // Log the error for debugging
            Log::error('Error in show function: ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            // Return a 500 error response
            abort(500, 'Something went wrong. Please try again later.');
        }
    }

    // ========================================================================
    // ==================== edit Function =====================================
    // =========================Created By :Ahmad Abdulmonem Obeidat ==========
    // ========================================================================
    public function edit(Task $task)
    {
        try {

            $user = Auth::guard('user')->user();

            // Ensure the authenticated user owns the task
            if ($task->user_id !== auth()->guard('user')->user()->id) {
                abort(403, 'Unauthorized access to edit this task.');
            }


            $cacheKey = "user.{$user->id}.task.edit.{$task->id}";

            $cachedTask = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($task) {
                return $task;
            });

            // Return the edit view with the task data
            return view('tasks.edit', compact('task'));
        } catch (\Throwable $th) {
            // Log the error for debugging
            Log::error('Error in edit function: ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            // Return a 500 error response
            abort(500, 'Something went wrong. Please try again later.');
        }
    }

    // ========================================================================
    // ==================== edit Function =====================================
    // =========================Created By :Ahmad Abdulmonem Obeidat ==========
    // ========================================================================
    public function update(Request $request, Task $task)
    {
        try {
            // Ensure the authenticated user owns the task
            if ($task->user_id !== auth()->guard('user')->id()) {
                abort(403, 'Unauthorized access to update this task.');
            }

            // Validate the request data
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'priority' => 'required|in:1,2,3', // 1: High, 2: Medium, 3: Low
                'status' => 'required|in:1,2,3', // 1: To Do, 2: In Progress, 3: Completed
                'due_date' => 'required|date',
            ]);

            // Update the task with validated data
            $task->update($validatedData);

            // Redirect to the tasks index with a success message
            return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
        } catch (\Throwable $th) {
            // Log the error for debugging
            Log::error('Error in update function: ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            // Redirect back with a generic error message
            return redirect()->back()->with('danger', 'Something went wrong. Please try again.');
        }
    }
}
