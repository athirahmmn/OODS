<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public $type;
    public $message;
    public $icon;
    public $title;

    public function __construct($type, $message, $icon = 'info', $title = 'Notification')
    {
        $this->type = $type;
        $this->message = $message;
        $this->icon = $icon;
        $this->title = $title;
    }

    public function render()
    {
        return view('components.alert');
    }
}
