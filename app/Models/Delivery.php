<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    
    protected $fillable = [
        'deliverable_type',
        'deliverable_id',
        'customer_id',
        'item_id',
        'quantity',
        'date',
        'status', // enum('pending','delivered','cancel')
        'google_map_url',
        'signature',
        'signature_date'
    ];

    public function deliverable()
    {
        return $this->morphTo();
    }

    public function purchases()
    {
        return $this->belongsToMany(Purchase::class, 'delivery_purchase', 'delivery_id', 'purchase_id');
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
