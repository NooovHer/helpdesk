<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'system_status_id',
        'user_id',
        'status',
        'description',
        'changed_at',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function systemStatus()
    {
        return $this->belongsTo(SystemStatus::class);
    }
}
