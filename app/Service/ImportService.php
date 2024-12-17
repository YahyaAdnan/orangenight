<?php

namespace App\Service;

use App\Models\Branch;
use App\Models\InventoryMovement;
use App\Models\Item;
use App\Models\InventoryStock;
use Filament\Forms\Components;

class ImportService
{

    public static function form($records)
    {
        $bulk = $records != null;

        return [
            Components\Select::make('inventory_id')
                ->options(Branch::pluck('title', 'inventory_id'))
                ->searchable()
                ->required(),
            Components\Repeater::make('records')
                ->label('Item')
                ->schema([
                    Components\Grid::make([
                        'default' => 2,
                        'sm' => 1,
                        'md' => 2
                    ])
                    ->schema([
                        $bulk ? Components\Hidden::make('item_id') 
                            :   Components\Select::make('item_id')
                                    ->options(Item::pluck('title', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                        Components\TextInput::make('title')
                            ->disabled()
                            ->hidden(!$bulk),
                        Components\TextInput::make('quantity')
                            ->required()
                            ->numeric(),
                    ])
                ])
                ->default(
                    $bulk ? $records->map(fn ($record) => [
                            'item_id' => $record->id,
                            'title' => $record->title,
                        ])->toArray() : array()
                )
                ->addable(!$bulk)
                ->deletable(!$bulk),
        ];
    }

    public static function store($data)
    {
        foreach($data['records'] as $record)
        {
            $inventoryStock = InventoryStock::firstOrCreate([
                    'item_id' => $record['item_id'],
                    'inventory_id' => $data['inventory_id'],
                ]);

            $inventoryMovement = InventoryMovement::create([
                'item_id' =>  $record['item_id'],
                'to_inventory_id' => $data['inventory_id'],
                'quantity' => $record['quantity'],
                'type' => 'import',
            ]);

            $inventoryStock->quantity += $record['quantity'];
            $inventoryStock->save();
        }
    }
}