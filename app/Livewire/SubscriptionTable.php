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
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->suffix(" Days")
                    ->sortable(),
                Tables\Columns\TextColumn::make('receipt.total_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('receipt.paid')
                    ->numeric()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('show')
                        ->label('show payment')
                        ->icon('heroicon-s-eye')
                        ->form(fn($record) => PaymentService::showReceipt($record->receipt))
                        ->modalCancelAction(false)
                        ->modalSubmitAction(false),

                    Tables\Actions\Action::make('generate_pdf')
                        ->label('Agreement PDF')
                        ->icon('heroicon-s-folder-arrow-down')
                        ->action(fn($record) => AgreementPDF::generatePDF($record->agreement))
                ])
            ]);
    }
}
