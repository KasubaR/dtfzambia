<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Models\Course;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $courses = Course::active()->get();
    return view('public.home', compact('courses'));
})->name('home');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');

// About — public
Route::get('/about', fn () => view('public.about'))->name('about');

// Enrollment — public, no account required
Route::get('/enrollment',              [EnrollmentController::class, 'create'])->name('enrollment.create');
Route::post('/enrollment',             [EnrollmentController::class, 'store'])->name('enrollment.store');
Route::get('/enrollment/success/{id}', [EnrollmentController::class, 'success'])->name('enrollment.success');

/*
|--------------------------------------------------------------------------
| Auth routes (admin staff login only — no public registration)
|--------------------------------------------------------------------------
*/

Route::get('/login',   fn () => view('auth.login'))->name('login');
Route::post('/login',  [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
