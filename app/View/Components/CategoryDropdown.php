<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CategoryDropdown extends Component
{
    public $categoryDropdown;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($categoryDropdown)
    {
        $this->categoryDropdown = $categoryDropdown;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.category-dropdown');
    }
}
