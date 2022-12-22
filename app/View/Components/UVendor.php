<?php

namespace App\View\Components;


use Illuminate\View\Component;
use Illuminate\View\View;

class UVendor extends Component
{


    /**
     * @var mixed|string
     */
    public $item;

        /**
     * @var mixed|boolean
     */
    public $checked;
    


    public function __construct($item =null , $checked = false)
    {
        $this->item = $item;
        $this->checked = $checked;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('front.components.u-vendor');
    }
}
