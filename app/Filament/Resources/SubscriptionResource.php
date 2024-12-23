<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionResource\Pages;
use App\Filament\Resources\SubscriptionResource\RelationManagers;
use App\Models\Subscription;
use App\Models\Contract;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('subscription'); 
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make('active')
                    ->label(__('active'))
                    ->default(true)
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),       

                Forms\Components\TextInput::make('price')
                    ->label(__('price'))
                    ->numeric(255)
                    ->minValue(0)
                    ->maxValue(1000000000)
                    ->required(),


                Forms\Components\Textarea::make('description')
                    ->label(__('description'))
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('duration')
                    ->label(__('duration'))
                    ->minValue(7)
                    ->maxValue(730)
                    ->required()
                    ->numeric()
                    ->suffix("Days")
                    ->live(),

                Forms\Components\Select::make('contract_id')
                    ->label(__('contract'))
                    ->required()
                    ->searchable()
                    ->options(Contract::pluck('title', 'id')),

                Forms\Components\Repeater::make('subscriptionTerms')
                    ->label(__('terms'))
                    ->label('Subscription Terms') 
                    ->relationship()
                    ->reorderable(false)
                    ->schema([
                        Forms\Components\Grid::make([
                            'default' => 3,
                            'sm' => 1,
                            'md' => 3,
                        ])
                        ->schema([
                            Forms\Components\Select::make('item_id')
                                ->label(__('item'))
                                ->required()
                                ->searchable()
                                ->options(Item::pluck('title', 'id')),

                            Forms\Components\TextInput::make('quantity')
                                ->label(__('quantity'))
                                ->minValue(1)
                                ->maxValue(1000)
                                ->required()
                                ->numeric(),

                            Forms\Components\TextInput::make('day')
                                ->label(__('day'))
                                ->required()
                                ->numeric()
                                ->minValue(1)
                                ->maxValue(fn (Forms\Get $get) => $get('duration') ?? 730)
                                ->suffix("Day")
                                ->label('Day')
                                ->live()
                        ])
                    ])
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label(__('duration'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contract_id')
                    ->label(__('contract'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
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
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
