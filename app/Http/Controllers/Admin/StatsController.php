<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        // Ejemplo de datos, ajusta según tus necesidades
        $ticketsPerStatus = Ticket::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')->get();
        $agentsCount      = User::where('role', 'agent')->count();

        return view('admin.stats', compact('ticketsPerStatus', 'agentsCount'));
    }
}
