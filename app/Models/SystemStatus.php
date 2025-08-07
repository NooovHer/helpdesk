<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'status',
        'description',
        'last_updated'
    ];

    protected $casts = [
        'last_updated' => 'datetime',
    ];

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'operational' => 'green',
            'degraded' => 'yellow',
            'outage' => 'red',
            'maintenance' => 'blue',
            default => 'gray'
        };
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'operational' => 'Operativo',
            'degraded' => 'Degradado',
            'outage' => 'Fuera de Servicio',
            'maintenance' => 'Mantenimiento',
            default => 'Desconocido'
        };
    }

    public function getStatusIconAttribute()
    {
        return match($this->status) {
            'operational' => 'fas fa-check-circle',
            'degraded' => 'fas fa-exclamation-triangle',
            'outage' => 'fas fa-times-circle',
            'maintenance' => 'fas fa-tools',
            default => 'fas fa-question-circle'
        };
    }

    public function logs()
    {
        return $this->hasMany(SystemStatusLog::class);
    }
}
