<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relación con Users
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relación con Tickets (opcional)
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
