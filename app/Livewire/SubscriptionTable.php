<?php

namespace App\Livewire;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\CustomerSubscription;

class SubscriptionTable extends BaseWidget
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
                CustomerSubscription::where('customer_id', $this->model->id)
            )
            ->columns([
                Tables\Columns\TextColumn::make('subscription.title')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->suffix("days")
                    ->sortable(),
            ]);

            // 'customer_id',
            // 'subscription_id',
            // 'agreement_id',
            // 'active',
            // 'address',
            // 'duration',
            // 'receipt_id'
    }
}
