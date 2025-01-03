<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use Spatie\Permission\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';


    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('view-any Role');
    }

    public static function getNavigationGroup(): string
    {
        return __('users');
    }

    public static function getPluralModelLabel(): string
    {
        return __('roles');
    }

    public static function getModelLabel(): string
    {
        return __('role');
    }


    // public static function canCreate(): bool
    // {
    //     return auth('web')->user()->checkPermissionTo('create Role');
    // }

    // public static function canViewAny(): bool
    // {
    //     return auth('web')->user()->checkPermissionTo('create Role');
    // }

    // public static function canEdit(): bool
    // {
    //     return ;
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('title') . 'test') 
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('permissions')
                    ->multiple()
                    ->columnSpanFull()
                    ->relationship('permissions', 'name')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('title')) 
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                // ->hidden(!auth('web')->user()->checkPermissionTo('update Role')),
            ])
            ->bulkActions([
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
