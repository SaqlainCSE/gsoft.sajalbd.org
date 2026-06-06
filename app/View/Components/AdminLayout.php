<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class AdminLayout extends Component
{
    public $title;
    public $logo;
    public $notifications;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title)
    {
        $this->title = $title;

        $this->logo = asset('images/ajra-logo.svg');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin-layout');
    }
}
