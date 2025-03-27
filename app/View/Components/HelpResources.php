<?php

namespace App\View\Components;

use Illuminate\View\Component;

class HelpResources extends Component
{
    public $resources;

    public function __construct()
    {
        $this->resources = [
            [
                'icon' => 'book',
                'text' => 'Base de Conocimientos',
                'link' => route('knowledge.base')
            ],
            [
                'icon' => 'video',
                'text' => 'Tutoriales',
                'link' => route('tutorials')
            ],
            [
                'icon' => 'headset',
                'text' => 'Contactar Soporte',
                'link' => route('support.contact')
            ]
        ];
    }

    public function render()
    {
        return view('components.help-resources');
    }
}
