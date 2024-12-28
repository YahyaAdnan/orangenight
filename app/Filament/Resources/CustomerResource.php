<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use App\Models\SalesMan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Coolsam\SignaturePad\Forms\Components\Fields\SignaturePad;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('customers');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('full_name')
                    ->label(__('full_name')) 
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address') 
                    ->label(__('address')) 
                    ->required()
                    ->maxLength(255),
                Forms\Components\Repeater::make('phone')
                    ->label(__('phone')) 
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label(__('phone')) 
                            ->columnSpanFull()
                            ->telRegex('/^07[0-9]{9}$/')
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->minItems(1),
                Forms\Components\Repeater::make('documents')
                    ->label(__('documents')) 
                    ->relationship()
                    ->schema([
                        Forms\Components\Grid::make([
                            'default' => 2,
                            'sm' => 1,
                            'md' => 2,
                        ])
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label(__('title')) 
                                ->maxLength(32)
                                ->required(),
                            Forms\Components\FileUpload::make('image')
                                ->label(__('image')) 
                                ->required()
                                ->image()
                        ])
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('salesMen')
                    ->label(__('sales_men'))
                    ->multiple()
                    ->options(SalesMan::pluck('full_name', 'id'))
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('note')
                    ->label(_('note'))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label(__('full_name')) 
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('created_at')) 
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListCustomers::route('/'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
