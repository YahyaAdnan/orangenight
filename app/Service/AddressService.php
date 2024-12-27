<?php

namespace App\Service;

use App\Models\CustomerSubser;
use App\Models\Delivery;
use Filament\Forms\Components;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class AddressService
{

    public static function getAddress(Model $model)
    {
        Tables\Actions\Action::make('address')
            ->label(__('address'))
            ->icon('heroicon-s-map-pin')
            ->color(fn($record) => $record->google_map_url == null ? 'danger' : 'info')
            ->disabled(fn($record) => $record->google_map_url == null)
            ->action(fn($record) => redirect()->away($record->google_map_url));
    }
    
    public static function form(Model $model)
    {
        return [
            Components\TextInput::make('address')
                ->required()
                ->maxLength(128)
                ->columnSpanFull()
                ->default($model->address),
            Components\TextInput::make('google_map_url')
                ->label(__('Location URL'))
                ->required()
                ->url()
                ->maxLength(128)
                ->columnSpanFull()
                ->default($model->google_map_url),
        ];
    }

    public static function store(Model $model, $data)
    {
        $model->update([
            'address' => $data['address'],
            'google_map_url' => $data['google_map_url'],
        ]);
        
        if($model->deliveries)
        {
            foreach ($model->deliveries as $key => $delivery) 
            {
                $delivery->update([
                    'address' => $data['address'],
                    'google_map_url' => $data['google_map_url'],
                ]);
            }
        }
    }
}