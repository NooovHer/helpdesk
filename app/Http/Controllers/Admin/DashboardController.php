<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTickets  = Ticket::count();
        $openTickets   = Ticket::where('status', 'open')->count();
        $closedTickets = Ticket::where('status', 'closed')->count();

        // Tomamos como “agentes” a quienes tengan role = manager y status = active
        $onlineAgents = User::where('role', 'manager')
            ->where('status', 'active')
            ->count();

        // Últimos tickets, cargando la relación assignedTo
        $recentTickets = Ticket::with('assignedTo')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalTickets',
            'openTickets',
            'closedTickets',
            'onlineAgents',
            'recentTickets'
        ));
    }
}
