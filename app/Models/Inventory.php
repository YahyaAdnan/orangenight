<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{

    protected $fillable = [
        'title'
    ];

    /**
     * Get the branches associated with this inventory.
     */
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function inventoryStock()
    {
        return $this->hasMany(InventoryStock::class);
    }


    /**
     * Get the salesmen associated with this inventory.
     */
    public function salesMen()
    {
        return $this->hasMany(SalesMan::class);
    }
}
