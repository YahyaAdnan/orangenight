<?php

namespace App\Filament\Resources\SalesManResource\Pages;

use App\Models\SalesMan;
use App\Models\Inventory;
use App\Models\User;
use App\Filament\Resources\SalesManResource;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class CreateSalesMan extends CreateRecord
{

    protected static string $resource = SalesManResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $inventory = Inventory::create(['title' => $data['full_name']]);

        $user = User::create([
            'name' => $data['full_name'],
            'email' => $data['user_name'] . '@orange.night',
            'password' => Hash::make($data['password']),
        ]);

        return SalesMan::create([
            'full_name' => $data['full_name'], 
            'user_id' => $user->id,
            'inventory_id' => $inventory->id,
            'phone' => $data['phone'],
            'note' => $data['note'],
        ]);
    }
    
}
