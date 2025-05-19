<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketCommentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\StatsController as AdminStatsController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Agent\TicketController as AgentTicketController;
use App\Http\Controllers\Agent\DashboardController as AgentDashboardController;

// Redirección inicial
Route::get('/', fn() => redirect('login'));

// Dashboard general (usuario común)
Route::middleware('auth')
    ->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// Rutas para cualquier usuario autenticado
Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tickets propios y comentarios
    Route::resource('tickets', TicketController::class);
    Route::post('tickets/{ticket}/comments', [TicketCommentController::class, 'store'])
        ->name('tickets.comments.store');
});

// -----------------------------------------------------------
// Dashboard y rutas **solo para agentes** (role:agent)
// -----------------------------------------------------------
Route::middleware(['auth', 'role:agent'])
    ->prefix('agent')
    ->name('agent.')
    ->group(function () {
        // Panel de agente
        Route::get('dashboard', [AgentDashboardController::class, 'index'])
            ->name('dashboard');

        // CRUD de tickets del agente
        Route::resource('tickets', AgentTicketController::class)
            ->only(['index', 'show', 'update']);

        // Ruta existente para “start”
        Route::patch('tickets/{ticket}/start', [AgentTicketController::class, 'start'])
            ->name('tickets.start');

        // ← Agrega esta ruta para “tomar siguiente ticket”
        Route::post('tickets/next', [AgentTicketController::class, 'next'])
            ->name('tickets.next');
    });
// -----------------------------------------------------------
// Dashboard y rutas **solo para administradores** (role:admin)
// -----------------------------------------------------------
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Panel de administrador
        Route::get('dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Gestión de usuarios
        Route::resource('users', AdminUserController::class)
            ->except(['show']);

        // Estadísticas generales
        Route::get('stats', [AdminStatsController::class, 'index'])
            ->name('stats.index');
    });

require __DIR__ . '/auth.php';
