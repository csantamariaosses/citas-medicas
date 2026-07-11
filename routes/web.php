<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorAdminController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\BloodTypeController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\SpecialityController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserHorasMedicasController;

Route::get('/', function () {
    //return view('welcome');
    $version = app()->version();
    $versionPhp = phpversion();
    //dd($versionPhp);
    session(['php_version' => $versionPhp]);
    session(['laravel_version' => $version]);

    return view('index');
});

Route::resource('productos', ProductoController::class);
//Route::resource('users', UserController::class);

//Administración de usuarios

Route::get('admin.index', [AdminController::class, "index"])->name("admin.index");

/*
Route::middleware(['admin'])->group(function () {
    Route::resource('roles', RoleController::class);
    //Route::get('/admin/dashboard', [AdminController::class, 'index']);
    // Otras rutas protegidas para administradores...
});
*/

//Route::resource('roles', RoleController::class);

Route::prefix('admin')->group(function () {
    
    Route::resource('roles', RoleController::class)->middleware('admin');
    Route::resource('permissions', PermissionController::class)->middleware('admin');
    Route::resource('users', UsersController::class)->middleware('admin');
    //Route::resource('users', [UsersController::class, 'index'])->name('admin.users.index');
    Route::resource('patients', PatientController::class)->only(['index', 'show', 'edit', 'update','create', 'store','destroy'])->middleware('admin');
    Route::resource('bloodTypes', BloodTypeController::class)->middleware('admin');
    Route::resource('specialities', SpecialityController::class)->middleware('admin');
    Route::resource('doctores', DoctorController::class)->only(['index', 'create','store','show', 'edit', 'update','destroy'])->middleware('admin');
    Route::resource('appointments', AppointmentController::class)->middleware('auth');
    Route::get('appointments/consultation/{id}', [AppointmentController::class,'consultation'] )->name('appointments.consultation')->middleware('auth');
    Route::get('dashboard', [AppointmentController::class,'dashboard'] )->name('dashboard')->middleware('auth');

    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('calendartest', [CalendarController::class, 'test'])->name('calendar.test');

    Route::get('agendadoc', [AppointmentController::class,'agendadoc'] )->name('agendadoc')->middleware('admin');
    Route::post('agendadoc.especialidad', [AppointmentController::class,'especialidad'] )->name('agendadoc.especialidad')->middleware('admin');
    Route::post('agendadoc.doctors', [AppointmentController::class,'doctors'] )->name('agendadoc.doctors')->middleware('admin');
    Route::post('agendadoc.showcalendar', [AppointmentController::class,'showcalendar'] )->name('agendadoc.showcalendar')->middleware('admin');
    Route::post('agendadoc.confirmar', [AppointmentController::class,'confirmar'] )->name('agendadoc.confirmar')->middleware('admin');
    Route::get('agendadocfull', [AppointmentController::class,'agendadocfull'] )->name('agendadocfull')->middleware('admin');
});

Route::get('doctores/{doctor}/schedules', [DoctorController::class, 'schedules'])->name('doctores.schedules');

Route::get('/prueba', function () {
    $schedule = \App\Models\Schedule::all();    
    //dd($schedule);
});

Route::post("prueba.testSave", [AppointmentController::class, 'testSave'])->name('prueba.testSave');

//Route::resource('/appointments', AppointmentController::class);

/*
Route::get('agendadoc', [AppointmentController::class,'agendadoc'] )->name('agendadoc');
Route::post('agendadoc.especialidad', [AppointmentController::class,'especialidad'] )->name('agendadoc.especialidad');
Route::post('agendadoc.doctors', [AppointmentController::class,'doctors'] )->name('agendadoc.doctors');
Route::post('agendadoc.showcalendar', [AppointmentController::class,'showcalendar'] )->name('agendadoc.showcalendar');
Route::post('agendadoc.confirmar', [AppointmentController::class,'confirmar'] )->name('agendadoc.confirmar');
*/
//Route::get('login', [AuthenticatedSessionController::class, "create"])->name("login");

//Route::resource('/appointments', AppointmentController::class);

#include auth routes
//require __DIR__.'/auth.php';

Route::get('login', [AuthController::class, "showLoginForm"])->name("login");
Route::post('login', [AuthController::class, "login"]);
Route::post('logout', [AuthController::class, "logout"])->name("logout");
Route::get('register', [AuthController::class, "register"])->name("register");
Route::post('register', [AuthController::class, "register"])->name("register");


Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');  


Route::get('/horasmedicas', [UserHorasMedicasController::class, 'index'])->name('horasmedicas.index')->middleware('auth');
Route::post('/horasmedicas.doctores', [UserHorasMedicasController::class, 'doctores'])->name('horasmedicas.doctores')->middleware('auth');
Route::post('/horasmedicas.showcalendar', [UserHorasMedicasController::class, 'showcalendar'])->name('horasmedicas.showcalendar')->middleware('auth');
Route::post('/horasmedicas.confirmar', [UserHorasMedicasController::class,'confirmar'] )->name('horasmedicas.confirmar');
Route::post('/horasmedicas.cancelar', [UserHorasMedicasController::class,'cancelar'] )->name('horasmedicas.cancelar');
//Route::get('login', [LoginController::class, "login"])->name("login");
Route::get('/horasmedicas.listar', [UserHorasMedicasController::class, 'listhorasagendadas'])->name('horasmedicas.listar')->middleware('auth');


Route::get('doctor', [DoctorAdminController::class, 'index'])->name('doctor.index');
Route::get('doctor/create', [DoctorAdminController::class, 'create'])->name('doctor.create');
Route::post('doctor', [DoctorAdminController::class, 'store'])->name('doctor.store');
Route::get('doctor/{id}', [DoctorAdminController::class, 'show'])->name('doctor.show');
Route::get('doctor/{id}/edit', [DoctorAdminController::class, 'edit'])->name('doctor.edit');
Route::put('doctor/{id}', [DoctorAdminController::class, 'update'])->name('doctor.update');
Route::delete('doctor/{id}', [DoctorAdminController::class, 'destroy'])->name('doctor.destroy');


Route::get('doctor-cita-index', [DoctorAdminController::class, 'index'])->name('doctor.cita.index');
Route::get('doctor-cita-dashboard', [DoctorAdminController::class, 'dashboard'])->name('doctor.cita.dashboard');
Route::get('doctor-cita-gestionar/{id}', [DoctorAdminController::class, 'gestionar'])->name('doctor.cita.gestionar');
Route::post('doctor-cita-update', [DoctorAdminController::class, 'update'])->name('doctor.cita.update');


Route::get('doctor-cita/{id}', [DoctorAdminController::class, 'show'])->name('doctor.cita.show');
Route::get('doctor-cita/{id}/edit', [DoctorAdminController::class, 'edit'])->name('doctor.cita.edit');
Route::put('doctor-cita/{id}', [DoctorAdminController::class, 'update'])->name('doctor.cita.update');
Route::delete('doctor-cita/{id}', [DoctorAdminController::class, 'destroy'])->name('doctor.cita.destroy');



