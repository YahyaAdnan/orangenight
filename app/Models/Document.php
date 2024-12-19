<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title',
        'image',
        'documentable_id',
        'documentable_type',
    ];

    /**
     * Polymorphic relationship.
     */
    public function documentable()
    {
        return $this->morphTo();
    }
}
