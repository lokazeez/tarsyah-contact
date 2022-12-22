<?php

namespace App\View\Components;


use Illuminate\View\Component;
use Illuminate\View\View;

class UMaster extends Component
{


    /**
     * @var mixed|string
     */
    public $title;

    public function __construct($title = 'home')
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('front.components.u-master');
    }
}
