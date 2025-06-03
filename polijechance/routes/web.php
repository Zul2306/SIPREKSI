<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\PredictionController;
// use App\Http\Controllers\Admin\PredictController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Middleware\AdminOnly;
use App\Http\Controllers\SuperAdmin\SuperController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/register', [RegisterController::class, 'show'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

require __DIR__.'/auth.php';

Route::middleware(['admin.only'])->group(function() {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/users/kelas/{id}', [AdminController::class, 'showByKelas']);
    Route::get('/prediction/chart-data/user/{user_id}', [AdminController::class, 'getChartDataByUser']); 
   Route::delete('/admin/dashboard/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
   Route::get('/admin/data', [SuperController::class, 'show'])->name('admin.index');
    Route::post('/admin/store', [SuperController::class, 'store'])->name('admin.store');
    Route::delete('/admin/{id}', [SuperController::class, 'destroy'])->name('admin.destroy');

   
});







Route::middleware('user.only', 'verified')->group(function () {
    Route::get('/user/dashboard', [DashboardController::class, 'dashboard'])->name('user.dashboard');
    // Route::get('/prediksi', [PredictionController::class, 'showForm'])->name('predict.form');
    // Route::post('/prediksi', [PredictionController::class, 'predict'])->name('predict.submit');
    Route::get('/prediksi', [PredictionController::class, 'form'])->name('predict.form');
    Route::post('/prediksi', [PredictionController::class, 'submit'])->name('predict.submit');

    Route::get('/prediksi-saya', [PredictionController::class, 'history'])->name('user.prediction.history');
    Route::get('/user/dashboard/id/{user_id}', [DashboardController::class, 'getChartData']);
    Route::get('/user/dashboard/details', [DashboardController::class, 'getDetailData']);  
});



