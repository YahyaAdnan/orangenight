<?php

namespace App\Livewire;

use App\Service\PaymentService;
use App\Service\AgreementPDF;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\CustomerSubscription;
use Illuminate\Database\Eloquent\Model;

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
                    ->label(__('subscription'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label(__('duration'))
                    ->suffix(" Days")
                    ->sortable(),
                Tables\Columns\TextColumn::make('receipt.total_amount')
                    ->label(__('total_amount'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('receipt.paid')
                    ->label(__('paid'))
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('show')
                        ->label(__('show') . ' ' . __('payments'))
                        ->icon('heroicon-s-eye')
                        ->form(fn($record) => PaymentService::showReceipt($record->receipt))
                        ->modalCancelAction(false)
                        ->modalSubmitAction(false),

                    Tables\Actions\Action::make('create_payments')
                        ->label(__('create') . ' ' . __('payments'))
                        ->icon('heroicon-s-currency-dollar')
                        ->form(fn($record) => PaymentService::form($record->receipt))
                        ->action(fn($record, $data) => PaymentService::store($record->receipt, $data)),
                        
                    Tables\Actions\Action::make('generate_pdf')
                        ->label('PDF')
                        ->icon('heroicon-s-folder-arrow-down')
                        ->action(fn($record) => AgreementPDF::generatePDF($record->agreement)),
                ])
            ]);
    }
}
