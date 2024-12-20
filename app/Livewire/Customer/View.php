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
        $this->navigators = array('Deliveries', 'Inventory Movement', 'Stock', 'Subscription', 'Receipts');
    }

    public function render()
    {
        return view('livewire.customer.view');
    }
}
