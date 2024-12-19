<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionTerm extends Model
{
    protected $fillable = [
        'subscription_id',
        'item_id',
        'quantity',
        'day',
    ];

    // Define the relationship to the Subscription model
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    // Define the relationship to the Item model
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
