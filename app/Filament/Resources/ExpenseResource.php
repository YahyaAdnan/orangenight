<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\RelationManagers;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function getNavigationGroup(): string
    {
        return __('financial');
    }

    public static function getPluralModelLabel(): string
    {
        return __('expense');
    }

    public static function getModelLabel(): string
    {
        return __('expense');
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('expense'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('amount')
                    ->label(__('buying_price'))
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('category')
                    ->label(__('category'))
                    ->required()
                    ->options(Expense::categories())
                    ->searchable()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('note')
                    ->label(__('note'))
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('expense'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->label(__('category'))
                    ->formatStateUsing(fn (string $state): string => __("$state")),
                Tables\Columns\TextColumn::make('amount')
                    ->label(__('buying_price'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('note')
                    ->wrap()
                    ->label(__('note'))
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime("d/m/Y")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options(Expense::categories())
                    ->multiple()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    FilamentExportBulkAction::make('export')
                        ->defaultFormat('pdf')
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
