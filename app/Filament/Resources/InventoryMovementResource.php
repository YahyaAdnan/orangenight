<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryMovementResource\Pages;
use App\Filament\Resources\InventoryMovementResource\RelationManagers;
use App\Models\InventoryMovement;
use App\Service\ImportService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InventoryMovementResource extends Resource
{
    protected static ?string $model = InventoryMovement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getPluralModelLabel(): string
    {
        return __('inventory_movements');
    }

    public static function getModelLabel(): string
    {
        return __('movement');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label(__('type'))
                    ->formatStateUsing(fn (string $state): string => __("$state")),
                Tables\Columns\TextColumn::make('item.title')
                    ->label(__('item'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fromInventory.title')
                    ->label(__('from'))
                    ->badge()
                    ->color('danger')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('toInventory.title')
                    ->label(__('to'))
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('quantity'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('full_name'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('created_at'))
                    ->dateTime('Y-m-d h:ia')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->multiple()
                    ->options(InventoryMovement::statuses()),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make(_('created_from')),
                        Forms\Components\DatePicker::make(_('created_until'))
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
            ->headerActions([
                Tables\Actions\Action::make('import')
                    ->form(ImportService::form(null))
                    ->action(fn($data) => ImportService::store($data))
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
            'index' => Pages\ListInventoryMovements::route('/'),
            // 'create' => Pages\CreateInventoryMovement::route('/create'),
            'edit' => Pages\EditInventoryMovement::route('/{record}/edit'),
        ];
    }
}
