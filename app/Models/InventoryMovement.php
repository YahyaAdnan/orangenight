<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class InventoryMovement extends Model
{
    protected $fillable = [
        'item_id',
        'from_inventory_id',
        'to_inventory_id',
        'quantity',
        'note',
        'type', //['move', 'sold', 'import', 'destruction', 
                //'delete', 'distribution', 'Delivery', 'refund']
        'user_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });
    }

    // Type constants for readability
    const TYPE_MOVE = 'move';
    const TYPE_SOLD = 'sold';
    const TYPE_IMPORT = 'import';
    const TYPE_DISTRIBUTION = 'distribution';
    const TYPE_DELETE = 'delete';

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function fromInventory()
    {
        return $this->belongsTo(Inventory::class, 'from_inventory_id');
    }

    public function toInventory()
    {
        return $this->belongsTo(Inventory::class, 'to_inventory_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
