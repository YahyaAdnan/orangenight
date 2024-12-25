<?php

namespace App\Service;

use App\Models\SalesMan;
use App\Models\Delivery;
use App\Models\InventoryMovement;
use Filament\Forms\Components;
use Coolsam\SignaturePad\Forms\Components\Fields\SignaturePad;
use Illuminate\Support\Facades\Auth;

class CancelDeliveryService
{
    public static function cancelable(Delivery $delivery)
    {
        if($delivery->status == 'delivered') {return false;}

        return true;
    }

    public static function store(Delivery $delivery)
    {
        $delivery->status = 'cancel'; 
        $delivery->save();

        return $delivery;

    }
}