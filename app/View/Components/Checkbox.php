<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Checkbox extends Component
{
    /**
     * The Attr name.
     *
     * @var string
     */
    public $name;

    /**
     * The Choices.
     *
     * @var array
     */
    public $choices;

    /**
     * The Required.
     *
     * @var boolean
     */
    public $required;

    /**
     * The Attr oldValue.
     *
     */
    public $oldValue;

    /**
     * The Attr Checked.
     *
     */
    public $checked;

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param array $choices
     * @param bool $required
     * @param Object $oldValue
     * @param bool $checked
     */
    public function __construct($name = '', $choices=[], $required=false, $oldValue= null,$checked=true)
    {
        $this->name = $name;
        $this->choices = $choices;
        $this->required = $required;
        $this->oldValue = $oldValue;
        $this->checked = $checked;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('admin.components.checkbox');
    }
}
