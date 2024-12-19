<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'title',
        'code',
        'total_amount',
        'discount_amount',
        'amount',
        'paid',
        // 'total',
        'customer_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function user()
    {
        return $this->hasOne(CustomerSubscription::class);
    }
}
