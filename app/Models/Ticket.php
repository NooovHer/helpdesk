<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'department_id',
        'created_by',
        'assigned_to',
        'category_id',
        'resolved_at',
        'attachments',
        'resolution_notes'
    ];
    protected $casts = [
        'attachments' => 'array',
        'resolved_at' => 'datetime',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'resolved_at'
    ];

    // Relación con User (creador)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relación con User (Agente)
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Relación con Departmento
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relación con Categoria
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Scope para tickets recientes
    public function scopeRecent($query)
    {
        return $query->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc');
    }
    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }
}
