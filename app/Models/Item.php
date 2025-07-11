<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'image',
        'title',
        'sku',
        'category_id',
        'note',
        'buying_price',
        'selling_price',
    ];

    /**
     * Relationship: Item belongs to a category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Relationship: Item has many inventory movements.
     */
    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class, 'item_id');
    }

    /**
     * Relationship: Item has many inventory stocks.
     */
    public function inventoryStocks()
    {
        return $this->hasMany(InventoryStock::class, 'item_id');
    }

    public function isDeletable()
    {
        if($this->inventoryStocks->isNotEmpty())
        {
            return false;
        }

        if($this->deliveries->isNotEmpty())
        {
            return false;
        }


        return true;
    }



    /**
     * Accessor to get the full image path.
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

}
