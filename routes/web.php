<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

// Routes Authentication (gérées par Breeze)
require __DIR__.'/auth.php';

// Routes pour le profil (gérées par Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes pour les administrateurs
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Gestion des utilisateurs
    Route::get('/users', [AdminController::class, 'indexUsers'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    // Gestion des hôpitaux
    Route::get('/hospitals', [AdminController::class, 'indexHospitals'])->name('hospitals.index');
    Route::get('/hospitals/create', [AdminController::class, 'createHospital'])->name('hospitals.create');
    Route::post('/hospitals', [AdminController::class, 'storeHospital'])->name('hospitals.store');
    Route::get('/hospitals/{hospital}/edit', [AdminController::class, 'editHospital'])->name('hospitals.edit');
    Route::put('/hospitals/{hospital}', [AdminController::class, 'updateHospital'])->name('hospitals.update');
    Route::delete('/hospitals/{hospital}', [AdminController::class, 'destroyHospital'])->name('hospitals.destroy');
});

// Routes pour les agents
Route::middleware(['auth', 'role:agent'])->prefix('agent')->name('agent.')->group(function () {
    // Dashboard agent
    Route::get('/dashboard', [AgentController::class, 'dashboard'])->name('dashboard');
    
    // Gestion des carnets
    Route::get('/books', [AgentController::class, 'manageBooks'])->name('books.index');
});