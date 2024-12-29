<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCategory extends Model
{
    protected $fillable = [
        'name',
    ];


    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_customer_categories');
    }

}
