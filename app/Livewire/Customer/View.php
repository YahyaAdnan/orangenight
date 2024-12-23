<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Livewire\Component;

class View extends Component
{
    public $customer, $selected_nav, $navigators;

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
        $this->selected_nav = 0;
        $this->navigators = array(
            __('delivery'), 
            __('inventory_movements'), 
            __('stocks'), 
            __('subscription'), 
            __('receipts'), 
        );
    }

    public function render()
    {
        return view('livewire.customer.view');
    }
}
