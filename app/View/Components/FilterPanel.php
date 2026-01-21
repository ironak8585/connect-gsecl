<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FilterPanel extends Component
{
    public $fields;
    public $filters;
    public $route;

    /**
     * Create a new component instance.
     *
     * @param array $fields
     * @param array $filters
     * @param string $route
     * @return void
     */
    public function __construct($fields, $filters, $route)
    {
        $this->fields = $fields;
        $this->filters = $filters;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.system.filter-panel');
    }
}
