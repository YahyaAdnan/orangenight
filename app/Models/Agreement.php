<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    protected $table = 'agreements';

    // Specify the fillable attributes (fields that can be mass-assigned)
    protected $fillable = [
        'customer_id',
        'user_id',
        'data',
        'customer_signature',
        'salesman_signature',
        'note',
        'status',
        'agreement_date',
    ];

    protected $casts = [
        'data' => 'array', 
        'agreement_date' => 'date', 
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
