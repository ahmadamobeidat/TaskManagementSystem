<?php

namespace App\Http\Controllers\Frontend\MyProfile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\UpdateUserFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class MyProfileController extends Controller
{
    // ========================================================================
    // =========================== userProfile Function =======================
    // =========================Created By :Ahmad Abdulmonem Obeidat ==========
    // ========================================================================
    public function userProfile(Request $request)
    {
        try {
            // Get the authenticated user
            $user = Auth::guard('user')->user();

            // Pass user data to the profile view
            return view('myProfile.myprofile', compact('user'));
        } catch (\Throwable $th) {
            // Log the error for debugging purposes
            Log::error('Error in userProfile Function: ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            // Redirect to a generic error page with an error message
            return redirect()->route('welcome')->with('danger', 'Something went wrong. Please try again later.');
        }
    }

    // ========================================================================
    // =========================== editUserProfile Function ===================
    // =========================Created By :Ahmad Abdulmonem Obeidat ==========
    // ========================================================================
    public function editUserProfile(Request $request)
    {
        try {

            // Get the authenticated user
            $user = Auth::guard('user')->user();

            // Pass user data to the profile view
            return view('myProfile.edit_myprofile', compact('user'));
        } catch (\Throwable $th) {
            // Log the error for debugging purposes
            Log::error('Error in userProfile Function: ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            // Redirect to a generic error page with an error message
            return redirect()->route('welcome')->with('danger', 'Something went wrong. Please try again later.');
        }
    }

    // ========================================================================
    // =========================== updateUserProfile Function =================
    // =========================Created By :Ahmad Abdulmonem Obeidat ==========
    // ========================================================================
    public function updateUserProfile(UpdateUserFormRequest $request)
    {
        try {
            // Get the authenticated user
            $user = Auth::guard('user')->user();

            if ($user instanceof \App\Models\User) {
                // Prepare data for updating
                $updated_data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'date_of_birth' => $request->date_of_birth,
                ];

                // Update the password if provided
                if ($request->filled('password')) {
                    $updated_data['password'] = Hash::make($request->password);
                }

                // Update user data in the database
                $user->update($updated_data);

                // Redirect back with success message
                return redirect()->route('myProfile.userProfile')->with('success', 'Profile updated successfully!');
            } else {
                // User not found, redirect with error message
                return redirect()->route('myProfile.userProfile')->with('danger', 'User not found. Please contact support.');
            }
        } catch (\Throwable $th) {
            // Log the error for debugging purposes
            Log::error('Error updating user profile', [
                'user_id' => $user->id ?? null,
                'error' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            // Redirect to a generic error page with an error message
            return redirect()->route('welcome')->with('danger', 'Something went wrong. Please try again later.');
        }
    }
}
