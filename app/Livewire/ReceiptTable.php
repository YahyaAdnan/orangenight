<?php

namespace App\Livewire;

use App\Service\PaymentService;
use App\Models\Customer;
use App\Models\Receipt;
use App\Models\Payment;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ReceiptTable extends BaseWidget
{
    public $model;

    public function mount(Model $model)
    {
        $this->model = $model;
    }

    protected function getTableHeading(): ?string
    {
        return __('receipts');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Receipt::where('customer_id', $this->model->id)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->label(__('code'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label(__('total_amount'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label(__('amount'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_amount')
                    ->label(__('discount_amount'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paid')
                    ->label(__('paid'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.full_name')
                    ->label(__('customer'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label(__('from')),
                        Forms\Components\DatePicker::make('created_until')
                            ->label(__('to'))
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
                        ->form(fn($record) => PaymentService::showReceipt($record))
                        ->modalCancelAction(false)
                        ->modalSubmitAction(false),

                    Tables\Actions\Action::make('create_payments')
                        ->label('Create Payments')
                        ->icon('heroicon-s-currency-dollar')
                        ->form(fn($record) => PaymentService::form($record))
                        ->action(fn($record, $data) => PaymentService::store($record, $data))
                        ->disabled(fn($record) => $record->total_amount == $record->paid),
                ]),
            ]);
    }
}
