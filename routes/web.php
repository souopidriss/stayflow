<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ChambreController as AdminChambre;
use App\Http\Controllers\Admin\ClientController as AdminClient;
use App\Http\Controllers\Admin\ReservationController as AdminReservation;
use App\Http\Controllers\Admin\FactureController as AdminFacture;
use App\Http\Controllers\Admin\ServiceController as AdminService;
use App\Http\Controllers\Admin\EmployeController as AdminEmploye;
use App\Http\Controllers\Admin\EvaluationController as AdminEvaluation;
use App\Http\Controllers\Receptionniste\DashboardController as ReceptionDashboard;
use App\Http\Controllers\Receptionniste\ReservationController as ReceptionReservation;
use App\Http\Controllers\Receptionniste\ChambreController as ReceptionChambre;
use App\Http\Controllers\Receptionniste\ClientController as ReceptionClient;
use App\Http\Controllers\Receptionniste\FactureController as ReceptionFacture;
use App\Http\Controllers\Client\DashboardController as ClientDashboard;

Route::get('/', fn() => redirect()->route('login'));

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login',     [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',    [LoginController::class, 'login']);
    Route::get('/register',  [LoginController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register']);
});
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// -----------------------------------------------
// Routes Super Admin
// -----------------------------------------------
Route::prefix('admin')->middleware(['auth', 'role:super_admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Chambres
    Route::resource('chambres', AdminChambre::class);

    // Clients
    Route::resource('clients', AdminClient::class);

    // Réservations
    Route::resource('reservations', AdminReservation::class);
    Route::patch('/reservations/{reservation}/statut', [AdminReservation::class, 'updateStatut'])->name('reservations.statut');

    // Factures
    Route::resource('factures', AdminFacture::class);
    Route::get('/factures/{facture}/pdf', [AdminFacture::class, 'pdf'])->name('factures.pdf');

    // Services
    Route::resource('services', AdminService::class);

    // Employés
    Route::resource('employes', AdminEmploye::class);

    // Évaluations
    Route::resource('evaluations', AdminEvaluation::class);
});

// -----------------------------------------------
// Routes Réceptionniste
// -----------------------------------------------
Route::prefix('reception')->middleware(['auth', 'role:receptionniste,super_admin'])->name('reception.')->group(function () {
    Route::get('/dashboard', [ReceptionDashboard::class, 'index'])->name('dashboard');

    // Chambres
    Route::resource('chambres', ReceptionChambre::class);

    // Clients
    Route::resource('clients', ReceptionClient::class);

    // Réservations
    Route::resource('reservations', ReceptionReservation::class);
    Route::patch('/reservations/{reservation}/statut', [ReceptionReservation::class, 'updateStatut'])->name('reservations.statut');
    Route::patch('/reservations/{reservation}/checkin', [ReceptionReservation::class, 'checkin'])->name('reservations.checkin');
    Route::patch('/reservations/{reservation}/checkout', [ReceptionReservation::class, 'checkout'])->name('reservations.checkout');

    // Factures
    Route::resource('factures', ReceptionFacture::class);
    Route::get('/factures/{facture}/pdf', [ReceptionFacture::class, 'pdf'])->name('factures.pdf');
    Route::patch('/factures/{facture}/payer', [ReceptionFacture::class, 'payer'])->name('factures.payer');
});

// -----------------------------------------------
// Routes Client
// -----------------------------------------------
Route::prefix('client')
    ->middleware(['auth', 'role:client'])
    ->name('client.')
    ->group(function () {
        Route::get('/dashboard', [ClientDashboard::class, 'index'])->name('dashboard');
        Route::get('/chambres', [\App\Http\Controllers\Client\ChambreController::class, 'index'])->name('chambres.index');
        Route::get('/reservations', [\App\Http\Controllers\Client\ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/reservations/create', [\App\Http\Controllers\Client\ReservationController::class, 'create'])->name('reservations.create');
        Route::post('/reservations', [\App\Http\Controllers\Client\ReservationController::class, 'store'])->name('reservations.store');
        Route::get('/factures', [\App\Http\Controllers\Client\FactureController::class, 'index'])->name('factures.index');
    });