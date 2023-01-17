<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\View;

class SortLink extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public $baseRouteName,
        public $sortBy
    )
    {
    }

    /**
     * Check if current sort is active.
     *
     * @param $value
     * @return bool
     */
    public function isActive($value): bool
    {
        $requestSort = Request::get('sort');
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
     * @return View
     */
    public function render(): View
    {
        return view('components.sort-link');
    }
}
