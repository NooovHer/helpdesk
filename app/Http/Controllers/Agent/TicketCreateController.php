<?php
namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Department;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketCreateController extends Controller
{
    public function create()
    {
        $users = User::orderBy('username')->get();
        $departments = Department::all();
        $categories = Category::all();
        return view('agent.tickets.create', compact('users', 'departments', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:baja,media,alta,urgente',
            'department_id' => 'nullable|exists:departments,id',
            'category_id' => 'nullable|exists:categories,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'nuevo',
            'priority' => $request->priority,
            'department_id' => $request->department_id,
            'category_id' => $request->category_id,
            'created_by' => $request->user_id,
            'created_by_agent' => Auth::id(), // Nuevo campo para saber qué agente lo creó
        ]);

        return redirect()->route('agent.tickets.show', $ticket)->with('success', 'Ticket creado y asignado correctamente.');
    }
}
