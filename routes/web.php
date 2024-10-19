<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthenticatedSessionController;

use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', function () {
    return view('welcome');
});

// Redirect authenticated users to their dashboards based on their role
Route::get('/dashboard', function () {
    // This will be handled by the custom logic in AuthenticatedSessionController
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Doctor routes
Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
});

// Patient routes
Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/patient/book', [PatientController::class, 'showSlots'])->name('patient.book');
    Route::post('/patient/book', [PatientController::class, 'bookAppointment']);
});

Route::post('/book-appointment', [PatientController::class, 'bookAppointment'])->name('book-appointment');
// Route for showing available slots
Route::get('/show-slots', [PatientController::class, 'showSlots'])->name('show-slots');



Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


// Include authentication routes (login, register, etc.)
require __DIR__.'/auth.php';


