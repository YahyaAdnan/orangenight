<?php

namespace App\Filament\Resources;

use App\Service\ImportService;
use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Models\Item;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    public static function getPluralModelLabel(): string
    {
        return __('items'); 
    }

    public static function getModelLabel(): string
    {
        return __('item');
    }
    
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->label(__('image'))
                    ->image()
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->label(__('title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sku')
                    ->label('SKU')
                    ->maxLength(255),
                Forms\Components\TextInput::make('buying_price')
                    ->label(__('buying_price'))
                    ->numeric(255)
                    ->minValue(0)
                    ->maxValue(1000000000)
                    ->required(),
                Forms\Components\TextInput::make('selling_price')
                    ->label(__('selling_price'))
                    ->numeric(255)
                    ->minValue(0)
                    ->maxValue(1000000000)
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->label(__('category'))
                    ->searchable()
                    ->required()
                    ->options(Category::pluck('title', 'id')),
                Forms\Components\TextInput::make('note')
                    ->label(__('note'))
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('image')),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category_id')
                    ->label(__('category'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('note')
                    ->label(__('note'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            // ->filters([
                
            // ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('Import')
                        ->form(fn($records) => ImportService::form($records))
                        ->action(fn(array $data) => ImportService::store($data))
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
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
