<?php

namespace App\Http\Controllers\Frontend\MyProfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}
