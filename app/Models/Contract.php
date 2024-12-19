<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'title',
        'description',
    ];

        public function terms()
    {
        return $this->hasMany(Term::class);
    }

}
