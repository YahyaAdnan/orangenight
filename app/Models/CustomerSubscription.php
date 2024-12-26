<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerSubscription extends Model
{
    protected $table = 'customer_subscriptions';

    // Specify the fillable attributes
    protected $fillable = [
        'customer_id',
        'subscription_id',
        'agreement_id',
        'active',
        'address',
        'google_map_url',
        'duration',
        'receipt_id'
    ];

    // Specify casts for certain fields
    protected $casts = [
        'data' => 'array',
        'active' => 'boolean',
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    public function receipt()
    {
        return $this->belongsTo(Receipt::class, 'receipt_id');
    }
    
    public function deliveries()
    {
        return $this->morphMany(Delivery::class, 'deliverable');
    }

    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }
}
