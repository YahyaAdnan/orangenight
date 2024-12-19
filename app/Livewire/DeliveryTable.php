<?php

namespace App\Livewire;

use App\Models\Delivery;
use App\Service\DeliveryService;
use App\Service\CancelDeliveryService;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class DeliveryTable extends BaseWidget
{
    public $model, $inventory;

    public function mount(Model $model)
    {
        $this->model = $model;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Delivery::where('customer_id', $this->model->id)
            )
            ->columns([
                Tables\Columns\TextColumn::make('item.title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deliverable.title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'cancel' => 'danger', //TODO: make it canceled
                        'delivered' => 'success',
                    })
                    ->sortable(),
                Tables\Columns\ImageColumn::make('signature')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->multiple()
                    ->options([
                        'pending' => 'pending',
                        'cancel' => 'cancel', //TODO: change.
                        'delivered' => 'delivered',
                    ])
                    ->default(['pending'])
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('move')
                        ->label('move')
                        ->icon('heroicon-s-truck')
                        ->form(fn($record) => DeliveryService::form($record))
                        ->action(fn(Delivery $record, $data) => DeliveryService::store($record, $data))
                        ->disabled(fn($record) => !DeliveryService::deliverable($record)),
                    Tables\Actions\Action::make('cancel')
                        ->label('cancel')
                        ->icon('heroicon-s-backspace')
                        ->action(fn(Delivery $record, $data) => CancelDeliveryService::store($record))
                        ->disabled(fn($record) => !CancelDeliveryService::cancelable($record))
                        ->requiresConfirmation(),
                ])
            ]);
    }
}
