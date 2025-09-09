<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketAction extends Model
{
    protected $fillable = [
        'ticket_id',
        'user_id',
        'action_type', // Ej: asignado, estado cambiado, comentario, resuelto, cerrado
        'description', // Detalle de la acción
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
