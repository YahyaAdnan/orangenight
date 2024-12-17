<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'title', 
        'inventory_id'
    ];

    /**
     * Get the inventory associated with this branch.
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

}
