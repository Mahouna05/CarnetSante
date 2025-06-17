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
    return view('auth.login');
});

// Routes Authentication (gérées par Breeze)
require __DIR__.'/auth.php';
//AuthenticatedSessionController
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
    Route::get('/dashboard', [AgentController::class, 'dashboard'])->name('agent.dashboard');
    
    // Gestion des carnets
    Route::get('/books', [AgentController::class, 'manageBooks'])->name('books.index');
});
// Routes pour les super administrateurs
Route::middleware(['auth', 'role:super_admin'])->prefix('super_admin')->name('super_admin.')->group(function () {
    // Dashboard super admin
    Route::get('/super_admin/dashboard', [SuperAdminController::class, 'dashboard'])->name('super_admin.dashboard');
    
    // Gestion des agents
    Route::get('/agents', [SuperAdminController::class, 'indexAgents'])->name('agents.index');
    Route::get('/agents/create', [SuperAdminController::class, 'createAgent'])->name('agents.create');
    Route::post('/agents', [SuperAdminController::class, 'storeAgent'])->name('agents.store');
    Route::get('/agents/{agent}/edit', [SuperAdminController::class, 'editAgent'])->name('agents.edit');
    Route::put('/agents/{agent}', [SuperAdminController::class, 'updateAgent'])->name('agents.update');
    Route::delete('/agents/{agent}', [SuperAdminController::class, 'destroyAgent'])->name('agents.destroy');
    
    // Gestion des admins
    Route::get('/admins', [SuperAdminController::class, 'indexAdmins'])->name('admins.index');
    Route::get('/admins/create', [SuperAdminController::class, 'createAdmin'])->name('admins.create');
    Route::post('/admins', [SuperAdminController::class, 'storeAdmin'])->name('admins.store');
    Route::get('/admins/{admin}/edit', [SuperAdminController::class, 'editAdmin'])->name('admins.edit');
    Route::put('/admins/{admin}', [SuperAdminController::class, 'updateAdmin'])->name('admins.update');
    Route::delete('/admins/{admin}', [SuperAdminController::class, 'destroyAdmin'])->name('admins.destroy');
    
    // Gestion des vaccins
    Route::get('/vaccins', [SuperAdminController::class, 'indexVaccins'])->name('vaccins.index');
    Route::get('/vaccins/create', [SuperAdminController::class, 'createVaccin'])->name('vaccins.create');
    Route::post('/vaccins', [SuperAdminController::class, 'storeVaccin'])->name('vaccins.store');
    Route::get('/vaccins/{vaccin}/edit', [SuperAdminController::class, 'editVaccin'])->name('vaccins.edit');
    Route::put('/vaccins/{vaccin}', [SuperAdminController::class, 'updateVaccin'])->name('vaccins.update');
    Route::delete('/vaccins/{vaccin}', [SuperAdminController::class, 'destroyVaccin'])->name('vaccins.destroy');
    
    // Gestion des examens
    Route::get('/examens', [SuperAdminController::class, 'indexExamens'])->name('examens.index');
    Route::get('/examens/create', [SuperAdminController::class, 'createExamen'])->name('examens.create');
    Route::post('/examens', [SuperAdminController::class, 'storeExamen'])->name('examens.store');
    Route::get('/examens/{examen}/edit', [SuperAdminController::class, 'editExamen'])->name('examens.edit');
    Route::put('/examens/{examen}', [SuperAdminController::class, 'updateExamen'])->name('examens.update');
    Route::delete('/examens/{examen}', [SuperAdminController::class, 'destroyExamen'])->name('examens.destroy');
    
    // Gestion des indices subjectifs
    Route::get('/indices', [SuperAdminController::class, 'indexIndices'])->name('indices.index');
    Route::get('/indices/create', [SuperAdminController::class, 'createIndice'])->name('indices.create');
    Route::post('/indices', [SuperAdminController::class, 'storeIndice'])->name('indices.store');
    Route::get('/indices/{indice}/edit', [SuperAdminController::class, 'editIndice'])->name('indices.edit');
    Route::put('/indices/{indice}', [SuperAdminController::class, 'updateIndice'])->name('indices.update');
    Route::delete('/indices/{indice}', [SuperAdminController::class, 'destroyIndice'])->name('indices.destroy');
});