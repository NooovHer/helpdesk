<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener los tickets creados por el usuario autenticado
        $tickets = Ticket::where('created_by', Auth::id())->orderBy('created_at', 'desc')->get();

        // Retornar la vista con los tickets
        return view('dashboard', compact('tickets'));
    }
}
