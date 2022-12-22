<?php

namespace App\View\Components;


use Illuminate\View\Component;
use Illuminate\View\View;

class USingelBanner extends Component
{


    /**
     * @var mixed|array
     */
    public $banner;
    public function __construct($banner = [])
    {

        $this->banner = $banner;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('front.components.u-singel-banner');
    }
}
