<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Models\Customer;
use App\Models\Document;
use App\Models\Inventory;
use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $inventory = Inventory::create(['title' => $data['full_name']]);

        $customer = Customer::create($data);

        $customer->inventory_id = $inventory->id;
        $customer->save();

        foreach ($data['documents'] as $documentData) 
        {
            $customer->documents()->save( new Document([
                'title' => $documentData['title'],
                'image' => $documentData['image'],
            ]));
        }

        return $customer;
    }
}
