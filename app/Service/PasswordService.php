<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components;

class PasswordService
{
    public static function form()
    {
        return [
            Components\TextInput::make('password')
                ->label(__('password'))
                ->minLength(6)
                ->maxLength(32)
                ->password()
                ->revealable(),
            Components\TextInput::make('password_confirmation')
                ->label("")
                ->password()
                ->required()
                ->maxLength(255)
                ->same('password'),
        ];
    }

    public static function reset(User $user, $data)
    {
        $user->update([
            'password' => Hash::make($data['password'])
        ]);
    }
}