<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Message extends Component
{
    public $type;
    public $message;
    public $stocksName;

    public function __construct($type, $message, $stocksName = null)
    {
        $this->type = $type;
        $this->message = $message;
        $this->stocksName = $stocksName;
    }

    public function render()
    {
        return view('components.message');
    }
}
