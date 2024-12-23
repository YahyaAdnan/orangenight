<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceiptResource\Pages;
use App\Filament\Resources\ReceiptResource\RelationManagers;
use App\Models\Receipt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReceiptResource extends Resource
{
    protected static ?string $model = Receipt::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('receipts'); 
    }

    public static function canCreate(): bool
    {
        return false;
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('total_amount')
                    ->label(__('total_amount'))
                    ->required()
                    ->numeric()
                    ->disabled()
                    ->default(0.00),
                Forms\Components\TextInput::make('amount')
                    ->label(__('amount'))
                    ->required()
                    ->numeric()
                    ->disabled()
                    ->default(0.00),
                Forms\Components\TextInput::make('discount_amount')
                    ->label(__('discount_amount'))
                    ->required()
                    ->numeric()
                    ->minLength(0)
                    ->maxValue(fn(Receipt $receipt) => $receipt->amount - $receipt->paid)
                    ->default(0.00),
                Forms\Components\TextInput::make('paid')    
                    ->label('paid')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                Tables\Columns\TextColumn::make('remaining')
                    ->label(__('remaining'))
                    ->formatStateUsing(fn(Record $record) => $record->paid)
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
            'index' => Pages\ListReceipts::route('/'),
            'create' => Pages\CreateReceipt::route('/create'),
            'edit' => Pages\EditReceipt::route('/{record}/edit'),
        ];
    }
}
