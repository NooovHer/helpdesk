<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Department;
use App\Models\Category;

class TicketController extends Controller
{
    // Mostrar todos los tickets
    public function index()
    {
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
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'priority'      => 'required|in:baja,media,alta,urgente',
            'department_id' => 'nullable|exists:departments,id',
            'category_id'   => 'nullable|exists:categories,id',
            'assigned_to'   => 'nullable|exists:users,id',
            'attachments'   => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // 1) Crear ticket inicial sin attachments
        $ticket = Ticket::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'status'        => 'nuevo',
            'priority'      => $request->priority,
            'department_id' => $request->department_id,
            'category_id'   => $request->category_id,
            'assigned_to'   => $request->assigned_to,
            'created_by'    => Auth::id(),
            'attachments'   => null,
        ]);

        $attachmentPaths = [];

        // 2) Guardar archivos en carpeta específica del ticket
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if (! $file->isValid()) {
                    Log::error("Archivo no válido: " . $file->getClientOriginalName() . " - Error: " . $file->getErrorMessage());
                    continue;
                }
                $path = $file->store("tickets/{$ticket->id}", 'public');
                $attachmentPaths[] = $path;
            }

            // 3) Actualizar el ticket con rutas de attachments
            $ticket->attachments = json_encode($attachmentPaths);
            $ticket->save();
        }

        Log::info('Ticket creado con ID: ' . $ticket->id);
        Log::info('Attachments guardados: ' . ($ticket->attachments ?? 'ninguno'));

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket creado correctamente.');
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
        $departments = Department::all();
        $categories = Category::all();

        return view('tickets.edit', compact('ticket', 'departments', 'categories'));
    }

    // Actualizar un ticket
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'status'            => 'required|in:nuevo,en progreso,resuelto,cerrado',
            'priority'          => 'required|in:baja,media,alta,urgente',
            'department_id'     => 'nullable|exists:departments,id',
            'category_id'       => 'nullable|exists:categories,id',
            'assigned_to'       => 'nullable|exists:users,id',
            'attachments.*'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'resolution_notes'  => 'nullable|string',
            'remove_attachments' => 'nullable|array',
            'remove_attachments.*' => 'string',
        ]);

        $ticket = Ticket::findOrFail($id);

        // Obtener archivos actuales
        $currentAttachments = json_decode($ticket->attachments ?: '[]', true);

        // Procesar eliminaciones
        if ($request->has('remove_attachments')) {
            foreach ($request->remove_attachments as $path) {
                Storage::disk('public')->delete($path);
                if (($index = array_search($path, $currentAttachments)) !== false) {
                    unset($currentAttachments[$index]);
                }
            }
            $currentAttachments = array_values($currentAttachments);
        }

        // Añadir nuevos archivos en carpeta del ticket
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if (! $file->isValid()) continue;
                $currentAttachments[] = $file->store("tickets/{$ticket->id}", 'public');
            }
        }

        // Si cambia a resuelto y no tiene fecha, guardarla
        if ($request->status === 'resuelto' && ! $ticket->resolved_at) {
            $ticket->resolved_at = now();
        }

        // Actualizar resto de campos
        $ticket->update([
            'title'            => $request->title,
            'description'      => $request->description,
            'status'           => $request->status,
            'priority'         => $request->priority,
            'department_id'    => $request->department_id,
            'category_id'      => $request->category_id,
            'assigned_to'      => $request->assigned_to,
            'resolution_notes' => $request->resolution_notes,
            'attachments'      => json_encode($currentAttachments),
        ]);

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket actualizado correctamente.');
    }

    // Eliminar un ticket
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $ticket->created_by !== Auth::id()) {
            abort(403, 'No tienes permiso para eliminar este ticket.');
        }

        // Eliminar carpeta entera de attachments
        Storage::disk('public')->deleteDirectory("tickets/{$ticket->id}");

        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket eliminado correctamente.');
    }

    // Asignar siguiente ticket disponible
    public function next()
    {
        $ticket = Ticket::whereNull('assigned_to')
            ->orderBy('created_at')
            ->first();

        if (! $ticket) {
            return back()->with('error', 'No hay tickets disponibles para asignar.');
        }

        $ticket->update([
            'assigned_to' => Auth::id(),
            'status'      => 'in_progress',
        ]);

        return redirect()
            ->route('agent.tickets.show', $ticket)
            ->with('success', 'Ticket asignado correctamente.');
    }
}
