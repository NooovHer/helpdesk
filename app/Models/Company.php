<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'nombre',
        'direccion',
        'ciudad',
        'email',
        'telefono',
        'rfc',
        'activo',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
