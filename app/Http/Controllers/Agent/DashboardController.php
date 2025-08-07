<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Muestra el panel de Agente de Soporte
     */
    public function index()
    {
        $user = Auth::user();

        // Tickets asignados al agente
        $assignedTickets = Ticket::where('assigned_to', $user->id)->latest()->get();

        // Tickets disponibles para asignar (sin agente asignado)
        $availableTickets = Ticket::whereNull('assigned_to')
            ->where('status', '!=', 'cerrado')
            ->with('creator', 'department', 'category')
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();

        // Otras métricas opcionales
        $assignedCount = $assignedTickets->where('status', 'abierto')->count();
        $inProgressCount = $assignedTickets->where('status', 'en progreso')->count();
        $closedCount = $assignedTickets->where('status', 'cerrado')->count();
        $avgResponse = '--'; // Calcula si tienes datos

        $urgentCount = $assignedTickets->where('priority', 'alta')->where('status', 'abierto')->count();

        return view('agent.dashboard', compact(
            'assignedTickets',
            'availableTickets',
            'assignedCount',
            'inProgressCount',
            'closedCount',
            'avgResponse',
            'urgentCount'
        ));
    }
}
