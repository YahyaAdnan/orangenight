<?php

namespace App\Livewire;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Carbon\Carbon;
use App\Models\Delivery;

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
            ]); //TODO: When press make it return you to page of customer.
    }
}
