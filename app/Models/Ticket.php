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
}
