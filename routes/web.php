<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketCommentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\StatsController as AdminStatsController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Agent\TicketController as AgentTicketController;
use App\Http\Controllers\Agent\DashboardController as AgentDashboardController;
use App\Http\Controllers\Admin\ComputerController as AdminComputerController;
use App\Http\Controllers\Agent\ComputerController as AgentComputerController;
use App\Http\Controllers\SystemStatusController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\FaviconController;
// Redirección inicial
Route::get('/', fn() => redirect('login'));

// Favicon dinámico
Route::get('/favicon.ico', [FaviconController::class, 'show'])->name('favicon');

// Ruta de prueba para debug
Route::get('/test-favicon', function() {
    try {
        $favicon = \App\Helpers\CompanyHelper::getCurrentUserCompanyFavicon();
        return response()->json([
            'favicon_url' => $favicon,
            'user' => auth()->user() ? auth()->user()->toArray() : 'No autenticado',
            'company' => auth()->user() && auth()->user()->empresa_id ? \App\Models\Company::find(auth()->user()->empresa_id) : 'Sin empresa'
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});

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
    // Feedback al cerrar ticket
    Route::post('tickets/{ticket}/feedback', [\App\Http\Controllers\TicketFeedbackController::class, 'store'])
        ->name('tickets.feedback.store');
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

        // Tickets disponibles para asignar
        Route::get('tickets/available', [AgentTicketController::class, 'available'])
            ->name('tickets.available');

        // Crear ticket para usuario (ruta única para evitar conflicto)
        Route::get('tickets/create-user', [\App\Http\Controllers\Agent\TicketCreateController::class, 'create'])->name('tickets.create-user');
        Route::post('tickets/store-user', [\App\Http\Controllers\Agent\TicketCreateController::class, 'store'])->name('tickets.store-user');

        // CRUD de tickets del agente
        Route::resource('tickets', AgentTicketController::class)
            ->only(['index', 'show', 'update']);


        // Asignar ticket específico
        Route::post('tickets/{ticket}/assign', [AgentTicketController::class, 'assign'])
            ->name('tickets.assign');

        // Tomar siguiente ticket automáticamente
        Route::post('tickets/next', [AgentTicketController::class, 'next'])
            ->name('tickets.next');

        // Liberar ticket (desasignar)
        Route::post('tickets/{ticket}/release', [AgentTicketController::class, 'release'])
            ->name('tickets.release');

        // Agregar tickets a pendientes
        Route::post('tickets/add-to-pending', [AgentTicketController::class, 'addToPending'])
            ->name('tickets.add-to-pending');

        // Asignar múltiples tickets
        Route::post('tickets/assign-multiple', [AgentTicketController::class, 'assignMultiple'])
            ->name('tickets.assign-multiple');

        // Gestión de computadoras (visible/modificable por agentes)
        Route::resource('computers', AgentComputerController::class)
            ->only(['index', 'show', 'edit', 'update']);

        // Gestión del estado del sistema (agentes también pueden modificar)
        Route::resource('system-status', SystemStatusController::class);
        Route::post('system-status/{systemStatus}/quick-update', [SystemStatusController::class, 'quickUpdate'])
            ->name('system-status.quick-update');
    });
// -----------------------------------------------------------
// Dashboard y rutas **solo para administradores** (role:admin)
// -----------------------------------------------------------
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Panel de feedback de tickets
        Route::get('feedback', [\App\Http\Controllers\Admin\FeedbackController::class, 'index'])->name('feedback.index');
        Route::get('feedback/export', [\App\Http\Controllers\Admin\FeedbackController::class, 'export'])->name('feedback.export');
        // Panel de administrador
        Route::get('dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Gestión de usuarios
        Route::resource('users', AdminUserController::class);

        // Ruta para asignar roles a un usuario
        Route::post('users/{user}/roles', [AdminUserController::class, 'assignRoles'])
            ->name('users.roles');

        // Estadísticas generalesm
        Route::get('stats', [AdminStatsController::class, 'index'])
            ->name('stats.index');

        // Gestión de computadoras
        Route::resource('computers', AdminComputerController::class);

        // Gestión de companies (empresas)
        Route::resource('companies', CompanyController::class);

        // Gestión del estado del sistema
        Route::resource('system-status', SystemStatusController::class);
        Route::post('system-status/{systemStatus}/quick-update', [SystemStatusController::class, 'quickUpdate'])
            ->name('system-status.quick-update');
    });

require __DIR__ . '/auth.php';
