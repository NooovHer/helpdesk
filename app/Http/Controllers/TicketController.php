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
    // Modifica esta parte en tu TicketController.php
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:baja,media,alta,urgente',
            'department_id' => 'nullable|exists:departments,id',
            'category_id' => 'nullable|exists:categories,id',
            'assigned_to' => 'nullable|exists:users,id',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);


        // Depuración
        Log::info('Request tiene archivos adjuntos: ' . $request->hasFile('attachments'));
        if ($request->hasFile('attachments')) {
            Log::info('Número de archivos: ' . count($request->file('attachments')));
        }

        $attachmentPaths = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if (!$file->isValid()) {
                    Log::error("Archivo no válido: " . $file->getClientOriginalName() . " - Error: " . $file->getErrorMessage());
                    continue;
                }
                $path = $file->store('attachments', 'public');
                $attachmentPaths[] = $path;
            }
        }

        // Crear el ticket
        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'nuevo',
            'priority' => $request->priority,
            'department_id' => $request->department_id,
            'category_id' => $request->category_id,
            'assigned_to' => $request->assigned_to,
            'created_by' => Auth::id(),
            'attachments' => !empty($attachmentPaths) ? json_encode($attachmentPaths) : null,
        ]);

        Log::info('Ticket creado con ID: ' . $ticket->id);
        Log::info('Attachments guardados: ' . ($ticket->attachments ?? 'ninguno'));

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
        $departments = Department::all();
        $categories = Category::all();

        return view('tickets.edit', compact('ticket', 'departments', 'categories'));
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
            'remove_attachments' => 'nullable|array',
            'remove_attachments.*' => 'string',
        ]);

        $ticket = Ticket::findOrFail($id);

        // Obtener los archivos adjuntos actuales
        $currentAttachments = json_decode($ticket->attachments ?: '[]', true);

        // Procesar archivos a eliminar si se especificaron
        if ($request->has('remove_attachments')) {
            foreach ($request->remove_attachments as $path) {
                // Eliminar el archivo físico
                Storage::disk('public')->delete($path);

                // Eliminar de la lista de archivos adjuntos
                $index = array_search($path, $currentAttachments);
                if ($index !== false) {
                    unset($currentAttachments[$index]);
                }
            }
            // Reindexar el array
            $currentAttachments = array_values($currentAttachments);
        }

        // Añadir nuevos archivos si existen
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $currentAttachments[] = $file->store('attachments', 'public');
            }
        }

        // Si el estado es "resuelto", guardar la fecha de resolución
        if ($request->status === 'resuelto' && !$ticket->resolved_at) {
            $ticket->resolved_at = now();
        }

        // Actualizar el ticket con todos los datos
        $ticket->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
            'department_id' => $request->department_id,
            'category_id' => $request->category_id,
            'assigned_to' => $request->assigned_to,
            'resolution_notes' => $request->resolution_notes,
            'attachments' => json_encode($currentAttachments),
        ]);

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

        // Eliminar todos los archivos adjuntos
        $attachments = json_decode($ticket->attachments ?: '[]', true);
        foreach ($attachments as $path) {
            Storage::disk('public')->delete($path);
        }

        // Eliminar ticket
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket eliminado correctamente.');
    }
}
