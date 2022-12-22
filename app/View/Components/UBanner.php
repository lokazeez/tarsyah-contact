<?php

namespace App\View\Components;


use Illuminate\View\Component;
use Illuminate\View\View;

class UBanner extends Component
{


    /**
     * @var mixed|array
     */
    public $items;

    /**
     * @var mixed|integer
     */
    public $col;
    /**
     * @var mixed|integer
     */
    public $key;
    public function __construct($items = [], $col = 1 , $key=1)
    {
        $this->items = $items;
        $this->col = $col;
        $this->key = $key;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('front.components.u-banner');
    }
}
