<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormInput extends Component
{

    /**
     * The name of input.
     *
     * @var string
     */
    public $idAndFor;

    /**
     * The currentName.
     *
     * @var string
     */
    public $lblName;

    /**
     * The currentName.
     *
     * @var string
     */
    public $inputValue;

    /**
     * The currentName.
     *
     * @var string
     */
    public $type;

    /**
     * The currentName.
     *
     * @var string
     */
    public $name;

    /**
     * Create the component instance.
     *
     * @param string $idAndFor
     * @param string $lblName
     * @param string $inputValue
     * @param string $type
     * @param string $name
     */
    public function __construct(string $idAndFor = "", string $lblName ="", string $inputValue = "", string $type = "", string $name = "")
    {
        $this->idAndFor = $idAndFor;
        $this->lblName = $lblName;
        $this->inputValue = $inputValue;
        $this->type = $type;
        $this->name = $name;
    }


    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('components.form.form-input');
    }
}
