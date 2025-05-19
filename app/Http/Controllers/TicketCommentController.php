<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketComment;
use app\Models\User;
use Illuminate\Support\Facades\Auth;

class TicketCommentController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $request->validate([
            'content' => 'required|string',
            'attachments.*' => 'nullable|file|max:10240', // 10MB max por archivo
        ]);

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('ticket-comments', 'public');
                $attachments[] = $path;
            }
        }

        // Crear el comentario asegurando que ticket_id esté presente
        $comment = new TicketComment();
        $comment->ticket_id = $ticket->id;
        $comment->user_id = Auth::id();
        $comment->content = $request->content;
        $comment->attachments = !empty($attachments) ? json_encode($attachments) : null;
        $comment->is_internal = false;
        $comment->save();

        // Actualizar la fecha de actualización del ticket
        $ticket->touch();

        return redirect()->back()->with('success', 'Comentario agregado correctamente.');
    }
}
