<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    
    protected $fillable = [
        'date',
        'customer_id',
        'user_id',
        'receipt_id',
        'items',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function deliveries()
    {
        return $this->morphMany(Delivery::class, 'deliverable');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
