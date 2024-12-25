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
                    ->label(__('item'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('quantity'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label(__('date'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'cancel' => 'danger', 
                        'delivered' => 'success',
                    })
                    ->formatStateUsing(fn($state) => __($state))
                    ->sortable(),
                Tables\Columns\ImageColumn::make('signature')
                    ->label(__('status'))
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('status'))
                    ->multiple()
                    ->options([
                        'pending' => 'pending',
                        'cancel' => 'cancel',
                        'delivered' => 'delivered',
                    ])
                    ->default(['pending'])
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('move')
                        ->label(__('move'))
                        ->icon('heroicon-s-truck')
                        ->form(fn($record) => DeliveryService::form($record))
                        ->action(fn(Delivery $record, $data) => DeliveryService::store($record, $data))
                        ->disabled(fn($record) => !DeliveryService::deliverable($record)),
                    Tables\Actions\Action::make('cancel')
                        ->label(__('cancel'))
                        ->icon('heroicon-s-backspace')
                        ->action(fn(Delivery $record, $data) => CancelDeliveryService::store($record))
                        ->disabled(fn($record) => !CancelDeliveryService::cancelable($record))
                        ->requiresConfirmation(),
                ])
            ]);
    }
}
