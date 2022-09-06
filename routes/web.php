<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SpecialtyController;
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
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

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
