<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalesManResource\Pages;
use App\Filament\Resources\SalesManResource\RelationManagers;
use App\Models\SalesMan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalesManResource extends Resource
{
    protected static ?string $model = SalesMan::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getNavigationGroup(): string
    {
        return __('sales_men'); 
    }

    public static function getPluralModelLabel(): string
    {
        return __('sales_men'); 
    }

    public static function getModelLabel(): string
    {
        return __('sales_man');
    }

    public static function form(Form $form): Form
    {
        // 'full_name', 
        // 'user_id', 
        // 'inventory_id', 
        // 'phone', 
        // 'note'

        return $form
            ->schema([
                Forms\Components\TextInput::make('full_name')
                    ->label(__('full_name'))
                    ->minLength(4)
                    ->maxLength(32)
                    ->required(),
                Forms\Components\TextInput::make('user_name')
                    ->label(__('username'))
                    ->suffix("@ayman.electronics")
                    ->minLength(4)
                    ->maxLength(32)
                    ->required()
                    ->visibleOn('create'),
                Forms\Components\TextInput::make('password')
                    ->label(__('password'))
                    ->password()
                    ->minLength(6)
                    ->maxLength(32)
                    ->required()
                    ->visibleOn('create'),
                Forms\Components\TextInput::make('note')
                    ->label(__('note'))
                    ->maxLength(64),
                Forms\Components\Repeater::make('phone')
                    ->label(__('phone')) 
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label(__('phone')) 
                            ->columnSpanFull()
                            ->required()
                            ->rule('regex:/^07\d{9}$/'), //IRAQ NUMBER ONLY.
                    ])
                    ->minItems(1),
                    //TODO: MAKE DELETE DISABLED.
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label(__('full_name')) 
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSalesMen::route('/'),
            'create' => Pages\CreateSalesMan::route('/create'),
            'view' => Pages\SalesManView::route('/{record}'),
            'edit' => Pages\EditSalesMan::route('/{record}/edit'),
        ];
    }
}
