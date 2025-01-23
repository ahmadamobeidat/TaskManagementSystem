<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\StoreUserFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    // ========================================================================
    // =========================== register Function ==========================
    // =========================Created By :Ahmad Abdulmonem Obeidat ==========
    // ========================================================================
    public function register(Request $request)
    {
        try {
            // Check if the user is already authenticated
            if (Auth::guard('user')->check()) {
                return redirect()->route('welcome')->with('danger', 'You are already logged in');
            }

            // If not authenticated, show the register page
            return view('register');
        } catch (\Throwable $th) {
            // Log the error for debugging
            Log::error('Error in Register Function: ' . $th->getMessage());

            // Redirect to the welcome page with a generic error message
            return redirect()->route('welcome')->with('danger', 'Something went wrong.');
        }
    }



    // ========================================================================
    // =========================== Store Function =============================
    // =========================Created By :Ahmad Abdulmonem Obeidat ==========
    // ========================================================================
    public function storeUser(StoreUserFormRequest $request)
    {
        try {
            // Prepare data for user creation
            $created_data = [
                'name' => $request->name,
                'date_of_birth' => $request->date_of_birth,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Securely hash the password
            ];

            // Use a database transaction to ensure data consistency
            DB::transaction(function () use ($created_data) {
                User::create($created_data);
            });

            // Attempt to log in the user after successful registration
            if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('welcome')->with('success', 'Thanks for joining us!');
            }

            // Redirect to the welcome page with a success message
            return redirect()->route('welcome')->with('success', 'Thanks for joining us!');
        } catch (\Throwable $th) {
            // Log the error for debugging
            Log::error('Error in StoreUser Function: ' . $th->getMessage());

            // Redirect back with a generic error message
            return redirect()->back()->with('danger', 'Something went wrong. Please try again.');
        }
    }
}
