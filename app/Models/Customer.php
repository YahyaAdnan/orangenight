<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'full_name',
        'address',
        'phone',
        'inventory_id',
        'note',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'phone' => 'array', // Allows storing/retrieving JSON as an array
    ];

    /**
     * Relationship with Inventory.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}
