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

        // Total de tickets asignados a este agente
        $assignedCount = Ticket::where('assigned_to', $user->id)->count();

        // Los 5 tickets más recientes asignados
        $recentAssigned = Ticket::where('assigned_to', $user->id)
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('agent.dashboard', compact(
            'assignedCount',
            'recentAssigned'
        ));
    }
}
