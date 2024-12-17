<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryStock extends Model
{
    protected $fillable = ['item_id', 'inventory_id', 'quantity'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
