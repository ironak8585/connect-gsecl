<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Route;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */

    public $pageTitle;
    public $breadcrumbs;

    public function __construct(string $pageTitle = "", array $breadcrumbs = [])
    {
        $this->pageTitle = ($pageTitle == '')
            ? ucwords(str_replace('-', ' ', str_replace('/', ' : ', Route::current()->uri)))
            : (trim(string: $pageTitle) == '' ? '' : ucwords($pageTitle));
        $this->breadcrumbs = $breadcrumbs;
    }

    public function render(): View
    {
        return view('layouts.app');
    }
}
