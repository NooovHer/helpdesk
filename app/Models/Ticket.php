<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Department;
use App\Models\Category;

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
        'resolution_notes',
    ];

    protected $casts = [
        'attachments'  => 'array',
        'resolved_at'  => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'resolved_at',
    ];

    /** Relación con el usuario que creó el ticket */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /** Relación con el usuario (manager/agente) asignado */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /** Relación con el departamento */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /** Relación con la categoría */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /** Scope: tickets creados en los últimos 7 días */
    public function scopeRecent($query)
    {
        return $query->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc');
    }

    /** Relación con comentarios */
    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }

    /** Obtener el estado formateado */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'abierto' => 'Abierto',
            'en progreso' => 'En Progreso',
            'resuelto' => 'Resuelto',
            'cerrado' => 'Cerrado',
            default => ucfirst($this->status)
        };
    }

    /** Obtener la clase CSS para el estado */
    public function getStatusClassAttribute()
    {
        return match($this->status) {
            'abierto' => 'bg-blue-100 text-blue-800',
            'en progreso' => 'bg-yellow-100 text-yellow-800',
            'resuelto' => 'bg-green-100 text-green-800',
            'cerrado' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /** Verificar si el ticket está asignado */
    public function isAssigned()
    {
        return !is_null($this->assigned_to);
    }

    /** Verificar si el ticket está disponible para asignar */
    public function isAvailable()
    {
        return is_null($this->assigned_to) && $this->status !== 'cerrado';
    }

    /** Verificar si el ticket es urgente */
    public function isUrgent()
    {
        return $this->priority === 'alta' && $this->status !== 'cerrado';
    }

    /** Scope: tickets disponibles para asignar */
    public function scopeAvailable($query)
    {
        return $query->whereNull('assigned_to')
            ->where('status', '!=', 'cerrado');
    }

    /** Scope: tickets urgentes */
    public function scopeUrgent($query)
    {
        return $query->where('priority', 'alta')
            ->where('status', '!=', 'cerrado');
    }
}
