<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\TicketFeedback;

class TicketFeedbackController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        // Solo el creador puede dejar feedback y solo si el ticket está cerrado
        if (Auth::id() !== $ticket->creator->id || $ticket->status !== 'cerrado') {
            abort(403, 'No tienes permiso para dejar feedback en este ticket.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Evitar duplicados
        if (TicketFeedback::where('ticket_id', $ticket->id)->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Ya has dejado tu feedback para este ticket.');
        }

        TicketFeedback::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', '¡Gracias por tu feedback!');
    }
}
