<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Department;
use App\Models\Category;

class TicketController extends Controller
{
    // Mostrar todos los tickets
    public function index()
    {
        // Obtener todos los tickets, incluidos los relacionados con el usuario (creador, asignado, departamento, categoría)
        $tickets = Ticket::with('creator', 'assignedTo', 'department', 'category')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('tickets.index', compact('tickets'));
    }

    // Mostrar formulario de creación de ticket
    public function create()
    {
        $departments = Department::all();
        $categories = Category::all();

        return view('tickets.create', compact('departments', 'categories'));
    }

    // Guardar un nuevo ticket
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:baja,media,alta,urgente',
            'department_id' => 'nullable|exists:departments,id',
            'category_id' => 'nullable|exists:categories,id',
            'assigned_to' => 'nullable|exists:users,id',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $attachmentPaths = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachmentPaths[] = $file->store('attachments', 'public');
            }
        }
        // Crear el ticket
        Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'nuevo',
            'priority' => $request->priority,
            'department_id' => $request->department_id,
            'category_id' => $request->category_id,
            'assigned_to' => $request->assigned_to,
            'created_by' => Auth::id(),
            'attachments' => json_encode($attachmentPaths),
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket creado correctamente.');
    }

    // Mostrar detalles de un ticket
    public function show($id)
    {
        $ticket = Ticket::with('creator', 'assignedTo', 'department', 'category')->findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('tickets.edit', compact('ticket'));
    }

    // Actualizar un ticket
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:nuevo,en progreso,resuelto,cerrado',
            'priority' => 'required|in:baja,media,alta,urgente',
            'department_id' => 'nullable|exists:departments,id',
            'category_id' => 'nullable|exists:categories,id',
            'assigned_to' => 'nullable|exists:users,id',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'resolution_notes' => 'nullable|string',
        ]);

        $ticket = Ticket::findOrFail($id);

        // Subir archivo si existe y eliminar el anterior
        if ($request->hasFile('attachments')) {
            if ($ticket->attachments) {
                Storage::disk('public')->delete($ticket->attachments);
            }
            $ticket->attachments = $request->file('attachments')->store('attachments', 'public');
        }

        // Si el estado es "resuelto", guardar la fecha de resolución
        if ($request->status === 'resuelto' && !$ticket->resolved_at) {
            $ticket->resolved_at = now();
        }

        $ticket->update($request->except('attachments'));

        return redirect()->route('tickets.index')->with('success', 'Ticket actualizado correctamente.');
    }

    // Eliminar un ticket
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);

        // Verificar si el usuario tiene permisos para eliminar el ticket
        if (Auth::user()->role !== 'admin' && $ticket->created_by !== Auth::id()) {
            abort(403, 'No tienes permiso para eliminar este ticket.');
        }
        // Eliminar archivo adjunto si existe
        if ($ticket->attachments) {
            Storage::disk('public')->delete($ticket->attachments);
        }


        // Eliminar ticket
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket eliminado correctamente.');
    }
}
