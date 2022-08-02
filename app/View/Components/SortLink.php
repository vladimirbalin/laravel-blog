<?php

namespace App\View\Components;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class SortLink extends Component
{
    public $baseRouteName;
    public $sortBy;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($baseRouteName,
                                $sortBy)
    {
        $this->baseRouteName = $baseRouteName;
        $this->sortBy = $sortBy;
    }

    /**
     * Check if current sort is active.
     *
     * @param $value
     * @return bool
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function isActive($value)
    {
        $requestSort = request()->get('sort');
        list($requestSort, $value) = $this->stripMinuses($requestSort, $value);
        return $requestSort === $value;
    }

    private function stripMinuses(...$values)
    {
        foreach ($values as &$value) {
            if (Str::startsWith($value, '-')) {
                $value = Str::substr($value, 1);
            }
        }
        return $values;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sort-link');
    }
}
