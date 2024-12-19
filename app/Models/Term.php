<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable = [
        'contract_id',
        'title',
        'description',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
