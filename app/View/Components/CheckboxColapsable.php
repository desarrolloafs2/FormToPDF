<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CheckboxColapsable extends Component
{
    public string $id;
    public string $label;
    public bool $required;

    public function __construct(string $id, string $label, bool $required = false)
    {
        $this->id = $id;
        $this->label = $label;
        $this->required = $required;
    }

    public function render()
    {
        return view('components.checkbox-colapsable');
    }
}

