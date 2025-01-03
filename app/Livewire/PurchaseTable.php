<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Purchase;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PurchaseTable extends BaseWidget
{
    public $customer, $inventory;

    // 'date',
    // 'customer_id',
    // 'user_id',
    // 'receipt_id',
    // 'items',

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
    }

    protected function getTableHeading(): ?string
    {
        return '';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Purchase::where('customer_id', $this->customer->id)
            )
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label(__('date'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.full_name')
                    ->label(__('customer'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('sales_man'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('receipt.total_amount')
                    ->label(__('total_amount'))
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('print')
                    ->label(__('PDF'))
                    ->icon('heroicon-s-printer')
                    ->action(fn($record) => redirect()->route('purchase.show', ['purchase' => $record->id])),
            ]);
    }
}
