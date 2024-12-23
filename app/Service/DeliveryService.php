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
        #TODO: if admin, then show all inventory_id of stocks that match.
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
        #TODO: if admin then all employees.
        $salesMan = SalesMan::where('user_id', Auth::id())->first();
        $stock = $salesMan->inventory->inventoryStock->where('item_id', $delivery->item_id)->first();

        //TODO: show all if admin
        if($stock == null) {return false;}

        return $stock->quantity >= $delivery->quantity;
    }

    public static function store(Delivery $delivery, $data)
    {
        $delivery->signature = $data['signature'];
        $delivery->status = 'delivered';
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