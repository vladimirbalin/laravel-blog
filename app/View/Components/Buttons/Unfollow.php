<?php

namespace App\View\Components\Buttons;

use Illuminate\View\Component;

class Unfollow extends Component
{
    public $routeName;
    public $userId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($routeName, $userId)
    {
        $this->routeName = $routeName;
        $this->userId = $userId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.buttons.unfollow');
    }
}
