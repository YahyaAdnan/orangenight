<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'title', 
        'inventory_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($branch) {
            $inventory = Inventory::create(['title' => $branch->title]);
            $branch->inventory_id = $inventory->id;
        });


        static::updating(function ($branch) {
            if ($branch->isDirty('title')) {
                $branch->inventory()->update(['title' => $branch->title]);
            }
        });
    }

    /**
     * Get the inventory associated with this branch.
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

}
