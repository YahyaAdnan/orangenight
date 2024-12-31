<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryResource\Pages;
use App\Filament\Resources\DeliveryResource\RelationManagers;
use App\Models\Delivery;
use App\Models\Item;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeliveryResource extends Resource
{
    protected static ?string $model = Delivery::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function getNavigationGroup(): string
    {
        return __('customers');
    }

    public static function getPluralModelLabel(): string
    {
        return __('delivery');
    }

    public static function getModelLabel(): string
    {
        return __('delivery');
    }

    // public static function canCreate(): bool
    // {
    //     return false;
    // }

    public static function form(Form $form): Form
    {
        // 'customer_id',
        // 'item_id',
        // 'quantity',
        // 'date',
        // 'status', // enum('pending','delivered','cancel')
        // 'google_map_url',
        // 'signature'
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->customer(__label('customer'))
                    ->required()
                    ->searchable()
                    ->columnSpanFull()
                    ->options(Customer::pluck('full_name', 'id')),
                Forms\Components\Select::make('item_id')
                    ->customer(__label('item'))
                    ->required()
                    ->searchable()
                    ->options(Item::pluck('title', 'id')),
                Forms\Components\TextInput::make('quantity')    
                    ->customer(__label('quantity'))
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(1000),
                Forms\Components\DatePicker::make('date')
                    ->customer(__label('date'))
                    ->required()
                    ->columnSpanFull()
                    ->native(false),              
                Forms\Components\TextInput::make('google_map_url')
                    ->label(__('Location URL'))
                    ->required()
                    ->url()
                    ->maxLength(128)
                    ->columnSpanFull()
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.full_name')
                    ->label(__('full_name'))
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('item.title')
                    ->label(__('item'))
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('quantity'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label(__('date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'cancel' => 'danger',
                        'delivered' => 'success',
                    })
                    ->formatStateUsing(fn (string $state) => __($state)),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('item_id')
                    ->label(__('items'))
                    ->multiple()
                    ->options(Item::pluck('title', 'id')),

                Tables\Filters\SelectFilter::make('customer_id')
                    ->label(__('customers'))
                    ->multiple()
                    ->options(Customer::pluck('full_name', 'id')),

                Tables\Filters\Filter::make('created_at')
                    ->label('')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label(__('From')),
                        Forms\Components\DatePicker::make('created_until')
                            ->default(now())
                            ->label(__('until')),
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
                Tables\Actions\Action::make('address')
                    ->label(__('address'))
                    ->icon('heroicon-s-map-pin')
                    ->color(fn($record) => $record->google_map_url == null ? 'danger' : 'info')
                    ->disabled(fn($record) => $record->google_map_url == null)
                    ->action(fn($record) => redirect()->away($record->google_map_url)),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListDeliveries::route('/'),
            'create' => Pages\CreateDelivery::route('/create'),
            // 'edit' => Pages\EditDelivery::route('/{record}/edit'),
        ];
    }
}
