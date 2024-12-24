<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['title', 'category', 'amount', 'user_id'];

 
    public function user()
    {
        return $this->belongsTo(User::class);
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
