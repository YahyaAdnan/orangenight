<?php

namespace App\Livewire;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Carbon\Carbon;
use App\Models\Delivery;
use App\Service\AddressService;


class DeliveriesRecent extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Delivery::where('status', 'pending')
                ->whereDate('date', '<', Carbon::now()->addWeek()->toDateString())
            )
            ->columns([
                Tables\Columns\TextColumn::make('customer.full_name')
                    ->label(__('customer'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('item.title')
                    ->label(__('item'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('quantity'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label(__('date'))
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('address')
                    ->label(__('address'))
                    ->icon('heroicon-s-map-pin')
                    ->color(fn($record) => $record->google_map_url == null ? 'danger' : 'info')
                    ->disabled(fn($record) => $record->google_map_url == null)
                    ->action(fn($record) => redirect()->away($record->google_map_url))
            ]); //TODO: When press make it return you to page of customer.
    }
}
