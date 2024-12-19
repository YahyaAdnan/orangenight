<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    
    protected $fillable = [
        'customer_subscription_id',
        'customer_id',
        'item_id',
        'quantity',
        'date',
        'status', // enum('pending','delivered','cancel')
    ];

    public function customerSubscription()
    {
        return $this->belongsTo(CustomerSubscription::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
