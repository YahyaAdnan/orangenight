<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerSubscriptionResource\Pages;
use App\Filament\Resources\CustomerSubscriptionResource\RelationManagers;
use App\Models\CustomerSubscription;
use App\Models\Subscription;
use App\Models\Customer;
use App\Service\AddressService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Service\SubscriptionForm;

class CustomerSubscriptionResource extends Resource
{
    protected static ?string $model = CustomerSubscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(SubscriptionForm::form());
    }

    public static function getPluralModelLabel(): string
    {
        return __('customer_subscriptions');
    }

    public static function getModelLabel(): string
    {
        return __('subscriptions');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.full_name')
                    ->label(__('full_name'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subscription.title')
                    ->label(__('subscription'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('active')
                    ->label(__('active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('duration')
                    ->label(__('duration'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('created_at'))
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('subscription_id')
                    ->label(__('subscription'))
                    ->multiple()
                    ->options(Subscription::pluck('title', 'id')),

                Tables\Filters\SelectFilter::make('customer_id')
                    ->label(__('Customers'))
                    ->multiple()
                    ->options(Customer::pluck('full_name', 'id')),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('address_update')
                    ->label(__('edit') . ' ' . __('address'))
                    ->icon('heroicon-s-map-pin')
                    ->form(fn($record) => AddressService::form($record))
                    ->action(fn($record, $data) => AddressService::store($record, $data))
                    ->hidden(!auth()->user()->can('update CustomerSubscription')),
                Tables\Actions\Action::make('address')
                    ->label(__('address'))
                    ->icon('heroicon-s-map-pin')
                    ->disabled(fn($record) => $record->google_map_url == null)
                    ->action(fn($record) => redirect()->away($record->google_map_url))
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomerSubscriptions::route('/'),
            'create' => Pages\CreateCustomerSubscription::route('/create'),
            // 'edit' => Pages\EditCustomerSubscription::route('/{record}/edit'),
        ];
    }
}
