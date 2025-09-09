<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'nombre',
        'logo',
        'favicon',
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

    /**
     * Obtener la URL del logo de la empresa
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/app/public/logos/' . $this->logo);
        }
        return asset('logo.svg');
    }

    /**
     * Obtener la URL del favicon de la empresa
     */
    public function getFaviconUrlAttribute()
    {
        if ($this->favicon) {
            return asset('storage/app/public/favicons/' . $this->favicon);
        }

        // Si no tiene favicon específico, usar el logo como fallback
        if ($this->logo) {
            return asset('storage/app/public/logos/' . $this->logo);
        }

        return asset('favicon.ico');
    }
}
