<?php

namespace App\Livewire;

use App\Service\DistributionService;
use App\Service\MovingService;
use App\Service\DeleteService;
use App\Service\RefundService;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;
use App\Models\InventoryStock as InvSk;

class InventoryStock extends BaseWidget
{
    public $model, $inventory;
    public $class;

    public function mount(Model $model)
    {
        $this->model = $model;
        $this->inventory = $model->inventory;
        $this->class = basename(str_replace('\\', '/', get_class($model)));
    }

    protected function getTableHeading(): ?string
    {
        return __('stock');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                InvSk::where('inventory_id', $this->inventory->id)
            )
            ->columns([
                Tables\Columns\TextColumn::make('item.title')
                    ->label(__('item'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('inventory.title')
                    ->label(__('title'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('quantity'))
                    ->numeric()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('move')
                        ->label(__('move'))
                        ->icon('heroicon-s-truck')
                        ->form(fn($record) => MovingService::form($record))
                        ->action(fn(InvSk $invSk, $data) => MovingService::store($invSk, $data))
                        ->hidden(fn() => in_array($this->class, ['Customer'])),
                        // ->hidden(!auth()->user()->can('cancel Delivery'))
                    Tables\Actions\Action::make('distribution')
                        ->label(__('distribution'))
                        ->icon('heroicon-s-user')
                        ->form(fn($record) => DistributionService::form($record))
                        ->action(fn(InvSk $invSk, $data) => DistributionService::store($invSk, $data))
                        ->hidden(fn() => !in_array($this->class, ['Branch']) || !auth()->user()->can('distribution')),

                    Tables\Actions\Action::make('delete')
                        ->label(__('delete'))
                        ->icon('heroicon-s-trash')
                        ->form(fn($record) => DeleteService::form($record))
                        ->action(fn(InvSk $invSk, $data) => DeleteService::store($invSk, $data))
                        ->hidden(fn() => in_array($this->class, ['Customer', 'SalesMan'])),

                    Tables\Actions\Action::make('refund')
                        ->label(__('refund'))
                        ->icon('heroicon-s-arrow-left-end-on-rectangle')
                        ->form(fn($record) => RefundService::form($record))
                        ->action(fn(InvSk $invSk, $data) => RefundService::store($invSk, $data))
                        ->hidden(fn() => in_array($this->class, ['Branch', 'SalesMan']) || !auth()->user()->can('refund')),
                        
                ])->icon('heroicon-m-ellipsis-horizontal'),
            ]);
    }
}
