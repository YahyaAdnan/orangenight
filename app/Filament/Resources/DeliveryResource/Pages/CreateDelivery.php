<?php

namespace App\Filament\Resources\DeliveryResource\Pages;

use App\Filament\Resources\DeliveryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use App\Models\Delivery;

class CreateDelivery extends CreateRecord
{
    protected static string $resource = DeliveryResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return Delivery::create([
            'deliverable_type' => 'App\Models\Customer',
            'deliverable_id' => $data['customer_id'],
            'customer_id' => $data['customer_id'],
            'item_id' => $data['item_id'],
            'quantity' => $data['quantity'],
            'date' => $data['date'],
            'google_map_url' => $data['google_map_url'],
        ]);
    }
}
