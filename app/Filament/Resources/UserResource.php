<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Service\PasswordService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function getNavigationGroup(): string
    {
        return __('users');
    }

    public static function getPluralModelLabel(): string
    {
        return __('users');
    }

    public static function getModelLabel(): string
    {
        return __('user');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make('active')
                    ->label(__('active'))
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('name')
                    ->label(__('full_name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label(__('username'))
                    // ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->label(__('password'))
                    ->minLength(6)
                    ->maxLength(32)
                    ->password()
                    ->revealable()
                    ->visibleOn('create'),
                Forms\Components\TextInput::make('password_confirmation')
                    ->label("")
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->same('password')
                    ->visibleOn('create'),
                Forms\Components\Select::make('roles')
                    ->label(__('roles'))
                    ->multiple()
                    ->columnSpanFull()
                    ->relationship('roles', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('full_name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('email'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('active')
                    ->label(__('active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label(__('roles')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //TODO: add filter for active and non active.
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('reset_password')
                        ->label(__('reset_password'))
                        ->icon('heroicon-s-lock-closed')
                        ->form(fn($record) => PasswordService::form())
                        ->action(fn($record, $data) => PasswordService::reset($record, $data))

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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
