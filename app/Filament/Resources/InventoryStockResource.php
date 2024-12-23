<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryStockResource\Pages;
use App\Filament\Resources\InventoryStockResource\RelationManagers;
use App\Models\InventoryStock;
use App\Models\Branch;
use App\Models\SalesMan;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InventoryStockResource extends Resource
{
    protected static ?string $model = InventoryStock::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('stocks');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('inventory.title')
                    ->label(__('stock'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('item.title')
                    ->label(__('item'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('quantity'))
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('filter')
                    ->label('')
                    ->form([
                        Forms\Components\Select::make('model')
                            ->label(__('stock'))
                            ->native(false)
                            ->options([
                                "0" => "Customer", //TODO: OPTIONS TO mylti lang 
                                "1" => "Branch",
                                "2" => "Sales Man"
                            ])
                            ->live(),
                        Forms\Components\Select::make('inventory_id')
                            ->label('')
                            ->searchable()
                            ->options(function(Get $get) {
                                if($get("model") == "0") {return Customer::pluck('full_name', 'inventory_id');}
                                if($get("model") == "1") {return Branch::pluck('title', 'inventory_id');}
                                if($get("model") == "2") {return SalesMan::pluck('full_name', 'inventory_id');}
                            }),
                    ])
                    ->query(function (Builder $query, array $data): Builder{
                        if (!empty($data['model'])) {
                            switch ($data['model']) {
                                case '0':
                                    $query->whereIn('inventory_id', Customer::pluck('inventory_id'));
                                    break;
                                case '1':
                                    $query->whereIn('inventory_id', Branch::pluck('inventory_id'));
                                    break;   
                                case '2':
                                    $query->whereIn('inventory_id', SalesMan::pluck('inventory_id'));
                                    break;                         
                                default:
                                    break;
                            }
                        }
    
                        if (!empty($data['inventory_id'])) {
                            $query->where('inventory_id', $data['inventory_id']);
                        }
    
                        return $query;
                    }),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListInventoryStocks::route('/'),
            // 'create' => Pages\CreateInventoryStock::route('/create'),
            // 'edit' => Pages\EditInventoryStock::route('/{record}/edit'),
        ];
    }
}
