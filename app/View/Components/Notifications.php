<?php

namespace App\View\Components;

use Auth;
use Illuminate\View\Component;

class Notifications extends Component
{
    public $notifications = [];

    public function __construct()
    {
        $this->notifications = auth()->user()->unreadNotifications;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notifications');
    }
}
