<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalesManResource\Pages;
use App\Filament\Resources\SalesManResource\RelationManagers;
use App\Models\SalesMan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalesManResource extends Resource
{
    protected static ?string $model = SalesMan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        // 'full_name', 
        // 'user_id', 
        // 'inventory_id', 
        // 'phone', 
        // 'note'

        return $form
            ->schema([
                Components\TextInput::make('full_name')
                    ->label('full_name')
                    ->minLength(4)
                    ->maxLength(32)
                    ->required(),
                Components\TextInput::make('user_name')
                    ->label('user_name')
                    ->suffix("@ayman.electronics")
                    ->minLength(4)
                    ->maxLength(32)
                    ->required()
                    ->visibleOn('create'),
                Components\TextInput::make('password')
                    ->label('password')
                    ->password()
                    ->minLength(6)
                    ->maxLength(32)
                    ->required()
                    ->visibleOn('create'),
                Components\TextInput::make('note')
                    ->label('note') 
                    ->maxLength(64),
                Components\Repeater::make('phone')
                    ->label('phone') 
                    ->schema([
                        Components\TextInput::make('phone')
                            ->columnSpanFull()
                            ->telRegex('/^07[0-9]{9}$/')
                            ->required(),
                    ])
                    ->minItems(1),
                    //TODO: MAKE DELETE DISABLED.
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'edit' => Pages\EditSalesMan::route('/{record}/edit'),
        ];
    }
}
