<?php

namespace App\Livewire\SalesMan;

use App\Models\SalesMan;
use Livewire\Component;

class View extends Component
{
    public $salesMan, $selected_nav, $navigators;

    public function mount(SalesMan $salesMan)
    {
        $this->salesMan = $salesMan;
        $this->selected_nav = 0;
        $this->navigators = array('Stock', 'Inventory Movement');
    }


    public function render()
    {
        return view('livewire.sales-man.view');
    }
}
