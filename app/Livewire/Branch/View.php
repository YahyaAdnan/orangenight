<?php

namespace App\Livewire\Branch;

use App\Models\Branch;
use Livewire\Component;

class View extends Component
{
    public $branch, $selected_nav, $navigators;

    public function mount(Branch $branch)
    {
        $this->branch = $branch;
        $this->selected_nav = 0;
        $this->navigators = array('Stock', 'Inventory Movement');
    }


    public function render()
    {
        return view('livewire.branch.view', ['abc' => 'abc']);
    }
}
