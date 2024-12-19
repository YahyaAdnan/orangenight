<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'title',
        'description',
        'duration',
        'contract_id',
        'active',
        'address',
        'price'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function subscriptionTerms()
    {
        return $this->hasMany(SubscriptionTerm::class);
    }
}
