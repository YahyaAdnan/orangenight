<?php

namespace App\Service;

use App\Models\SalesMan;
use App\Models\Delivery;
use App\Models\InventoryMovement;
use App\Models\InventoryStock;
use Filament\Forms\Components;
use Coolsam\SignaturePad\Forms\Components\Fields\SignaturePad;
use Illuminate\Support\Facades\Auth;

class DeliveryService
{

    public static function form($record)
    {
        return [
            SignaturePad::make('signature')
                    ->hideDownloadButtons()
                    ->columnSpanFull(),
            Components\TextInput::make('note')
                ->label(__('note'))
                ->maxLength(64),
        ];
    }

    public static function deliverable(Delivery $delivery)
    {
        if($delivery->status == 'delivered') {return false;}

        $salesMan = SalesMan::where('user_id', Auth::id())->first();

        try {
            $stock = $salesMan->inventory->inventoryStock->where('item_id', $delivery->item_id)->first();
        } catch (\Throwable $th) {
            return false;
        }

        if($stock == null) {return false;}

        return $stock->quantity >= $delivery->quantity;
    }

    public static function store(Delivery $delivery, $data)
    {
        $delivery->signature = $data['signature'];
        $delivery->status = 'delivered';
        $delivery->signature_date = now();
        $delivery->save();

        $salesMan = SalesMan::where('user_id', Auth::id())->first();

        $inventoryMovement = InventoryMovement::create([
            'item_id' => $delivery->item_id,
            'from_inventory_id' => $salesMan->inventory_id,
            'to_inventory_id' => $delivery->customer->inventory_id,
            'quantity' => $delivery->quantity,
            'note' => $data['note'],
            'type' => 'Delivery',
        ]);

        $senderInventoryStock = InventoryStock::firstOrCreate([
            'item_id' =>  $delivery->item_id,
            'inventory_id' => $salesMan->inventory_id,
        ]);

        $senderInventoryStock->quantity = max(0, $senderInventoryStock->quantity - $delivery->quantity);
        $senderInventoryStock->save();

        $reciverInventoryStock = InventoryStock::firstOrCreate([
            'item_id' =>  $delivery->item_id,
            'inventory_id' => $delivery->customer->inventory_id,
        ]);

        $reciverInventoryStock->quantity += $delivery->quantity;
        $reciverInventoryStock->save();

        return $inventoryMovement;
    }
}