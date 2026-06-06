<?php

namespace App\View\Components;

use App\Composer\SidebarComposer;
use Illuminate\View\Component;

class SidebarNavigation extends Component
{
    public $menus;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->menus = (new SidebarComposer())->getSidebarMenus();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar-navigation');
    }
}
