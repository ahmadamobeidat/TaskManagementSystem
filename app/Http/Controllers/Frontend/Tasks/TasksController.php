<?php

namespace App\Http\Controllers\Frontend\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TasksController extends Controller
{

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
    // ======================= updateStatus Function ==========================
    // =========================Created By :Ahmad Abdulmonem Obeidat ==========
    // ========================================================================
    public function updateStatus(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'status' => 'required|in:1,2,3', // Validate status
        ]);

        try {
            $task = Task::findOrFail($request->task_id);
            $task->status = $request->status; // Save the new status
            $task->save();

            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status']);
        }
    }


    // ========================================================================
    // ======================= updatePriority Function ========================
    // =========================Created By :Ahmad Abdulmonem Obeidat ==========
    // ========================================================================
    public function updatePriority(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'priority' => 'required|in:1,2,3', // Validate priority values
        ]);

        try {
            $task = Task::findOrFail($request->task_id);
            $task->priority = $request->priority; // Update priority
            $task->save();

            return response()->json(['success' => true, 'message' => 'Priority updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update priority']);
        }
    }
}
