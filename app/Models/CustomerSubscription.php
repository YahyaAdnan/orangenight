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
        'duration',
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
        return $this->belongsTo(Subscription::class, 'subs_id');
    }

    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }
}
