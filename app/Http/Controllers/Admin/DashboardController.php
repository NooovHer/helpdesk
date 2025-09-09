<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTickets  = Ticket::count();

        // Reemplazamos los contadores individuales por un solo query optimizado
        $statusCounts = Ticket::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status'); // ['nuevo' => 5, 'en progreso' => 7, ...]

        // Usamos los valores o 0 si no existen

        $nuevoTickets      = $statusCounts['nuevo'] ?? 0;
        $enProgresoTickets = $statusCounts['en progreso'] ?? 0;
        $resueltoTickets   = $statusCounts['resuelto'] ?? 0;
        $cerradoTickets    = $statusCounts['cerrado'] ?? 0;

        // Mantienes tu lógica actual de agentes
        $onlineAgents = User::where('role', 'agent')
            ->where('status', 'active')
            ->count();

        $recentTickets = Ticket::with('assignedTo')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalTickets',
            'nuevoTickets',
            'enProgresoTickets',
            'resueltoTickets',
            'cerradoTickets',
            'onlineAgents',
            'recentTickets'
        ));
    }
}
