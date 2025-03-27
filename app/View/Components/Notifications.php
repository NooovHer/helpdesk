<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Notification;

class Notifications extends Component
{
    public $notifications;

    public function __construct()
    {
        // Asume que tienes un modelo de Notificación
        $this->notifications = Notification::recent()->limit(2)->get();
    }

    public function render()
    {
        return view('components.notifications');
    }
}
