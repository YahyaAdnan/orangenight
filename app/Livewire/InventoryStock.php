<?php

namespace App\Livewire;

use App\Service\DistributionService;
use App\Service\MovingService;
use App\Service\ImportService;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;
use App\Models\InventoryStock as InvSk;

class InventoryStock extends BaseWidget
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
                InvSk::where('inventory_id', $this->inventory->id)
            )
            ->columns([
                Tables\Columns\TextColumn::make('item.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('inventory.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('move')
                        ->label('move')
                        ->icon('heroicon-s-truck')
                        ->form(fn($record) => MovingService::form($record))
                        ->action(fn(InvSk $invSk, $data) => MovingService::store($invSk, $data)),
                    Tables\Actions\Action::make('distribution')
                        ->label('distribution')
                        ->icon('heroicon-s-user')
                        ->form(fn($record) => DistributionService::form($record))
                        ->action(fn(InvSk $invSk, $data) => DistributionService::store($invSk, $data)),
                ])->icon('heroicon-m-ellipsis-horizontal'),
            ]);
    }
}
