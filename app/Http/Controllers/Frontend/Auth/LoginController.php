<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{

    // Login Function
    public function login(Request $request)
    {
        try {
            // Check if the user is already authenticated
            if (Auth::guard('user')->check()) {
                // Redirect to the welcome page with a danger message
                return redirect()->route('welcome')->with('danger', 'You are already logged in');
            }

            // If not authenticated, show the login page
            return view('login');
        } catch (\Throwable $th) {
            // Log the error for debugging purposes
            Log::error('Login Error: ' . $th->getMessage());

            // Redirect to the welcome page with a generic error message
            return redirect()->route('welcome')->with('danger', 'Something went wrong.');
        }
    }

    // userLoginRequest Function
    public function userLoginRequest(Request $request)
    {
        // Validate the incoming request to ensure email and password are provided
        $request->validate([
            'email' => 'required|email', // Email must be a valid email address
            'password' => 'required|min:6', // Password must be at least 6 characters
        ]);

        // Extract email and password from the request
        $credentials = $request->only('email', 'password');

        // Attempt to log in the user using the provided credentials
        if (Auth::guard('user')->attempt($credentials)) {
            // Login successful, redirect to the intended page or welcome page
            return redirect()->intended(route('welcome'))->with('success', 'Signed in successfully');
        }

        // Login failed, redirect back with an error message (avoid exposing sensitive details)
        return redirect()->back()->withInput($request->only('email'))->withErrors(['email' => 'Please Check Your Credentials']);
    }

    // Logout Function
    public function userLogout()
    {
        // Check if the user is authenticated
        if (Auth::guard('user')->check()) {
            // Log out the user and invalidate the session
            Auth::guard('user')->logout();

            // Invalidate the session to clear any stored data
            session()->invalidate();

            // Regenerate the CSRF token for security
            session()->regenerateToken();

            // Redirect to the welcome page with a success message
            return redirect()->route('welcome')->with('success', 'You have successfully logged out');
        }

        // If the user is not authenticated, redirect to the welcome page with an error message
        return redirect()->route('welcome')->with('danger', 'You need to sign in first');
    }
}
