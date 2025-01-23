<?php

use App\Http\Controllers\Frontend\Auth\LoginController;
use App\Http\Controllers\Frontend\Auth\RegisterController;
use App\Http\Controllers\Frontend\Dashboard\DashboardController;
use App\Http\Controllers\Frontend\Home\HomePageController;
use App\Http\Controllers\Frontend\MyProfile\MyProfileController;
use App\Http\Controllers\Frontend\Tasks\TasksController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Pages
Route::get('/', [HomePageController::class, 'index'])->name('welcome');

// Authentication Routes
Route::get('register', [RegisterController::class, 'register'])->name('register');
Route::post('storeUser', [RegisterController::class, 'storeUser'])->name('storeUser');
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('userLoginRequest', [LoginController::class, 'userLoginRequest'])->name('userLoginRequest');

// Authenticated User Routes
Route::middleware(['auth.user'])->group(function () {
    // User Logout
    Route::post('/logout', [LoginController::class, 'userLogout'])->name('logout');

    // dashboard
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    });

    // myProfile routes
    Route::prefix('myProfile')->name('myProfile.')->group(function () {
        Route::get('/userProfile', [MyProfileController::class, 'userProfile'])->name('userProfile');
        Route::get('/editUserProfile', [MyProfileController::class, 'editUserProfile'])->name('editUserProfile');
        Route::put('updateProfile', [MyProfileController::class, 'updateUserProfile'])->name('updateProfile');
    });

    // Task Management Routes
    Route::prefix('tasks')->name('tasks.')->group(function () {

        // List all tasks (with pagination)
        Route::get('index', [TasksController::class, 'index'])->name('index');

        // update using ajax
        Route::post('/updateStatus', [TasksController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/updatePriority', [TasksController::class, 'updatePriority'])->name('updatePriority');

        // create and store
        Route::get('create', [TasksController::class, 'create'])->name('create');
        Route::post('store', [TasksController::class, 'store'])->name('store');

        // View a single task
        Route::get('show/{task}', [TasksController::class, 'show'])->name('show');

        // edit a single task , Update a task
        Route::get('edit/{task}', [TasksController::class, 'edit'])->name('edit');
        Route::put('update/{task}', [TasksController::class, 'update'])->name('update');

        // Delete a task
        Route::delete('destroy/{task}', [TasksController::class, 'destroy'])->name('destroy');

        // search
        Route::get('/search', [TasksController::class, 'search'])->name('search');
    });
});
