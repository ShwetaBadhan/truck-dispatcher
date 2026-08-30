<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Management\UserController;
use App\Http\Controllers\Management\PermissionController;
use App\Http\Controllers\Management\RoleController;
use App\Http\Controllers\Management\DriverController;
use App\Http\Controllers\Management\TruckController;
use App\Http\Controllers\Management\TrailerController;
use App\Http\Controllers\Management\CompanyController;
use App\Http\Controllers\Management\DispatchController;
use App\Http\Controllers\Management\SyllabusController;
use App\Http\Controllers\Management\BatchController;
use App\Http\Controllers\Management\StudentController;
use App\Http\Controllers\Management\DailyLectureController;
use App\Http\Controllers\DashboardController;

// Redirect root URL to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Show Login Form (GET)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Handle Login Submission (POST)
Route::post('/login', [LoginController::class, 'login']);

// Protected Dashboard Route (Requires Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout Route
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});


// Users list 
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); 


Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');


Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
Route::post('/roles/{role}/assign-permissions', [RoleController::class, 'assignPermissions'])->name('roles.assign-permissions');

Route::resource('drivers', DriverController::class);

// AJAX endpoints for cascading dropdowns
Route::get('/ajax/states/{countryId}', [DriverController::class, 'getStates'])->name('ajax.states');
Route::get('/ajax/cities/{stateId}', [DriverController::class, 'getCities'])->name('ajax.cities');

// Truck
Route::resource('trucks', TruckController::class);

// Trailer
Route::resource('trailers', TrailerController::class);

// Companies
Route::resource('companies', CompanyController::class);


Route::middleware(['auth'])->group(function () {
// dispatch
Route::resource('dispatches', DispatchController::class);
Route::get('dispatches/{dispatch}/invoice', [DispatchController::class, 'invoice'])->name('dispatches.invoice');
Route::resource('dispatches', DispatchController::class);
});

// syllabus
Route::resource('syllabuses', SyllabusController::class);

Route::middleware(['auth'])->group(function () {

    // Batches
    Route::get('batches', [BatchController::class, 'index'])->name('batches.index');
    Route::post('batches', [BatchController::class, 'store'])->name('batches.store');
    Route::put('batches/{batch}', [BatchController::class, 'update'])->name('batches.update');
    Route::delete('batches/{batch}', [BatchController::class, 'destroy'])->name('batches.destroy');

// Students
Route::get('students', [StudentController::class, 'index'])->name('students.index');
Route::get('students/register', [StudentController::class, 'create'])->name('students.create');
Route::post('students/register', [StudentController::class, 'store'])->name('students.store');
Route::get('students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('students/{student}', [StudentController::class, 'update'])->name('students.update');
Route::post('students/{student}/assign-batch', [StudentController::class, 'assignBatch'])->name('students.assign-batch');
Route::delete('students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');


    // Daily Lectures
    Route::get('lectures', [DailyLectureController::class, 'index'])->name('lectures.index');
    Route::get('lectures/create', [DailyLectureController::class, 'create'])->name('lectures.create');
    Route::post('lectures', [DailyLectureController::class, 'store'])->name('lectures.store');
    Route::get('lectures/{lecture}/edit', [DailyLectureController::class, 'edit'])->name('lectures.edit');
    Route::put('lectures/{lecture}', [DailyLectureController::class, 'update'])->name('lectures.update');
    Route::delete('lectures/{lecture}', [DailyLectureController::class, 'destroy'])->name('lectures.destroy');
});