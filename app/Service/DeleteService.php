<?php

namespace App\Service;

use App\Models\Inventory;
use App\Models\SalesMan;
use App\Models\InventoryStock;
use App\Models\InventoryMovement;
use Filament\Forms\Components;

class DeleteService
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
                Components\TextInput::make('item')
                    ->label('item')
                    ->default($record->item->title)
                    ->disabled(),
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

        $inventoryMovement = InventoryMovement::create([
            'item_id' =>  $inventoryStock->item_id,
            'from_inventory_id' => $inventoryStock->inventory_id,
            'quantity' => $data['quantity'],
            'type' => 'delete',
        ]);

        $inventoryStock->quantity = max($inventoryStock->quantity - $data['quantity'], 0);
        $inventoryStock->save();

    }
}