<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Expense extends Model
{
    protected $fillable = ['title', 'category', 'amount', 'user_id', 'note'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($expense) {
            $expense->user_id = Auth::id();
        });

        static::created(function ($expense) {
            $expense->transaction()->create([
                'user_id' => Auth::id(),
                'credit' => 0,  
                'debit' => $expense->amount,  
                'description' => $expense->title,
            ]);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }
    
    public static function categories()
    {
        return [
            'Salaries' => __('salaries'),
            'Importing' => __('importing'),
            'Exporting' => __('exporting'),
            'Logistics' => __('logistics'),
            'Transportation' => __('transportation'),
            'Storage' => __('storage'),
            'Office Rent' => __('office_rent'),
            'Utilities' => __('utilities'),
            'Equipment' => __('equipment'),
            'Marketing' => __('marketing'),
            'Commissions' => __('commissions'),
            'Taxes' => __('taxes'),
            'Insurance' => __('insurance'),
            'Legal Fees' => __('legal_fees'),
            'Miscellaneous' => __('miscellaneous'),
        ];
    }
}
