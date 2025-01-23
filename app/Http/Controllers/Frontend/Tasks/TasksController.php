<?php

namespace App\Http\Controllers\Frontend\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TasksController extends Controller
{

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

            // Retrieve tasks belonging to the authenticated user with pagination
            $tasks = Task::where('user_id', '=', $user->id)->orderBy('due_date', 'asc')->paginate(10);

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
    public function updateStatus(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'status' => 'required|in:1,2,3',
        ]);

        try {
            // Retrieve the task by ID
            $task = Task::findOrFail($request->task_id);

            // Ensure the authenticated user owns the task
            if ($task->user_id !== auth()->guard('user')->user()->id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            // Update the task's status
            $task->status = $request->status;
            $task->save();

            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status']);
        }
    }

    // ========================================================================
    // ======================= Update Priority Function =======================
    // ========================================================================
    public function updatePriority(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'priority' => 'required|in:1,2,3',
        ]);

        try {
            $task = Task::findOrFail($request->task_id);

            // Ensure only the authenticated user can modify their tasks
            if ($task->user_id !== auth()->guard('user')->user()->id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $task->priority = $request->priority;
            $task->save();

            return response()->json(['success' => true, 'message' => 'Priority updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update priority']);
        }
    }

    // ========================================================================
    // ======================= Search Function ================================
    // ========================================================================
    public function search(Request $request)
    {
        try {
            // Retrieve search inputs
            $title = $request->input('title');
            $description = $request->input('description');
            $status = $request->input('status');
            $priority = $request->input('priority');
            $due_date = $request->input('due_date');

            // Ensure only authenticated users can access this method
            $user = Auth::guard('user')->user();
            if (!$user) {
                return redirect()->route('login')->with('danger', 'You must be logged in to perform this action.');
            }

            // Initialize task query for the authenticated user's tasks
            $taskQuery = Task::where('user_id', $user->id);

            // Filter by title
            if (!empty($title)) {
                $taskQuery->where('title', 'like', '%' . $title . '%');
            }

            // Filter by description
            if (!empty($description)) {
                $taskQuery->where('description', 'like', '%' . $description . '%');
            }

            // Filter by status
            if (!empty($status)) {
                $taskQuery->where('status', intval($status));
            }

            // Filter by priority
            if (!empty($priority)) {
                $taskQuery->where('priority', intval($priority));
            }

            // Filter by due date
            if (!empty($due_date)) {
                $taskQuery->whereDate('due_date', $due_date);
            }

            // Get the filtered tasks
            $tasks = $taskQuery->orderBy('due_date', 'desc')->paginate(10);

            // Prepare search values for the view
            $searchValues = [
                'title' => $title,
                'description' => $description,
                'priority' => $priority,
                'status' => $status,
                'due_date' => $due_date,
            ];

            return view('tasks.index', compact('searchValues', 'tasks'));
        } catch (\Throwable $th) {
            Log::error('Error in search function: ' . $th->getMessage());
            return redirect()->back()->with('danger', 'Something went wrong.');
        }
    }

    // ========================================================================
    // =========================== Store Function =============================
    // =========================Created By :Ahmad Abdulmonem Obeidat ==========
    // ========================================================================
    public function store(Request $request)
    {
        try {
            // Ensure only authenticated users can access this
            if (!auth()->guard('user')->check()) {
                return redirect()->route('login')->with('danger', 'You must be logged in to create a task.');
            }

            // Validate the request data
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'required|date',
                'status' => 'required|in:1,2,3', // Assuming 1=To Do, 2=In Progress, 3=Completed
                'priority' => 'required|in:1,2,3', // Assuming 1=High, 2=Medium, 3=Low
            ]);

            // Add the authenticated user's ID to the task data
            $created_data = array_merge($validated, [
                'user_id' => auth()->guard('user')->user()->id,
            ]);

            // Use a database transaction to ensure data consistency
            DB::transaction(function () use ($created_data) {
                Task::create($created_data);
            });

            // Redirect to the tasks page with a success message
            return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
        } catch (\Throwable $th) {
            // Log the error for debugging
            Log::error('Error in store method: ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            // Redirect back with a generic error message
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
    // ==================== Delete Other Attachments Function =================
    // =========================Created By :Ahmad Abdulmonem Obeidat ==========
    // ========================================================================
    public function destroy($id, Route $route)
    {
        try {
            // Find the lead transaction by ID

            // Get the authenticated user
            $user = Auth::guard('user')->user();

            if (!$user) {
                return redirect()->route('login')->with('danger', 'You must be logged in to view tasks.');
            }

            $task = Task::find($id);

            // Ensure only the authenticated user can modify their tasks
            if ($task->user_id !== auth()->guard('user')->user()->id) {
                return redirect()->back()->with('danger', 'This record is not yours to manuipulate.');
            }

            if ($task) {
                // Finally, delete the lead transaction
                $task->delete();

                return redirect()->back()->with('success', 'Deleted Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
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
}
