<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
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
Route::prefix('admin')->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UsersController::class);
    //Route::resource('users', [UsersController::class, 'index'])->name('admin.users.index');
    Route::resource('patients', PatientController::class)->only(['index', 'show', 'edit', 'update','create', 'store','destroy']);
    Route::resource('bloodTypes', BloodTypeController::class);
    Route::resource('specialities', SpecialityController::class);
    Route::resource('doctores', DoctorController::class)->only(['index', 'create','store','show', 'edit', 'update','destroy']);
    Route::resource('appointments', AppointmentController::class);
    Route::get('appointments/consultation/{id}', [AppointmentController::class,'consultation'] )->name('appointments.consultation');

<<<<<<< HEAD
    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');   
    Route::get('index', [AdminController::class, 'index'])->name('admin.index');   
=======
    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('calendartest', [CalendarController::class, 'test'])->name('calendar.test');
>>>>>>> 5033bce6b1cb0930b50305631c7b91376bc765e2
});

Route::get('doctores/{doctor}/schedules', [DoctorController::class, 'schedules'])->name('doctores.schedules');

Route::get('/prueba', function () {
    $schedule = \App\Models\Schedule::all();    
    //dd($schedule);
});

Route::post("prueba.testSave", [AppointmentController::class, 'testSave'])->name('prueba.testSave');

//Route::resource('/appointments', AppointmentController::class);

Route::get('agendadoc', [AppointmentController::class,'agendadoc'] )->name('agendadoc');
Route::post('agendadoc.especialidad', [AppointmentController::class,'especialidad'] )->name('agendadoc.especialidad');

Route::post('agendadoc.showcalendar', [AppointmentController::class,'showcalendar'] )->name('agendadoc.showcalendar');
Route::post('agendadoc.confirmar', [AppointmentController::class,'confirmar'] )->name('agendadoc.confirmar');

<<<<<<< HEAD
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
=======
Route::get('login', [LoginController::class, "login"])->name("login");
>>>>>>> 5033bce6b1cb0930b50305631c7b91376bc765e2
