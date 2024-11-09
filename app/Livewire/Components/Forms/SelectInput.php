<?php

namespace App\Livewire\Components\Forms;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class SelectInput extends Component
{
    #[Modelable]
    public $value;
    public $valueLabel;
    public $search;
    public $disabled       = false;
    public $searchFunction;
    #[Reactive]
    public $options = [];
    public function updatedSearch($keywords)
    {
        $this->dispatch(
            $this->searchFunction,
            $keywords
        );
    }
    public function setValue($value, $valueLabel)
    {
        $this->value      = $value;
        $this->valueLabel = $valueLabel;
    }
    public function getValueLabel()
    {
        if (! $this->value)
            return;
        return $this->valueLabel
            ? $this->valueLabel
            : collect($this->options)->firstWhere(
                'id',
                $this->value
            )['name'];
    }
    public function render()
    {
        return view('livewire.components.forms.select-input');
    }
}
