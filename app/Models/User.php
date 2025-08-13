<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'id_employee',
        'department_id',
        'hire_date',
        'status',
        'empresa_id',
    ];

    // Relación con Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relación con Tickets
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'created_by');
    }

    // Relación con Tickets asignados
    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    // Relación con PC

    public function pc()
    {
        return $this->hasMany(Computer::class, 'assigned_user_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'empresa_id');
    }
}
