<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Receipt;
use App\Models\Payment;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ReceiptTable extends BaseWidget
{
    public $model;

    public function mount(Model $model)
    {
        $this->model = $model;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Receipt::where('customer_id', $this->model->id)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paid')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('remaining')
                    ->numeric() //TODO: ADD REMAINING.
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.full_name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until')
                            ->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder{
                        if (!empty($data['created_from'])) {
                            $query->whereDate('created_at', '>=', $data['created_from']);
                        }

                        if (!empty($data['created_until'])) {
                            $query->whereDate('created_at', '<=', $data['created_until']);
                        }

                        return $query;
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('show')
                        ->label('show payment')
                        ->icon('heroicon-s-eye')
                        ->form(fn($record) => PaymentService::showReceipt($record->receipt))
                        ->modalCancelAction(false)
                        ->modalSubmitAction(false),

                    Tables\Actions\Action::make('create_payments')
                        ->label('Create Payments')
                        ->icon('heroicon-s-currency-dollar')
                        ->form(fn($record) => PaymentService::form($record->receipt))
                        ->action(fn($record, $data) => PaymentService::store($record->receipt, $data)),
                ]),
            ]);
    }
}
