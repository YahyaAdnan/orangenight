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
                    ->label(__('item'))
                    ->default($record->item->title)
                    ->disabled(),
                Components\TextInput::make('quantity')
                    ->label(__('quantity'))
                    ->minValue(1)
                    ->maxValue($record->quantity)
                    ->numeric()
                    ->required(),
                Components\TextInput::make('note')
                    ->label(__('note'))
                    ->maxLength(64)
                    ->required()
                    ->columnSpanFull()
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
            'note' => $data['note']
        ]);

        $inventoryStock->quantity = max($inventoryStock->quantity - $data['quantity'], 0);
        $inventoryStock->save();

    }
}