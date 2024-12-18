<?php

namespace App\Service;

use App\Models\Inventory;
use App\Models\Branch;
use App\Models\InventoryStock;
use App\Models\InventoryMovement;
use Filament\Forms\Components;

class MovingService
{

    public static function form($record)
    {
        return [
            Components\Grid::make([
                'default' => 2,
                'sm' => 1,
                'md' => 2
            ])
            ->schema([
                Components\Select::make('inventory_id')
                    ->required()
                    ->searchable()
                    ->options(Branch::whereNot('inventory_id', $record->inventory_id)->pluck('title', 'inventory_id')),
                Components\TextInput::make('quantity')
                    ->minValue(1)
                    ->maxValue($record->quantity)
                    ->numeric()
                    ->required()
            ])
        ];
    }

    public static function store(InventoryStock $inventoryStock, $data)
    {
        $receivedInventoryStock = InventoryStock::firstOrCreate([
            'item_id' => $inventoryStock->item_id,
            'inventory_id' => $data['inventory_id'],
        ]);

        $inventoryMovement = InventoryMovement::create([
            'item_id' =>  $inventoryStock->item_id,
            'from_inventory_id' => $inventoryStock->inventory_id,
            'to_inventory_id' => $data['inventory_id'],
            'quantity' => $data['quantity'],
            'type' => 'move',
        ]);

        $inventoryStock->quantity = max($inventoryStock->quantity - $data['quantity'], 0);
        $inventoryStock->save();

        $receivedInventoryStock->quantity += $data['quantity'];
        $receivedInventoryStock->save();
    }
}