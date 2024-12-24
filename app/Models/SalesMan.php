<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesMan extends Model
{

    protected $fillable = [
        'full_name', 
        'user_id', 
        'inventory_id', 
        'phone', 
        'note'
    ];

    protected $casts = [
        'phone' => 'array',
    ];
    
    /**
     * Get the inventory associated with this salesperson.
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    /**
     * Get the user associated with this salesperson.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_salesman', 'salesman_id', 'customer_id');
    }


    public function isDeletable()
    {
        return false;
    }
    
}
