<?php

use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Api\SpecialtyController as ApiSpecialtyController;
use App\Http\Controllers\Api\ScheduleController as ApiScheduleController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Doctor\ScheduleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
})->name('/');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth','admin'])->group(function (){
    //Specialty
    Route::get('/specialties', [SpecialtyController::class, 'index'])->name('specialty.index');
    Route::get('/specialties/create', [SpecialtyController::class, 'create'])->name('specialty.create');
    Route::get('/specialties/{specialty}/edit', [SpecialtyController::class, 'edit'])->name('specialty.edit');

    Route::post('/specialties', [SpecialtyController::class, 'store'])->name('specialty.store');
    Route::put('/specialties/{specialty}', [SpecialtyController::class, 'update'])->name('specialty.update');
    Route::delete('/specialties/{specialty}', [SpecialtyController::class, 'destroy'])->name('specialty.destroy');

    //Doctors
    Route::resource('doctors', DoctorController::class);

    //Patients
    Route::resource('patients', PatientController::class);
});

Route::middleware(['auth','doctor'])->group(function (){
    Route::get('/schedule', [ScheduleController::class, 'edit'])->name('schedule.edit');
    Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');
});

Route::middleware('auth')->group(function (){
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointment.store');

    //JSON
    Route::get('/specialties/{specialty}/doctors', [ApiSpecialtyController::class, 'doctors'])->name('specialties.doctors');
    Route::get('/schedule/hours', [ApiScheduleController::class, 'hours'])->name('schedule.hours');
});

