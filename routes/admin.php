<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\ApplicationsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CoursesController;
use App\Http\Controllers\Admin\EnrollmentsController;
use App\Http\Controllers\Admin\ReportsController;

/*
|--------------------------------------------------------------------------
| Admin routes
| Prefix  : /admin
| Name    : admin.*
| Guard   : auth + admin middleware
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Admin login (no auth middleware — this IS the login page)
|--------------------------------------------------------------------------
*/
Route::prefix('dfl-admin')
    ->name('admin.')
    ->group(function () {
        Route::get('login',  [AdminLoginController::class, 'showLogin'])->name('login');
        Route::post('login', [AdminLoginController::class, 'login'])->name('login.post');
        Route::post('logout',[AdminLoginController::class, 'logout'])->name('logout');
    });

/*
|--------------------------------------------------------------------------
| Admin panel (requires auth + is_admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        /*
         * Applications: backed by Enrollment + course_enrollment pivot.
         * PATCH body: courses[course_id]=accepted|rejected (and/or legacy course_id + decision).
         */
        Route::get('applications', [ApplicationsController::class, 'index'])->name('applications.index');
        Route::get('applications/{enrollment}', [ApplicationsController::class, 'show'])->name('applications.show');
        Route::patch('applications/{enrollment}', [ApplicationsController::class, 'update'])->name('applications.update');

        Route::get('enrollments', [EnrollmentsController::class, 'index'])->name('enrollments.index');

        Route::get('courses',                 [CoursesController::class, 'index'])  ->name('courses.index');
        Route::get('courses/create',          [CoursesController::class, 'create']) ->name('courses.create');
        Route::post('courses',                [CoursesController::class, 'store'])  ->name('courses.store');
        Route::get('courses/{course}/edit',   [CoursesController::class, 'edit'])   ->name('courses.edit');
        Route::put('courses/{course}',        [CoursesController::class, 'update']) ->name('courses.update');
        Route::delete('courses/{course}',     [CoursesController::class, 'destroy'])->name('courses.destroy');

        Route::get('reports',                 [ReportsController::class, 'index'])  ->name('reports.index');
        Route::get('reports/export',          [ReportsController::class, 'export']) ->name('reports.export');

        // Profile (stub)
        Route::get('profile',                fn () => abort(501, 'Coming soon'))->name('profile');

    });
