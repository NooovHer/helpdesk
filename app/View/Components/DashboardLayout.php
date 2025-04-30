<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardLayout extends Component
{
    public $title;

    public function __construct($title = 'Mi Panel')
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('components.dashboard-layout');
    }
}