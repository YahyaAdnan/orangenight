<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    
    public static function getNavigationGroup(): string
    {
        return __('financial');
    }

    public static function getPluralModelLabel(): string
    {
        return __('payments'); 
    }

    public static function getModelLabel(): string
    {
        return __('payment');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('note')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.full_name')
                    ->label(__('customer'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('receipt.title')
                    ->label(__('receipt'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label(__('total_amount'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paid')
                    ->label(__('paid'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('returned')
                    ->label(__('returned'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('note')
                    ->label(__('note'))
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
