<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Payment extends Model
{
    protected $fillable = [
        'customer_id',
        'receipt_id',
        'total_amount',
        'paid',
        'returned',
        'note'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($payment) {
            $payment->transaction()->create([
                'user_id' => Auth::id(),
                'credit' => $payment->total_amount,  
                'debit' => 0,  
                'description' => $payment->customer->full_name,
            ]);
        });
    }


    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }
}
