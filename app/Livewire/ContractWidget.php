<?php

namespace App\Livewire;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\User;
use App\Service\SubscriptionForm;
use App\Service\PurchaseService;

class ContractWidget extends BaseWidget
{
    protected function getTableHeading(): ?string
    {
        return ""; // Removes the table heading
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
            )
            ->columns([
            ])
            ->headerActions([
                Tables\Actions\Action::make('subscription')
                    ->label(__('create') . ' ' . __('subscription'))
                    ->icon('heroicon-s-user')
                    ->form(fn() => SubscriptionForm::form())
                    ->action(fn($data) => SubscriptionForm::store($data))
                    ->hidden(!auth()->user()->can('create Subscription')),
                Tables\Actions\Action::make('purchase')
                    ->label(__('purchase'))
                    ->icon('heroicon-s-currency-dollar')
                    ->form(fn() => PurchaseService::form())
                    ->action(fn($data) => PurchaseService::store($data))
                    ->hidden(!auth()->user()->can('create Purchase')),
            ])
            ->paginated(false);
    }
}
