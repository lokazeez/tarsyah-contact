<?php

namespace App\View\Components;


use Illuminate\View\Component;
use Illuminate\View\View;

class UCategory extends Component
{


    /**
     * @var mixed|string
     */
    public $item;

    public function __construct($item = null)
    {
        $this->item = $item;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('front.components.u-category');
    }
}
