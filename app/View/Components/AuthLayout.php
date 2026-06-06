<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class AuthLayout extends Component
{
    public $title;
    public $logo;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title)
    {
        $this->title = $title;

        if (auth()->check() && auth()->user()->user_type === User::TYPE_SUPER_ADMIN) {
            $this->logo = asset('images/deslogy.png');
        } else if (auth()->check()) {
            $this->logo = Cache::rememberForever(@auth()->user()->branch_id . "_logo", function () {
                return auth()->user()->branch->getFirstMediaUrl('logo');
            });
        } else {
            $this->logo = asset('images/deslogy.png');
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.auth-layout');
    }
}
