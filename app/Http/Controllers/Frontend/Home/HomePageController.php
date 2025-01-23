<?php

namespace App\Http\Controllers\Frontend\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Log;

class HomePageController extends Controller
{
    // ========================================================================
    // =========================== index Function =============================
    // =========================Created By :Ahmad Abdulmonem Obeidat ==========
    // ========================================================================
    public function index(Request $request)
    {
        try {
            // Render the welcome page view
            return view('welcome');
        } catch (\Throwable $th) {
            // Log the error for debugging purposes
            Log::error('Error in Index Function: ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            // Redirect to a generic error page with an error message
            return redirect()->route('welcome')->with('danger', 'Something went wrong. Please try again later.');
        }
    }
}
