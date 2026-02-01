<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\BloodTypeController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\SpecialityController;




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
    Route::resource('patients', PatientController::class)->only(['index', 'show', 'edit', 'update']);
    Route::resource('bloodTypes', BloodTypeController::class);
    Route::resource('specialities', SpecialityController::class);
    Route::resource('doctores', DoctorController::class)->only(['index', 'show', 'edit', 'update']);
});
