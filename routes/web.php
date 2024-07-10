<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupermanagerController;
use Illuminate\Database\Capsule\Manager;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\RegisterController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile/index', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');

Route::post('updateinfo', [App\Http\Controllers\ProfileController::class, 'updateinfo'])->name('updateinfo');

Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'adminhome'])->name('admin.home')->middleware('is_admin');
Route::get('/presence', [App\Http\Controllers\HomeController::class, 'markPresence'])->name('mark.presence');


Route::get('/demande-retard', [App\Http\Controllers\HomeController::class, 'requestDelay'])->name('request.delay');






Route::post('/submit-delay-request', [HomeController::class, 'submitDelayRequest'])->name('submit.delay.request');









Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/presence', [AdminController::class, 'presence'])->name('admin.presence');
    Route::get('/absence-requests', [AdminController::class, 'absenceRequests'])->name('admin.absence.requests');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');

    Route::get('/presence', [AdminController::class, 'presence'])->name('admin.presence');


    Route::post('/submit-presence-form', [AdminController::class, 'submitPresenceForm'])->name('submit.presence.form');

    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/reports/search', [AdminController::class, 'searchReports'])->name('admin.reports.search');


    Route::get('/reports/{userId?}', [AdminController::class, 'reports'])->name('admin.reports');

    Route::get('/reports/search', [AdminController::class, 'search'])->name('admin.reports.search');

    Route::post('/admin/add-user-to-liste-p/{userId}', [AdminController::class, 'addUserToListeP'])
    ->name('admin.add.user.to.liste_p');

    Route::delete('/admin/remove-delay-request/{id}', [AdminController::class, 'removeDelayRequest'])->name('admin.remove.delay.request');



});

Route::post('/confirm_roles', [AdminController::class, 'confirmRoles'])->name('confirm_roles');


Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');

Route::get('/manager/dashboard/search', [ManagerController::class, 'search'])->name('manager.dashboard.search');
Route::get('/manager/dashboard/search', [managerController::class, 'searchdate'])->name('manager.dashboard.search');



Route::get('/super-manager/dashboard', [SupermanagerController::class, 'dashboard'])->name('super-manager.dashboard');
Route::get('/super-manager/dashboard/search', [ManagerController::class, 'search'])->name('super-manager.dashboard.search');
Route::get('/super-manager/dashboard/search', [SupermanagerController::class, 'searchdate'])->name('super-manager.dashboard.search');


Route::post('/submit-report', [ReportController::class, 'submit'])->name('submit.report');







