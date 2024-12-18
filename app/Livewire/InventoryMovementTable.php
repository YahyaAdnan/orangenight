<?php

namespace App\Livewire;

use App\Models\InventoryMovement;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class InventoryMovementTable extends BaseWidget
{
    public $model, $inventory;

    public function mount(Model $model)
    {
        $this->model = $model;
        $this->inventory = $model->inventory;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                InventoryMovement::where('from_inventory_id', $this->inventory->id)
                    ->orWhere('to_inventory_id', $this->inventory->id)
            )
            ->columns([
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('item.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fromInventory.title')
                    ->badge()
                    ->color('danger')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('toInventory.title')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('Y-m-d h:ia')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }
}
