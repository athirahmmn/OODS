<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Notification extends Component
{
    public $type;
    public $message;
    public $orderId;

    public function __construct($type, $message, $orderId = null)
    {
        $this->type = $type;
        $this->message = $message;
        $this->orderId = $orderId;
    }

    public function render()
    {
        return view('components.notification');
    }
}
