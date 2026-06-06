<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ApplicationLogo extends Component
{
    public $logo;

    public function __construct()
    {
        $this->logo = asset('images/deslogy.png');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.application-logo');
    }
}
